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
        $price1 = Settings::where('key','price1')->first()->value;
        $price2=Settings::where('key','price2')->first()->value;
        view()->share('menu', 'settings');
        return view('admin.settings',compact('data','price1','price2'));
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
    public function updateSettingsPrice(){
        $data=request()->validate([
            'inputPrice1'=>'int',
            'inputPrice2'=>'int',
        ]);
        $dataPrice1 = Settings::where('key','price1')->first();
        $dataPrice2 = Settings::where('key','price2')->first();
        $dataPrice1->update([
            'value'=>$data['inputPrice1']
        ]);
        $dataPrice2->update([
            'value'=>$data['inputPrice2']
        ]);

        return json_encode(array('status' => 1));
    }
}
