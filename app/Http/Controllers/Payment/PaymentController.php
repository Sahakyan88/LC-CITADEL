<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\ErrorLog;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createServiceOrder($id)
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
        exit();
        /**********Data For Service*******************/
        $service = Service::where('id', $id)->first();
        /**********Data For Order*******************/
        $orderInfo = $this->takeOrderInfo(Order::PENDING_STATUS, $user, $service);
        /************Create Order************/
        $Order = $this->createOrder($orderInfo);
        /**********Data For Payment*******************/
        $paymentInfo = $this->takePaymentInfo((int)$service['price'], $Order->id, $user['id'], $lang, 'one_time_service');
        /************Create Payment************/
        $response_data = $this->createPayment($paymentInfo, $lang);

        $response = $response_data['response'];
        $pay = $response_data['pay'];

        if ($response['ResponseCode'] === 1) {
            try {
                Payment::where('id', '=', $pay['id'])->update([
                    'ameria_payment_id' => $response['PaymentID']
                ]);
            } catch (Exception $e) {
                $this->error_log('Update PaymentId', $response, 'one_time_service', $e->getMessage());
                return response($e->getMessage(), 500);
            }
            $redirect_url = env('AMERIA_REDIRECT_URL') . "?lang=$lang&id=" . $response['PaymentID'];
            return redirect($redirect_url);
        }
        $this->error_log('Error ResponseCode', $response, 'one_time_service', $response['ResponseCode']);
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

        /******Order's Product******/
        $orderInfo['product_id'] = $product['id'];

        /**********Order's Session*************/
        $orderInfo['session_id'] = session()->getId();

        return $orderInfo;
    }

    private function createOrder(array $orderInfo)
    {
        $this->action_log('Create Order', $orderInfo, 'one_time_service');
        try {
            return Order::create($orderInfo);
        } catch (Exception $e) {
            $this->error_log('Create Order', $orderInfo, 'one_time_service', $e->getMessage());
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
            $this->error_log('Create Payment', $paymentInfo, 'one_time_service', $e->getMessage());
            return response($e->getMessage(), 500);
        }
        $query = [
            "ClientID" => $payment['AmeriaClientID'],
            "Username" => $payment['AmeriaUsername'],
            "Password" => $payment['AmeriaPassword'],
            "Currency" => "AMD",
            "Amount" => (int)$paymentInfo['total_amount'],
            "OrderID" => 2910026,
            "BackURL" => env('APP_URL') . '/payment/checkPayment',
            "Description" => 'LC-CITADEL'
        ];

        /********Action Log For Request*************/
        $this->action_log('Ameria Create Payment Request', $paymentInfo, $paymentInfo['type']);
        $response = Http::post($payment['AmeriaRegisterUrl'], $query);
        /********Action Log For Response*************/
        $this->action_log('Ameria  Payment Response', $response->json(), $paymentInfo['type']);

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
            $this->error_log('Update Order Status', $paymentInfo, 'one_time_service', $e->getMessage());
            return response($e->getMessage(), 500);
        }
        $query = [
            "Username" => $payment_info['AmeriaUsername'],
            "Password" => $payment_info['AmeriaPassword'],
            "PaymentID" => $request['paymentID']
        ];
        /********Action Log For Check Request*************/
        $this->action_log('Ameria Check Payment Request', $payment, $payment['type']);
        $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/GetPaymentDetails', $query);
        $response = $response->json();
        /********Action Log For Check Response*************/
        $this->action_log('Ameria Check Payment Response', $response, $payment['type']);
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
            //TODO SEND TICKET MAIL TO USER  $response = $this->sendTicketsMail($lang, $products, $user, $orderId);

            if ($response) {
                $user = User::where('id', $user)->first();
                $service = Service::where('id', $product)->first();
                return redirect('/am/payment-success')->with(['user' => $user, 'service' => $service]);
            }
        }
        return $response['Description'] ?? [];
    }

    public function payment_success()
    {
        return view('payment.payment_success');
    }
}
