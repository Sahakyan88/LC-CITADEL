<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function settings(){
        $data = Settings::where('key','sait_settings')->first()->value;
        $data=json_decode($data);
        view()->share('menu', 'settings');
        return view('admin.settings',compact('data'));
    }
    public function updateSettings(Request $request){
        $data =$request->all();
            $toSave = array('facebook'=>$data['facebook'],
                            'instagram'=> $data['instagram'],
                            'address_en' => $data['address_en'],
                            'address_ru' => $data['address_ru'],
                            'address_am' => $data['address_am'],
                            'phone' => $data['phone'],
                            'enail' => $data['email']
            );
             
            $toSave=Settings::where('key','sait_settings')->first();
            $toSave->update([
                "value"=>$data
            ]);
            return json_encode(array('status' => 1));
    }
}
