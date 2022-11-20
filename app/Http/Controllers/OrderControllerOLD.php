<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Stripe;
use Session;

class OrderController extends Controller
{
    public function send_verify_email(){
        $random_hash = Hash::make(str_random(5));
    }
    
    public function preOrder(Request $data)
    {
        if(Auth::guard('web')->check()){
            $data->validate([
                'game' => 'in:rune_scape_old,rune_scape',
                'amount' => 'required|min:0.01|max:99999999.99',
                'rsn' => 'required|string',
            ]);
        }
        else{
            $data->validate([
                'game' => 'in:rune_scape_old,rune_scape',
                'amount' => 'required|min:0.01|max:99999999.99',
                'email' => 'email:rfc',//,dns
                'rsn' => 'required|string',
            ]);
        }

        //Rates
        $rates = DB::table('settings')->whereIn('key', ['rso_rate', 'rs_rate'])->get()->keyBy('key');
        $RSO_rateDef = $rates['rso_rate']->value;
        $RS_rateDef = $rates['rs_rate']->value;
        
        $defaultCurrency = currency()->config('default');
        $currentCurrency = currency()->getCurrency();

        if($defaultCurrency != $currentCurrency['code']){
            $RSO_rateCurr = $RSO_rateDef * $currentCurrency['exchange_rate'];
            $RS_rateCurr = $RS_rateDef * $currentCurrency['exchange_rate'];
            $RSO_rateCurr = round($RSO_rateCurr, 2);
            $RS_rateCurr = round($RS_rateCurr, 2);
        }else{
            $RSO_rateCurr = $RSO_rateDef;
            $RS_rateCurr = $RS_rateDef;
        }
        //
        
        if($data['game'] == 'rune_scape_old'){
            $price = $data['amount'] * $RSO_rateCurr;
            $priceUSD = $data['amount'] * $RSO_rateDef;
        }
        if($data['game'] == 'rune_scape'){
            $price = $data['amount'] * $RS_rateCurr;
            $priceUSD = $data['amount'] * $RS_rateDef;
        }

        
        $card = \Session::get('card');
        
        $order = array();

        if(Auth::guard('web')->check()){
            if(isset($card['first_name'])){
                $order['first_name'] = $card['first_name'];
            }
            if(isset($card['last_name'])){
                $order['last_name'] = $card['last_name'];
            }
            $order['email']  = $data['email'];
        }

        if(isset($card['payment'])){
            $order['payment'] = $card['payment'];
        }

        $order['game'] = $data['game'];
        $order['rsn'] = $data['rsn'];
        $order['amount'] = $data['amount'];
        $order['currency_code'] = $currentCurrency['code'];
        $order['price'] = number_format($price, 2, '.', '');
        
        \Session::put('card', $order);

        return redirect()->route('checkout');
    }

    public function order(Request $data){
        $card = \Session::get('card');

        $data['amount'] = $card['amount'];
        $data['game'] = $card['game'];
        $data['currency_code'] = $card['currency_code'];

        if(Auth::guard('web')->check()){
            $validated = $data->validate([
                'payment' => 'in:g2a,coinbase',
                'game' => 'in:rune_scape_old,rune_scape',
                'currency_code' => 'required|string',
                'amount' => 'required|min:0.01|max:99999999.99',
                'rsn' => 'required|string'
            ]);
        }
        else{
            $validated = $data->validate([
                'payment' => 'in:g2a,coinbase',
                'game' => 'in:rune_scape_old,rune_scape',
                'currency_code' => 'required|string',
                'amount' => 'required|min:0.01|max:99999999.99',
                'email' => 'email:rfc',//,dns
                'rsn' => 'required|string',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
            ]);
        }
        
        
        //Rates
        $rates = DB::table('settings')->whereIn('key', ['rso_rate', 'rs_rate'])->get()->keyBy('key');
        $RSO_rateDef = $rates['rso_rate']->value;
        $RS_rateDef = $rates['rs_rate']->value;
        
        $defaultCurrency = currency()->config('default');
        $currentCurrency = currency()->getCurrency($data['currency_code']);
        
        
        if($defaultCurrency != $currentCurrency['code']){
            $RSO_rateCurr = $RSO_rateDef * $currentCurrency['exchange_rate'];
            $RS_rateCurr = $RS_rateDef * $currentCurrency['exchange_rate'];
            $RSO_rateCurr = round($RSO_rateCurr, 2);
            $RS_rateCurr = round($RS_rateCurr, 2);
        }else{
            $RSO_rateCurr = $RSO_rateDef;
            $RS_rateCurr = $RS_rateDef;
        }
        //
        
        if($data['game'] == 'rune_scape_old'){
            $price = $data['amount'] * $RSO_rateCurr;
            $priceUSD = $data['amount'] * $RSO_rateDef;
        }
        if($data['game'] == 'rune_scape'){
            $price = $data['amount'] * $RS_rateCurr;
            $priceUSD = $data['amount'] * $RS_rateDef;
        }

        $card = \Session::get('card');
        
        $order = array();
        $order['amount'] = $card['amount'];
        $order['currency_code'] = $card['currency_code'];
        $order['game'] = $card['game'];
        
        $order['payment'] = $data['payment'];
        if(Auth::guard('web')->check()){
            $order['user_id'] = Auth::guard('web')->user()->id;
            $order['first_name'] = Auth::guard('web')->user()->first_name;
            $order['last_name'] = Auth::guard('web')->user()->last_name;
            $order['email']  = Auth::guard('web')->user()->email;
        }else{
            $order['first_name'] = $data['first_name'];
            $order['last_name'] = $data['last_name'];
            $order['email']  = $data['email'];     
        }
        $order['rsn'] = $data['rsn'];
        $order['price'] = number_format($price, 2, '.', '');
        $order['price_usd'] = number_format($priceUSD, 2, '.', '');
        
        $order = Order::create($order);
        if($order){
            \Session::forget('card');
        }

        /// Create Redirect
        if($data['game'] == 'rune_scape_old'){
            $title = "Rune scape old scool - (".$order['amount'].") coins";
        }
        if($data['game'] == 'rune_scape'){
            $title = "Rune scape - (".$order['amount'].") coins";
        }

        $siteUrl = ENV('APP_URL');
        
        Stripe\Stripe::setApiKey(ENV('STRIPE_SECRET'));

        $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
            'currency' => $order['currency_code'],
            'unit_amount_decimal' => $order['price'] * 100,
            'product_data' => [
                'name' => $title
            ],
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $siteUrl . '/success',
        'cancel_url' => $siteUrl . '/cancel',
        ]);
        
        $order->payment_intent = $checkout_session->payment_intent;
        $order->save();
        return json_encode(array('status' => 1, 'session_id'=>$checkout_session->id));
    }

    public function checkout(){
        $card = \Session::get('card');
        if(!$card){
            return redirect()->route('homepage');
        }
        view()->share('card', $card);

        return view('app.checkout');
    }

    public function checkout_success(){    
        return view('app.checkout_success');   
    }
    
    public function checkout_fail(){    
        return view('app.checkout_fail');   
    }

    public function clearCard(Request $data){
        \Session::forget('card');
        return redirect()->route('homepage');
    }

    public function orders(){
        $orders = Order::where('user_id',Auth::guard('web')->user()->id)->get();

        view()->share('orders', $orders);
        return view('app.orders');
    }

    public function updateStatus(){
        $endpoint_secret = ENV('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        if ($event->type == "payment_intent.succeeded") {
            $intent = $event->data->object;
            printf("Succeeded: %s", $intent->id);
            Order::where('payment_intent', $intent->id)->update(['status' => 'paid']);
            http_response_code(200);
            exit();
        } elseif ($event->type == "payment_intent.payment_failed") {
            $intent = $event->data->object;
            Order::where('payment_intent', $intent->id)->update(['status' => 'fail']);
            $error_message = $intent->last_payment_error ? $intent->last_payment_error->message : "";
            printf("Failed: %s, %s", $intent->id, $error_message);
            http_response_code(200);
            exit();
        } elseif ($event->type == "payment_intent.canceled") {
            $intent = $event->data->object;
            Order::where('payment_intent', $intent->id)->update(['status' => 'cancel']);
            printf("Canceled: %s", $intent->id);
            http_response_code(200);
            exit();   
        }
        
    }
}
