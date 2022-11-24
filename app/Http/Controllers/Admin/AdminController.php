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
        $users =  DB::table('users')->count();
        view()->share('users', $users);
        view()->share('menu', 'dashboard');
        return view('admin.dashboard');
    }
    public function profile(){
        return view('admin.profile');
    }
    public function saveSettings(Request $request){
        $data = $request->all();
        return json_encode(array('status' => 1));
    }

    public function saveContact(Request $request){
        $data = $request->all();

        DB::table('settings')->where('key', 'contact_email')->update(['value' => $data['contact_email']]);
        DB::table('settings')->where('key', 'discord_link')->update(['value' => $data['discord_link']]);

        return json_encode(array('status' => 1));
    }
}
