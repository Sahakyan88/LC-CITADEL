<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckUserSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:subscriptionCheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = \Carbon\Carbon::today()->subDays(30);
        $payments = DB::table('package_user')
            ->where('deactivated_at', null)
            ->join('users', 'users.id', '=', 'package_user.user_id')
            ->join('services', 'services.id', '=', 'package_user.package_id')
            ->join('cards', function ($join) {
                $join->on('package_user.package_id', '=', 'cards.package_id');
                $join->on('package_user.user_id', '=', 'cards.user_id');
            })
            ->where('last_paid_at', '>=', $date)
            ->select('package_user.*', 'cards.card_holder_id', 'services.price')
            ->get();

        $last_order = Order::orderBy('created_at', 'desc')->first();
        if(!$last_order){
            $last_order_id = 1;
        }else{
            $last_order_id = $last_order['id'];
        }

        if (count($payments) > 0) {
            foreach ($payments as $i => $payment_info) {
                $payment_info = (array)$payment_info;
                $payment = config('app.payment');
                $query = [
                    "ClientID" => $payment['AmeriaClientID'],
                    "Username" => $payment['AmeriaUsername'],
                    "Password" => $payment['AmeriaPassword'],
                    "Currency" => "AMD",
                    "Amount" => (int)$payment_info['price'],
                    "OrderID" => ($last_order_id + 1) + $i,
                    "BackURL" => env('APP_URL') . '/payment/checkSubscription',
                    "Description" => 'LC-CITADEL',
                    "CardHolderID" => $payment_info['card_holder_id'],
                    "PaymentType" => 6
                ];

              Order::insert([
                    'user_id' => $payment_info['user_id'],
                    'product_id' => $payment_info['package_id'],
                    'status' => 'pending',
                    'total_amount' => $payment_info['price'],
                    'session_id' => session()->getId(),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                $response = Http::post('https://servicestest.ameriabank.am/VPOS/api/VPOS/MakeBindingPayment', $query);
                $response = $response->json();
                if ($response['ResponseCode'] == '00') {
                    (new \App\Services\PaymentService)->action_log('Binding Monthly Payment Request', $query, 'package');
                    DB::table('package_user')->where('id', '=', $payment_info['id'])->update([
                            'last_paid_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'is_blocked' => 0 ]
                    );
                }else{
                    (new \App\Services\PaymentService)->error_log('Binding Error ResponseCode', $response, 'package', "id_{$payment_info['id']}");
                    DB::table('package_user')->where('id', '=', $payment_info['id'])->update(['is_blocked' => 1 ]);
                }
            }
        } else {
            return "all payments are done on time";
        }

    }
}
