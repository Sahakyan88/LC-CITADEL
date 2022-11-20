<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Admin\Settings;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(Request $request, Redirector $redirector)
    {
        $this->request = $request;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // $logs = Log::orderByDesc('id')->limit(7)->get();

        // foreach($logs as $k => $l){
        //     $l->humanTime = Carbon::createFromFormat('Y-m-d H:i:s', $l->created_at)->diffForHumans(null, true);
        // }

        $users =  DB::table('users')->count();
        // $services =  DB::table('services')->whereNull('deleted_at')->count();
        // // $pending =  DB::table('users')->where('verify','pending')->count();
        // $orders =  DB::table('orders')->where('status','approved')->count();

        // view()->share('services', $services);
        // view()->share('pending', $pending);
        view()->share('users', $users);
        // view()->share('orders', $orders);

        // view()->share('logs', $logs);
        view()->share('menu', 'dashboard');
        return view('admin.dashboard');
    }

    public function profile(){
        return view('admin.profile');
    }

//    public function settings(){
//         $data = Settings::find(1);//->whereIn('key', ['rso_rate', 'rs_rate', 'contact_email', 'discord_link'])->get()->keyBy('key');
//        // $RSO_rate = $data['rso_rate']->value;
//        // $RS_rate = $data['rs_rate']->value;
//        // $contact_email = $data['contact_email']->value;
//        // $discord_link  = $data['discord_link']->value;
//
//        // view()->share('RSO_rate', $RSO_rate);
//        // view()->share('RS_rate', $RS_rate);
//        // view()->share('contact_email', $contact_email);
//        // view()->share('discord_link', $discord_link);
//        // view()->share('menu', 'settings');
//        //return view('admin.settings');
//        //return  $data;
//
//        //dd('test');
//        return $data;
//    }
//    public function updateSettings(){
//        $data=Settings::find(2);//where('key','sayt_settings')->first();
//        $data->update([
//            "value"=>'11111'
//        ]);
//
//    }

    public function saveSettings(Request $request){
        $data = $request->all();

        // DB::table('settings')->where('key', 'rso_rate')->update(['value' => $data['rso_rate']]);
        // DB::table('settings')->where('key', 'rs_rate')->update(['value' => $data['rs_rate']]);

        return json_encode(array('status' => 1));
    }

    public function saveContact(Request $request){
        $data = $request->all();

        DB::table('settings')->where('key', 'contact_email')->update(['value' => $data['contact_email']]);
        DB::table('settings')->where('key', 'discord_link')->update(['value' => $data['discord_link']]);

        return json_encode(array('status' => 1));
    }
}
