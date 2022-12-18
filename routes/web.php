<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

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


Auth::routes(['verify' => true]);

Route::get('/login', [WelcomeController::class, 'login'])->name('login-user');
Route::get('/register', [WelcomeController::class, 'register'])->name('register-user');

Route::post('/sign-up', [AuthController::class, 'signup'])->name('signup');
Route::post('/sign-in', [AuthController::class, 'signin'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::post('/save-image', [AuthController::class, 'storeImage'])->name('imagePassport')->middleware('auth');
Route::delete('/delete-image', [AuthController::class, 'deleteImage'])->name('deleteImage')->middleware('auth');
Route::post('/save-image', [AuthController::class, 'storeImage'])->name('imagePassport')->middleware(['auth','verified']);
Route::delete('/delete-image', [AuthController::class, 'deleteImage'])->name('deleteImage')->middleware(['auth','verified']);
Route::get('/not-found', [WelcomeController::class, 'notFound'])->name('notfound');
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::group(['prefix' => $local], function() {

Route::post('/contact-request', [WelcomeController::class, 'send'])->name('send');
Route::get('/', [WelcomeController::class, 'homepage'])->name('homepage');
Route::get('/contact', [WelcomeController::class, 'contact'])->name('contact');
Route::get('/services', [WelcomeController::class, 'service'])->name('service');
Route::get('/about', [WelcomeController::class, 'about'])->name('about');
Route::get('/orders-profile', [AuthController::class, 'ordersPprofile'])->name('ordersprofile')->middleware(['auth','verified']);;
Route::get('/personal-info', [HomeController::class, 'index'])->name('personalinfo')->middleware(['auth','verified']);
Route::post('/user-info', [AuthController::class, 'edUser'])->name('edUserinfo')->middleware(['auth','verified']);
Route::get('/profile-password', [AuthController::class, 'profilePassword'])->name('profilepassword')->middleware(['auth','verified']);
Route::get('/passport', [AuthController::class, 'passport'])->name('passportGet')->middleware(['auth','verified']);
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changepassword')->middleware(['auth','verified']);
Route::get('/package-profile', [AuthController::class, 'packageProfile'])->name('packageprofile')->middleware(['auth','verified']);
Route::get('/contract', [WelcomeController::class, 'contract'])->name('contract')->middleware(['auth','verified']);
Route::post('/contract-check', [WelcomeController::class, 'contractCheck'])->name('contractCheck')->middleware(['auth','verified']);

Route::get('/payment-success',[\App\Http\Controllers\Payment\PaymentController::class, 'payment_success'])->name('payment_success');

 });

 Route::post('/createServiceOrder/{id}',[\App\Http\Controllers\Payment\PaymentController::class, 'createServiceOrder']);


Route::post('/createServiceOrder/{id}',[\App\Http\Controllers\Payment\PaymentController::class, 'createServiceOrder']);
Route::post('/createPackageOrder/{id}',[\App\Http\Controllers\Payment\SubscriptionController::class, 'createPackageOrder']);
Route::get('/payment/checkPayment',[\App\Http\Controllers\Payment\PaymentController::class,'checkPayment']);
Route::get('/payment/checkSubscription',[\App\Http\Controllers\Payment\SubscriptionController::class,'checkSubscription']);
Route::get('/billSubscription', [\App\Http\Controllers\Payment\SubscriptionController::class,'bill']);
Route::post('/deactivatePackage',[\App\Http\Controllers\Payment\SubscriptionController::class, 'deactivate'])->name('deactivatePackage');
