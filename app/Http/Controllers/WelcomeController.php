<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gallery;
use App\Models\Service;
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
}
