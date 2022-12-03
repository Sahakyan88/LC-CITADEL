<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\ErrorLog;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createServiceOrder($id)
    {
        if (!Auth::check()) {
            return redirect()->to('/login');
        } else {
            //TO DO check is passport uploaded
            $user = User::where('id', Auth::user()->id)->first();
        }

        $lang = App::getLocale() ?? 'en';

        $service = Service::where('id', $id)->first();

        $orderInfo = $this->takeOrderInfo(Order::PENDING_STATUS, $user, $service['price'], $service);

        /************Create Order************/
        $Order = $this->createOrder($orderInfo);

        /**********Data For Payment*******************/
        $paymentInfo = $this->takePaymentInfo((int)$service['price'], $Order->id, $user, $lang, 'one_time_service');

        /************Create Payment************/
            $response_data = $this->createPayment($paymentInfo);

        $response = $response_data['response'];
        $pay = $response_data['pay'];
        /*********************************** */

        if ($response['errorCode'] == 0) {
            try {
                Order::where('id', '=', $paymentInfo['order_id'])->update([
                    'status' => 'paid'
                ]);
            } catch (Exception $e) {
                $this->error_log('Update Order Status', $paymentInfo, 'one_time_service', $e->getMessage());
                return response($e->getMessage(), 500);
            }

//            try {
//                Payment::where('id', '=', $pay['id'])->update([
//                    'order_id' => 'paid'
//                ]);
//            } catch (Exception $e) {
//                $this->error_log('Update Order Status', $paymentInfo, 'one_time_service', $e->getMessage());
//                return response($e->getMessage(), 500);
//            }

            $data['redirect_url'] = $response['formUrl'];
            return redirect($data['redirect_url']);
        }
        $this->error_log('Response errorCode', $response, 'one_time_service', $response['errorCode']);
        return response('Payment was rejected by ARCA!!!', 500);
    }

    private function takeOrderInfo($status, $user, $total_amount, $product): array
    {
        /**********Data For Orders Table*************/
        $orderInfo = [];

        /**********Order's Status*************/
        $orderInfo['status'] = $status;

        /**********Order's User*************/
        $orderInfo['user'] = $user;

        /**********Total Amount*************/
        $orderInfo['total_amount'] = $total_amount * 100;

        /******Order's Products******/
        $orderInfo['product'] = $product;

        /**********Order's Status*************/
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

    private function takePaymentInfo(int $total_amount, $order_id, $user, $lang, $type): array
    {
        /**********Payment Info*********/
        $paymentInfo = [];
        $paymentInfo['total_amount'] = $total_amount * 100;
        $paymentInfo['lang'] = $lang;
        $paymentInfo['user'] = $user;
        $paymentInfo['order_id'] = $order_id;
        $paymentInfo['type'] = $type;
        return $paymentInfo;
    }

    private function createPayment(array $paymentInfo)
    {
        $payment = config('app.payment');
        /********Create Payment*************/
        try {
            $data = [
                'email' => $paymentInfo['user']['email'],
                'type' => $paymentInfo['type'],
                'status' => 'pending',
                'session_id' => session()->getId(),
            ];
            $pay = Payment::create($data);

        } catch (Exception $e) {
            $this->error_log('Create Payment', $paymentInfo, 'one_time_service', $e->getMessage());
            return response($e->getMessage(), 500);
        }
        /************** ******************/
        $query = "userName=" . $payment['ARCA_username'] .
            "&password=" . $payment['ARCA_password'] .
            "&amount=" . (int)$paymentInfo['total_amount'] .
//           /*"&currency=" . 'AMD'*/ .
            "&language=" . 'en' .
            "&orderNumber=" . 111111111111111111111171122229 .
            "&returnUrl=" . $payment['return_url'] .
            "&description=" . 'LC-Citadel';

        /********Action Log*************/
        $this->action_log('Evoca Create Payment Request', $paymentInfo, $paymentInfo['type']);
        $response = Http::get($payment['ARCA_registerUrl'] . '?' . $query);

        /********Action Log*************/
        $this->action_log('Evoca Response', $response, $paymentInfo['type']);
        /************** ******************/


        return ['response' => $response, 'pay' => $pay];
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

    public function action_log($name,  $data, $type)
    {
        return ActionLog::create([
            'name' => $name,
            'data' => $data,
            'type' => $type,
            'session_id' => session()->getId()
        ]);
    }
}
