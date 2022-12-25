<?php
/** Payment for one time services
 */
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\Payment;
use App\Services\PaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService){
        $this->paymentService = $paymentService;
    }
    public function createServiceOrder($id)
    {
        if (!Auth::check()) {
            return redirect()->to('/login');
        } else {
            $lang = App::getLocale() ?? 'am';
            $user = User::where('id', Auth::user()->id)->first();
            if ($user['image_id'] == null) {
                return redirect()->to("/am/passport");
            }
            $checkContract = DB::table('contract_user')->where('user_id',$user['id'])->where('service_id', $id)->first();
            if(!$checkContract || ($checkContract->pay_allowed != 1)){
                $service = Service::where('id', $id)->first(['file_id']);
                $file_id = $service->file_id;
                return redirect()->to("/am/contract/$file_id");
            }
        }
        /**********Data For Service*******************/
        $service = Service::where('id', $id)->first();
        /**********Data For Order*******************/
        $orderInfo = $this->paymentService->takeOrderInfo(Order::PENDING_STATUS, $user, $service);
        /************Create Order************/
        $Order = $this->paymentService->createOrder($orderInfo,'one_time_service');
        /**********Data For Payment*******************/
        $paymentInfo = $this->paymentService->takePaymentInfo((int)$service['price'], $Order->id, $user['id'], $lang, 'one_time_service');
        /************Create Payment************/
        $response_data = $this->createPayment($paymentInfo);
        $response = $response_data['response'];
        $pay = $response_data['pay'];

        if ($response['ResponseCode'] === 1) {
            try {
                Payment::where('id', '=', $pay['id'])->update([
                    'ameria_payment_id' => $response['PaymentID']
                ]);
            } catch (Exception $e) {
                $this->paymentService->error_log('Update PaymentId', $response, 'one_time_service', $e->getMessage());
                return response($e->getMessage(), 500);
            }

            $redirect_url = 'https://servicestest.ameriabank.am/VPOS/Payments/Pay' . "?lang=$lang&id=" . $response['PaymentID'];
            return redirect($redirect_url);
        }
        $this->paymentService->error_log('Error ResponseCode', $response, 'one_time_service', $response['ResponseCode']);
        return response('Payment was rejected by AMERIA!!!', 500);
    }

    private function createPayment(array $paymentInfo)
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
            $this->paymentService->error_log('Create Payment', $paymentInfo, 'one_time_service', $e->getMessage());
            return response($e->getMessage(), 500);
        }
        $query = [
            "ClientID" => $payment['AmeriaClientID'],
            "Username" => $payment['AmeriaUsername'],
            "Password" => $payment['AmeriaPassword'],
            "Currency" => "AMD",
            "Amount" => (int)$paymentInfo['total_amount'],
            "OrderID" => 2910032,
            "BackURL" => env('APP_URL') . '/payment/checkPayment',
            "Description" => 'LC-CITADEL'
        ];
        /********Action Log For Request*************/
        $this->paymentService->action_log('Ameria Create Payment Request', $paymentInfo, $paymentInfo['type']);
        $response = Http::post($payment['AmeriaRegisterUrl'], $query);
        /********Action Log For Response*************/
        $this->paymentService->action_log('Ameria  Payment Response', $response->json(), $paymentInfo['type']);
        return ['response' => $response->json(), 'pay' => $pay];
    }

    public function checkPayment(Request $request)
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
            $paymentInfo['type'] = 'one_time_service';
            $this->paymentService->error_log('Update Order Status', $paymentInfo, 'one_time_service', $e->getMessage());
            return response($e->getMessage(), 500);
        }
        $query = [
            "Username" => $payment_info['AmeriaUsername'],
            "Password" => $payment_info['AmeriaPassword'],
            "PaymentID" => $request['paymentID']
        ];
        /********Action Log For Check Request*************/
        $this->paymentService->action_log('Ameria Check Payment Request', $payment, $payment['type']);
        $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/GetPaymentDetails', $query);
        $response = $response->json();
        /********Action Log For Check Response*************/
        $this->paymentService->action_log('Ameria Check Payment Response', $response, $payment['type']);
        if (isset($response['ResponseCode']) && $response['ResponseCode'] == '00') {
            Payment::where('id', $payment->id)->update([
                'status' => 'approved'
            ]);
            Order::where('id', $Order['id'])->update([
                'status' => Order::COMPLETED_STATUS
            ]);
            DB::table('service_user')->insert([
                'user_id' => $user,
                'service_id' => $product,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            if ($response) {
                return redirect("/$lang/payment-success");
            }
        }
        return $response['Description'] ?? [];
    }

    public function payment_success()
    {
        return view('payment.payment_success');
    }

    public function createServiceOrderget($id){
        return $this->createServiceOrder($id);
    }
}
