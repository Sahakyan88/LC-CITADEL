<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Localization

$local = App::getLocale();

if($local == 'am')$local = '';

function lastIntInString($slug){

    $pos = strrpos($slug, "-");
    if ($pos === false) { 
        return false;
    }
    return substr($slug , $pos+1);
}
Route::get('/login-user', [WelcomeController::class, 'login'])->name('login-user');
Route::get('/register-user', [WelcomeController::class, 'register'])->name('register-user');

Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/contact-request', [WelcomeController::class, 'send'])->name('send');

Route::group(['prefix' => $local], function() {
//pages
Route::get('/', [WelcomeController::class, 'homepage'])->name('homepage');
Route::get('/contact', [WelcomeController::class, 'contact'])->name('contact');
Route::get('/services', [WelcomeController::class, 'service'])->name('service');
Route::get('/about', [WelcomeController::class, 'about'])->name('about');


});
///profile
Route::get('/orders-profile', [AuthController::class, 'ordersPprofile'])->name('ordersprofile')->middleware('auth');
Route::get('/personal-info', [AuthController::class, 'personaIinfo'])->name('personalinfo')->middleware('auth');
Route::get('/profile-password', [AuthController::class, 'profilePassword'])->name('profilepassword')->middleware('auth');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changepassword')->middleware('auth');
Route::get('order-data-profile',[AuthController::class, 'orderData'])->name('orderDataProfile');
Route::get('order-data-edit',[AuthController::class, 'orderGet'])->name('profileGetOrder');
// Route::get('/clear', function() {
//     Artisan::call('cache:clear');
//     Artisan::call('route:clear');
//     Artisan::call('config:clear');
//     Artisan::call('view:clear');
//     return "Cache is cleared";
// });