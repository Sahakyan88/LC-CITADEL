<?php

namespace App\Services;

use App\Models\ActionLog;
use App\Models\ErrorLog;
use App\Models\Order;
use Exception;

class PaymentService
{
    public function takeOrderInfo($status, $user, $product): array
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

    public function createOrder(array $orderInfo, $type)
    {
        $this->action_log('Create Order', $orderInfo, $type);
        try {
            return Order::create($orderInfo);
        } catch (Exception $e) {
            $this->error_log('Create Order', $orderInfo, $type, $e->getMessage());
            return response('Something Went Wrong!!', 500);
        }
    }

    public function error_log($name, $data, $type, $error)
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

    public function takePaymentInfo(int $total_amount, $order_id, $user_id, $lang, $type): array
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
}
