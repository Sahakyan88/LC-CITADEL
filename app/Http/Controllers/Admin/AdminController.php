<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $users      =  DB::table('users')->count();
        $service    =  DB::table('services')->count();
        $team       =  DB::table('teams')->count();
        $payment    =  DB::table('orders')->where('status','completed')->count();

        view()->share('users', $users);
        view()->share('payment', $payment);
        view()->share('team', $team);
        view()->share('service', $service);

        view()->share('menu', 'dashboard');
        return view('admin.dashboard');
    }
    public function profile(){
        return view('admin.profile');
    }
}
