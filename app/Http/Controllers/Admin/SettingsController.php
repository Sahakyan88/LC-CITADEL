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


class SettingsController extends Controller
{
    public function settings(){
        $data = Settings::where('key','sait_settings')->first()->value;//find(2)->value;
        $data=json_decode($data);
        view()->share('menu', 'settings');
        return view('admin.settings',compact('data'));
    }
    public function updateSettings(){
        $data=request()->validate([
            'email'=>'string',
            'phone'=>'string',
            'address'=>'string',
            'fax'=>'string',
            'facebook'=>'string',
            'twitter'=>'string',
        ]);
        $data1=Settings::where('key','sait_settings')->first();//find(2);
        $data1->update([
            "value"=>$data
        ]);
        return json_encode(array('status' => 1));
    }
}
