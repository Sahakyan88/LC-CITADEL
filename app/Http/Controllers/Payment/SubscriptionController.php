<?php
/** Payment for packages adn subscriptions
 */
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Card;
use App\Models\ErrorLog;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use App\Services\PaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createPackageOrder($id)
    {
        if (!Auth::check()) {
            return redirect()->to('/login');
        } else {
            $lang = App::getLocale() ?? 'en';
            $user = User::where('id', Auth::user()->id)->first();
            if ($user['image_id'] == null) {
                return redirect()->to("/$lang/passport");
            }
            $checkContract = DB::table('contract_user')->where('user_id',$user['id'])->first();
            if(!$checkContract || ($checkContract->pay_allowed != 1)){
                $service = Service::where('id', $id)->first(['file_id']);
                $file_id = $service->file_id;
                return redirect()->to("/am/contract/$file_id");
            }
        }
        /**********Data For Order*******************/
        $service = Service::where('id', $id)->first();
        $orderInfo = $this->paymentService->takeOrderInfo(Order::PENDING_STATUS, $user, $service);
        /************Create Order************/
        $Order = $this->paymentService->createOrder($orderInfo, 'package');
        /**********Data For Payment*******************/
        $paymentInfo = $this->paymentService->takePaymentInfo((int)$service['price'], $Order->id, $user['id'], $lang, 'package');
        /************Create Payment************/
        $response_data = $this->createPayment($paymentInfo,$id);
        $response = $response_data['response'];
        $pay = $response_data['pay'];
        /*********************************** */
        if ($response['ResponseCode'] === 1) {
            try {
                Payment::where('id', '=', $pay['id'])->update([
                    'ameria_payment_id' => $response['PaymentID']
                ]);
            } catch (Exception $e) {
                $this->paymentService->error_log('Update PaymentId', $response, 'package', $e->getMessage());
                return response($e->getMessage(), 500);
            }
            $redirect_url = 'https://servicestest.ameriabank.am/VPOS/Payments/Pay' . "?lang=$lang&id=" . $response['PaymentID'];
            return redirect($redirect_url);
        }
        $this->paymentService->error_log('Error ResponseCode', $response, 'package', $response['ResponseCode']);
        return response('Payment was rejected by AMERIA!!!', 500);
    }

    private function createPayment(array $paymentInfo,$service_id)
    {
        /********Create Payment*************/
        $payment = config('app.payment');
        try {
            $data = [
                'order_id' => $paymentInfo['order_id'],
                'type' => $paymentInfo['type'],
                'status' => 'pending',
                'session_id' => session()->getId(),
            ];
            $pay = Payment::create($data);
        } catch (Exception $e) {
            $this->paymentService->error_log('Create Payment', $paymentInfo, 'package', $e->getMessage());
            return response($e->getMessage(), 500);
        }
        $query = [
            "ClientID" => $payment['AmeriaClientID'],
            "Username" => $payment['AmeriaUsername'],
            "Password" => $payment['AmeriaPassword'],
            "Currency" => "AMD",
            "Amount" => (int)$paymentInfo['total_amount'],
            "OrderID" => 2910057,
            "BackURL" => env('APP_URL') . '/payment/checkSubscription',
            "Description" => 'LC-CITADEL',
            "CardHolderID" => 'ele585b2tc3cev45f5ra43pg581f70lf02aa',
        ];
//        /********Save card info for binding*************/
        Card::create([
            'user_id' => \auth()->user()->id,
            'card_holder_id' => 'ele585b2tc3cev45f5ra43pg581f70lf02aa',
            'service_id'=>$service_id
        ]);
        $this->paymentService->action_log('Ameria Create Payment Request', $paymentInfo, $paymentInfo['type']);
        /************** ******************/
        $response = Http::post($payment['AmeriaRegisterUrl'], $query);
        /********Action Log*************/
        $this->paymentService->action_log('Ameria  Payment Response', $response->json(), $paymentInfo['type']);
        /************** ******************/
        return ['response' => $response->json(), 'pay' => $pay];
    }

    public function checkSubscription(Request $request)
    {
        $lang = app()->getLocale() ?? 'am';
        $payment_info = config('app.payment');
        $payment = Payment::where('ameria_payment_id', '=', $request['paymentID'])->first();
        $Order = Order::where('session_id', '=', $payment['session_id'])->orderBy('created_at', 'desc')->first();
        $product = $Order['product_id'];
        $user = $Order['user_id'];
        try {
            Order::where('id', '=', $Order['id'])->update([
                'status' => 'paid'
            ]);
        } catch (Exception $e) {
            $paymentInfo = [];
            $paymentInfo['total_amount'] = $Order['total_amount'];
            $paymentInfo['lang'] = $lang;
            $paymentInfo['user_id'] = $Order['user_id'];
            $paymentInfo['order_id'] = $Order['id'];
            $paymentInfo['type'] = 'package';
            $this->paymentService->error_log('Update Order Status', $paymentInfo, 'package', $e->getMessage());
            return response($e->getMessage(), 500);
        }
        $query = [
            "Username" => $payment_info['AmeriaUsername'],
            "Password" => $payment_info['AmeriaPassword'],
            "PaymentID" => $request['paymentID']
        ];
        $this->paymentService->action_log('Ameria Check Payment Request', $payment, $payment['type']);
        $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/GetPaymentDetails', $query);
        $response = $response->json();
        $this->paymentService->action_log('Ameria Check Payment Response', $response, $payment['type']);
        if (isset($response['ResponseCode']) && $response['ResponseCode'] == '00') {
            Payment::where('id', $payment->id)->update([
                'status' => 'approved'
            ]);
            Order::where('id', $Order['id'])->update([
                'status' => Order::COMPLETED_STATUS
            ]);
            DB::table('package_user')->insert([
                'user_id' => $user,
                'package_id' => $product,
                'paid_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            if ($response) {
                return redirect("/$lang/payment-success");
            }
        }
        return $response['Description'] ?? [];
    }

    public function bill()
    {
        /********Pay monthly subscription************* IT WORKS*/
        $payment = config('app.payment');
//        $query = [
//            "ClientID" => $payment['AmeriaClientID'],
//            "Username" => $payment['AmeriaUsername'],
//            "Password" => $payment['AmeriaPassword'],
//            "Currency" => "AMD",
//            "Amount" => 10,
//            "OrderID" => 2910054,
//            "BackURL" => env('APP_URL') . '/payment/checkSubscription',
//            "Description" => 'LC-CITADEL',
//            "CardHolderID" => 'ele585b2tc3cev45f5ra43pg521f70lf028f',
//            "PaymentType" => 6
//        ];
//
//        $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/MakeBindingPayment', $query);
//        $response =  $response->json();
//        /************** ******************/
//
//        /********Get binding payment history************* IT WORKS*/
//        $query1 = [
//            "ClientID" => $payment['AmeriaClientID'],
//            "Username" => $payment['AmeriaUsername'],
//            "Password" => $payment['AmeriaPassword'],
//            "PaymentType" => 6
//        ];
//        $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/GetBindings', $query1);
//        $response = $response->json();
        /*********************************/

        /********Activate binding************* IT WORKS*/
//        {
//            "ResponseCode": "02",
//            "ResponseMessage": "Binding is already enable/disable, change doesn't need",
//            "CardHolderID": ""
//        }
        $query1 = [
            "ClientID" => $payment['AmeriaClientID'],
            "Username" => $payment['AmeriaUsername'],
            "Password" => $payment['AmeriaPassword'],
            "PaymentType" => 6, "CardHolderID" => 'ele585b2tc3cev45f5ra43pg521f70lf028f',
        ];
        $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/ActivateBinding', $query1);
        return $response = $response->json();
        /*********************************/
    }

    public function cancelRequest(Request $request)
    {
        dd($request->all());

    }

    /********Deactivate binding**************/
    public function deactivate(Request $request)
    {
//            "ResponseCode": "00",
//              "ResponseMessage": "Transaction Completed",
//             "CardHolderID": "ele585b2tc3cev45f5ra43pg521f70lf028f"
//}
        $payment = config('app.payment');
        $data = DB::table('package_user')->where('package_user.id', $request['package_user_id'])
            ->select('users.id as user_id', 'cards.card_holder_id', 'package_user.id')
            ->join('users', 'package_user.user_id', '=', 'users.id')
            ->join('cards', 'users.id', '=', 'cards.user_id')
            ->join('services', 'package_user.package_id', '=', 'services.id')
            ->where('cards.package_id','=', $request['package_id'])->get();
        $query1 = [
            "ClientID" => $payment['AmeriaClientID'],
            "Username" => $payment['AmeriaUsername'],
            "Password" => $payment['AmeriaPassword'],
            "PaymentType" => 6,
            "CardHolderID" => $data[0]->card_holder_id
        ];
        $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/DeactivateBinding', $query1);
        $response = $response->json();
        if ($response['ResponseCode'] == '00') {
            DB::table('package_user')->where('id', $request['package_user_id'])->update([
                'deactivated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'is_blocked' => 1
            ]);
            $this->paymentService->action_log('Deactivate Response', $response, 'package');
            return json_encode(array('status' => 1));
        } else {
            $this->paymentService->error_log('Deactivate Response', $response, 'package',$response['ResponseMessage']);
            return json_encode(array('status' => 0)) ;
        }
    }

    public function createPackageOrderget($id)
    {
        return $this->createPackageOrder($id);
    }
}
