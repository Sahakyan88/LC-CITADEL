<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\AboutAdminController;
use App\Http\Controllers\Admin\DictionaryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Payment\SubscriptionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PackagesPaymentControler;
use App\Http\Controllers\Admin\DeactivatedControler;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\OneTimePaymentControler;
use App\Http\Controllers\Admin\FileUploadController;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/',[AuthController::class, 'getLogin'])->name('adminLogin');
Route::post('/login', [AuthController::class, 'postLogin'])->name('adminLoginPost');
Route::get('/logout', [AuthController::class, 'logout'])->name('adminLogout');

Route::group(['middleware' => 'adminauth'], function () {

    Route::get('dashboard',[AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('profile',[AdminController::class, 'profile'])->name('adminProfile');

    Route::get('settings',[SettingsController::class, 'settings'])->name('adminSettings');
    Route::post('settings',[SettingsController::class,'updateSettings'])->name('updateSettings');

    Route::get('home',[HomeController::class, 'home'])->name('adminHome');
    Route::get('home-data',[HomeController::class, 'homeData'])->name('aHomeData');
    Route::get('home-get',[HomeController::class, 'getHome'])->name('aGetHome');
    Route::post('home-save',[HomeController::class, 'saveHome'])->name('adminHomeSave');
    Route::post('home-remove',[HomeController::class, 'removeHome'])->name('aRemoveHome');
    Route::post('home-ordering',[HomeController::class, 'reorderingHome'])->name('aHomeSort');

    Route::get('about',[AboutAdminController::class, 'homeAbout'])->name('aAbout');
    Route::get('about-get',[AboutAdminController::class, 'aboutGet'])->name('aGetAbout');
    Route::post('about-save',[AboutAdminController::class, 'aboutSave'])->name('aAboutSave');
    Route::get('about-data',[AboutAdminController::class, 'aboutData'])->name('aAboutData');
    Route::post('about-ordering',[AboutAdminController::class, 'reorderingAbout'])->name('aAboutSort');

    Route::post('save-profile',[AuthController::class, 'saveProfile'])->name('adminSaveProfile');
    Route::post('change-password',[AuthController::class, 'changePassword'])->name('adminChangePassword');

    Route::get('dictionary',[DictionaryController::class, 'index'])->name('adminDictionary');
    Route::get('dictionary-data',[DictionaryController::class, 'data'])->name('aDictionaryData');
    Route::get('dictionary-get',[DictionaryController::class, 'get'])->name('aGetDictionary');
    Route::post('dictionary-save',[DictionaryController::class, 'save'])->name('DictionarySave');

    Route::get('faq',[FaqController::class, 'faq'])->name('adminFaq');
    Route::get('faq-data',[FaqController::class, 'faqData'])->name('aFaqData');
    Route::get('faq-get',[FaqController::class, 'getFaq'])->name('aGetFaq');
    Route::post('faq-save',[FaqController::class, 'saveFaq'])->name('adminFaqSave');
    Route::post('faq-remove',[FaqController::class, 'removeFaq'])->name('aRemoveFaq');
    Route::post('faq-ordering',[FaqController::class, 'reorderingFaq'])->name('aFaqSort');

    Route::get('services',[ServicesController::class, 'services'])->name('adminServices');
    Route::get('services-data',[ServicesController::class, 'servicesData'])->name('aServicesData');
    Route::get('services-get',[ServicesController::class, 'getServices'])->name('aGetServices');
    Route::post('services-save',[ServicesController::class, 'saveServices'])->name('adminServicesSave');
    Route::post('services-remove',[ServicesController::class, 'removeServices'])->name('aRemoveServices');
    Route::post('services-ordering',[ServicesController::class, 'reorderingServices'])->name('aServicesSort');

    Route::get('users',[UserController::class, 'usersIndex'])->name('ausers');
    Route::get('user-get',[UserController::class, 'userGet'])->name('aGetUser');
    Route::post('user-save',[UserController::class, 'auserSave'])->name('aUserSave');
    Route::get('user-data',[UserController::class, 'userData'])->name('aUserData');
    Route::post('user-vierfy',[UserController::class, 'verify'])->name('aUserSaveVerify');
    Route::post('user-upload-avatar',[ImageController::class, 'upload'])->name('uploadAvatar');

    Route::get('team',[TeamController::class, 'homeTeam'])->name('ateam');
    Route::get('team-get',[TeamController::class, 'teamGet'])->name('aGetTeam');
    Route::post('team-save',[TeamController::class, 'ateamSave'])->name('aTeamSave');
    Route::get('team-data',[TeamController::class, 'teamData'])->name('aTeamData');
    Route::post('team-remove',[TeamController::class, 'removeTeam'])->name('aRemoveTeam');
    Route::post('team-ordering',[TeamController::class, 'reorderingHome'])->name('aTeamSort');

    Route::get('one-payments',[OneTimePaymentControler::class, 'onePayment'])->name('onePayments');
    Route::get('data-payments',[OneTimePaymentControler::class, 'onePaymentData'])->name('aonePaymentData');
    Route::get('get-payments',[OneTimePaymentControler::class, 'onePaymentGet'])->name('aGetOnePayment');
    Route::post('save-payments',[OneTimePaymentControler::class, 'aPaymentOneSave'])->name('paymentOneSave');

    Route::get('packages-payments',[PackagesPaymentControler::class, 'packagesPayments'])->name('packages');
    Route::get('packages-data',[PackagesPaymentControler::class, 'packagesData'])->name('aPackagesData');

    Route::post('upload-image',[ImageController::class, 'upload'])->name('aUpload');
    Route::post('remove-image',[ImageController::class, 'remove'])->name('aRemoveImage');

    Route::post('upload-file',[FileUploadController::class, 'upload'])->name('aUploaFfile');
    Route::post('remove-file',[FileUploadController::class, 'remove'])->name('aRemoveFile');

    Route::get('deactivated',[DeactivatedControler::class, 'index'])->name('deactivatedPage');
    Route::get('data-deactivated',[DeactivatedControler::class, 'deactivatedData'])->name('aDeactivatedData');

    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    });
});
