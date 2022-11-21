<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Admin\Settings;
use App\Models\Requests;
use App\Models\Doc;
use App;
use App\Models\Admin\slider;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use PDF;
use Mail;

class WelcomeController extends Controller
{
    public function homepage()
    {
        $lang = App::getLocale();
       
        $faq    =  DB::table('faq')->where('published',1)->get();
        $faq = DB::table('faq')
        ->select(
            'faq.question_'.$lang.' as question','faq.answer_'.$lang.' as answer',
        )
        ->where('faq.published', 1)
        ->orderBy('published', 'DESC')->get();
       
        $homeimage = DB::table('home')
        ->select(
            'home.title_'.$lang.' as title','home.description_'.$lang.' as description',
            'home.image_id',
            'images.filename as image_file_name',
        )
        ->where('home.published', 1)
        ->leftJoin('images', 'images.id', '=', 'home.image_id')
        ->orderBy('published', 'DESC')->get();
       
        view()->share('menu', 'home');
        view()->share('homeimage', $homeimage);
        view()->share('faq', $faq);
        return view('app.welcome');
    }
    public function service()
    {
        view()->share('menu', 'service');
        return view('app.service');
    }
    public function about()
    {
        view()->share('menu', 'about');
        return view('app.about');
    }
    public function contact()
    {
        view()->share('menu', 'contact');
        return view('app.contact');
    }
    public function auth()
    {
        view()->share('menu', 'signin');
        return view('app.auth');
    }
    public function send(Request $request)
    {
        
    if($request->message){
        $settings = Settings::where('key','sait_settings')->first();
        $site_settings = json_decode($settings->value);

        $contact_email = $site_settings->email;
        $data = array();
        $data['email'] = $request['email'];
        $data['name'] = isset($request['name']) ? $request['name'] : '-----';
        $data['subject'] = isset($request['subject']) ? $request['subject'] : '-----';
        $data['msg'] = $request['message'];

        $mail = Mail::send('emails.contact', $data, function ($message) use ($contact_email) {
            $message->from('no-reply@lc-citadel.lc-citadel', "lc-citadel");
            $message->subject("lc-citadel contact");
            $message->to($contact_email);
        });

        return json_encode(array('status' => 1));
    }
    else{
        return json_encode(array('status' => 0));

    }
}
}
