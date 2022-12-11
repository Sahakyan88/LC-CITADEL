<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Helpers\Helper;

$local = App::getLocale();
Route::get('/', function () {
    $referer = Redirect::back()->getTargetUrl();
    $parse_url = parse_url($referer, PHP_URL_PATH);
    $segments = explode('/', $parse_url);
    array_splice($segments, 1, 1, 'am');
    $url = Request::root() . implode("/", $segments);
    if (parse_url($referer, PHP_URL_QUERY)) {
        $url = $url . '?' . parse_url($referer, PHP_URL_QUERY);
    }
    return redirect($url);
})->name('homepage');

Route::get('/login', [WelcomeController::class, 'login'])->name('login-user');
Route::get('/register', [WelcomeController::class, 'register'])->name('register-user');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/save-image', [AuthController::class, 'storeImage'])->name('imagePassport')->middleware('auth');
Route::delete('/delete-image', [AuthController::class, 'deleteImage'])->name('deleteImage')->middleware('auth');



Route::group(['prefix' => $local], function() {

Route::post('/contact-request', [WelcomeController::class, 'send'])->name('send');
Route::get('/', [WelcomeController::class, 'homepage'])->name('homepage');
Route::get('/contact', [WelcomeController::class, 'contact'])->name('contact');
Route::get('/services', [WelcomeController::class, 'service'])->name('service');
Route::get('/about', [WelcomeController::class, 'about'])->name('about');
Route::get('/orders-profile', [AuthController::class, 'ordersPprofile'])->name('ordersprofile')->middleware('auth');
Route::get('/personal-info', [AuthController::class, 'personaIinfo'])->name('personalinfo')->middleware('auth');
Route::post('/user-info', [AuthController::class, 'edUser'])->name('edUserinfo')->middleware('auth');;
Route::get('/profile-password', [AuthController::class, 'profilePassword'])->name('profilepassword')->middleware('auth');
Route::get('/passport', [AuthController::class, 'passport'])->name('passportGet')->middleware('auth');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changepassword')->middleware('auth');

});

Route::post('/createServiceOrder/{id}',[\App\Http\Controllers\Payment\PaymentController::class, 'createServiceOrder']);
