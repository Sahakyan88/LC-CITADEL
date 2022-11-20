<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Requests;
use App\Models\Doc;
use App\Models\Admin\slider;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use PDF;
use Mail;

class WelcomeController extends Controller
{
    public function homepage()
    {
        view()->share('menu', 'home');
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
}
