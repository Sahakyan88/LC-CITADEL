<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Card;
use App\Models\ErrorLog;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
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
            if($user['pay_allowed'] == 0){
                return redirect()->to("/$lang/contract");
            }
        }
        /**********Data For Order*******************/
        $service = Service::where('id', $id)->first();

        $orderInfo = $this->takeOrderInfo(Order::PENDING_STATUS, $user, $service);

        /************Create Order************/
        $Order = $this->createOrder($orderInfo);
        /**********Data For Payment*******************/
        $paymentInfo = $this->takePaymentInfo((int)$service['price'], $Order->id, $user['id'], $lang, 'package');

        /************Create Payment************/
        $response_data = $this->createPayment($paymentInfo, $lang);
        $response = $response_data['response'];
        $pay = $response_data['pay'];
        /*********************************** */
        if ($response['ResponseCode'] === 1) {
            try {
                Payment::where('id', '=', $pay['id'])->update([
                    'ameria_payment_id' => $response['PaymentID']
                ]);
            } catch (Exception $e) {
                $this->error_log('Update PaymentId', $response, 'package', $e->getMessage());
                return response($e->getMessage(), 500);
            }
            $redirect_url = env('AMERIA_REDIRECT_URL') . "?lang=$lang&id=" . $response['PaymentID'];
            return redirect($redirect_url);
        }
        $this->error_log('Error ResponseCode', $response, 'package', $response['ResponseCode']);
        return response('Payment was rejected by AMERIA!!!', 500);
    }

    private function takeOrderInfo($status, $user, $product): array
    {
        /**********Data For Orders Table*************/
        $orderInfo = [];

        /**********Order's Status*************/
        $orderInfo['status'] = $status;

        /**********Order's User*************/
        $orderInfo['user_id'] = $user['id'];

        /**********Total Amount*************/
        $orderInfo['total_amount'] = $product['price'];

        /******Order's Products******/
        $orderInfo['product_id'] = $product['id'];

        /**********Order's Status*************/
        $orderInfo['session_id'] = session()->getId();

        return $orderInfo;
    }

    private function createOrder(array $orderInfo)
    {
        $this->action_log('Create Order', $orderInfo, 'package');
        try {
            return Order::create($orderInfo);
        } catch (Exception $e) {
            $this->error_log('Create Order', $orderInfo, 'package', $e->getMessage());
            return response('Something Went Wrong!!', 500);
        }
    }

    private function takePaymentInfo(int $total_amount, $order_id, $user_id, $lang, $type): array
    {
        /**********Payment Info*********/
        $paymentInfo = [];
        $paymentInfo['total_amount'] = $total_amount;
        $paymentInfo['lang'] = $lang;
        $paymentInfo['user_id'] = $user_id;
        $paymentInfo['order_id'] = $order_id;
        $paymentInfo['type'] = $type;
        return $paymentInfo;
    }

    private function createPayment(array $paymentInfo, $lang)
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
            $this->error_log('Create Payment', $paymentInfo, 'package', $e->getMessage());
            return response($e->getMessage(), 500);
        }

        $query = [
            "ClientID" => $payment['AmeriaClientID'],
            "Username" => $payment['AmeriaUsername'],
            "Password" => $payment['AmeriaPassword'],
            "Currency" => "AMD",
            "Amount" => (int)$paymentInfo['total_amount'],
            "OrderID" => 2910052,
            "BackURL" => env('APP_URL') . '/payment/checkSubscription',
            "Description" => 'LC-CITADEL',
            "CardHolderID" => 'ele585b2tc3cev45f5ra43pg521f70lf028f',
        ];
//        /********Save card info for binding*************/
        Card::create([
            'user_id'=>\auth()->user()->id,
            'card_holder_id'=>'ele585b2tc3cev45f5ra43pg521f70lf028f'
        ]);
        $this->action_log('Ameria Create Payment Request', $paymentInfo, $paymentInfo['type']);
        /************** ******************/
        $response = Http::post($payment['AmeriaRegisterUrl'], $query);
        /********Action Log*************/
        $this->action_log('Ameria  Payment Response', $response->json(), $paymentInfo['type']);
        /************** ******************/
        return ['response' => $response->json(), 'pay' => $pay];
    }

    private function error_log($name, $data, $type, $error)
    {
        return ErrorLog::create([
            'name' => $name,
            'data' => $data,
            'type' => $type,
            'error' => $error,
            'session_id' => session()->getId()
        ]);
    }

    public function action_log($name, $data, $type)
    {
        return ActionLog::create([
            'name' => $name,
            'data' => $data,
            'type' => $type,
            'session_id' => session()->getId()
        ]);
    }

    public function checkSubscription(Request $request)
    {
        $lang = app()->getLocale() ?? 'am';
        $payment_info = config('app.payment');
        $payment = Payment::where('ameria_payment_id', '=', $request['paymentID'])->first();
        $Order = Order::where('session_id', '=', $payment['session_id'])->orderBy('created_at', 'desc')->first();
        $product = $Order['product_id'];
        $user = $Order['user_id'];

        $query = [
            "Username" => $payment_info['AmeriaUsername'],
            "Password" => $payment_info['AmeriaPassword'],
            "PaymentID" => $request['paymentID']
        ];
        $this->action_log('Ameria Check Payment Request', $payment, $payment['type']);
        $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/GetPaymentDetails', $query);
        $response = $response->json();
        $this->action_log('Ameria Check Payment Response', $response, $payment['type']);
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
                'paid_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            //TODO SEND TICKET MAIL TO USER  $response = $this->sendTicketsMail($lang, $products, $user, $orderId);

            if ($response) {
                $user = User::where('id', $user)->first();
                $service = Service::where('id', $product)->first();
                return redirect('/am/payment-success')->with(['user' => $user, 'service' => $service]);
            }
        }

        return abort(500);
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

//        /********Deactivate binding************* IT WORKS*/
////        {
////            "ResponseCode": "00",
////              "ResponseMessage": "Transaction Completed",
////             "CardHolderID": "ele585b2tc3cev45f5ra43pg521f70lf028f"
////}
//        $query1 = [
//            "ClientID" => $payment['AmeriaClientID'],
//            "Username" => $payment['AmeriaUsername'],
//            "Password" => $payment['AmeriaPassword'],
//            "PaymentType" => 6, "CardHolderID" => 'ele585b2tc3cev45f5ra43pg521f70lf028f',
//        ];
//        $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/DeactivateBinding', $query1);
//        return $response = $response->json();
//        /*********************************/
   }
   public function cancelRequest(Request $request){
    dd($request->all());

   }
}
