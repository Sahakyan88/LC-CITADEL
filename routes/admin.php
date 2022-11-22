<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DictionaryController;
use App\Http\Controllers\Admin\RequestsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\FaqController;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Admin\ServicesController;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/',[AuthController::class, 'getLogin'])->name('adminLogin');
Route::post('/login', [AuthController::class, 'postLogin'])->name('adminLoginPost');
Route::get('/logout', [AuthController::class, 'logout'])->name('adminLogout');


Route::group(['middleware' => 'adminauth'], function () {
	// Admin Dashboard
    Route::get('dashboard',[AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('profile',[AdminController::class, 'profile'])->name('adminProfile');
    Route::get('order-data',[OrderController::class, 'data'])->name('orderData');
    Route::post('save-profile',[AuthController::class, 'saveProfile'])->name('adminSaveProfile');
    Route::post('change-password',[AuthController::class, 'changePassword'])->name('adminChangePassword');
    Route::post('save-settings',[AdminController::class, 'saveSettings'])->name('saveAdminSettings');
    Route::post('save-contact',[AdminController::class, 'saveContact'])->name('saveAdminContact');
    //settings
    Route::get('settings',[SettingsController::class, 'settings'])->name('adminSettings');
    Route::post('settings',[SettingsController::class,'updateSettings'])->name('updateSettings');
    //home
    Route::get('home',[HomeController::class, 'home'])->name('adminHome');
    Route::get('home-data',[HomeController::class, 'homeData'])->name('aHomeData');
    Route::get('home-get',[HomeController::class, 'getHome'])->name('aGetHome');
    Route::post('home-save',[HomeController::class, 'saveHome'])->name('adminHomeSave');
    Route::post('home-remove',[HomeController::class, 'removeHome'])->name('aRemoveHome');
    Route::post('home-ordering',[HomeController::class, 'reorderingHome'])->name('aHomeSort');


    Route::post('save-profile',[AuthController::class, 'saveProfile'])->name('adminSaveProfile');
    Route::post('change-password',[AuthController::class, 'changePassword'])->name('adminChangePassword');
    Route::post('save-settings',[AdminController::class, 'saveSettings'])->name('saveAdminSettings');
    Route::post('save-contact',[AdminController::class, 'saveContact'])->name('saveAdminContact');

    //Categories
    Route::get('categories',[ContentController::class, 'categories'])->name('adminCategories');
    Route::get('categories-data',[ContentController::class, 'categoriesData'])->name('aCategoriesData');
    Route::get('category-get',[ContentController::class, 'getCategory'])->name('aGetCategory');
    Route::post('category-save',[ContentController::class, 'saveCategory'])->name('adminCategorySave');
    Route::post('category-remove',[ContentController::class, 'removeCategory'])->name('aRemoveCategory');
    Route::post('category-ordering',[ContentController::class, 'reorderingCategory'])->name('aCategoriesSort');

    //Dictionary
    Route::get('dictionary',[DictionaryController::class, 'index'])->name('adminDictionary');
    Route::get('dictionary-data',[DictionaryController::class, 'data'])->name('aDictionaryData');
    Route::get('dictionary-get',[DictionaryController::class, 'get'])->name('aGetDictionary');
    Route::post('dictionary-save',[DictionaryController::class, 'save'])->name('adminDictionarySave');

    Route::post('dictionary-save',[DictionaryController::class, 'save'])->name('adminDicionarySave');
    Route::get('dictionary-sync',[DictionaryController::class, 'sync'])->name('aSyncDictionary');

   

    //F.A.Q
    Route::get('faq',[FaqController::class, 'faq'])->name('adminFaq');
    Route::get('faq-data',[FaqController::class, 'faqData'])->name('aFaqData');
    Route::get('faq-get',[FaqController::class, 'getFaq'])->name('aGetFaq');
    Route::post('faq-save',[FaqController::class, 'saveFaq'])->name('adminFaqSave');
    Route::post('faq-remove',[FaqController::class, 'removeFaq'])->name('aRemoveFaq');
    Route::post('faq-ordering',[FaqController::class, 'reorderingFaq'])->name('aFaqSort');


    //services
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



//team
Route::get('team',[TeamController::class, 'homeTeam'])->name('ateam');
Route::get('team-get',[TeamController::class, 'teamGet'])->name('aGetTeam');
Route::post('team-save',[TeamController::class, 'ateamSave'])->name('aTeamSave');
Route::get('team-data',[TeamController::class, 'teamData'])->name('aTeamData');
Route::post('team-remove',[TeamController::class, 'removeTeam'])->name('aRemoveTeam');
Route::post('team-ordering',[TeamController::class, 'reorderingHome'])->name('aTeamSort');







    Route::post('upload-image',[ImageController::class, 'upload'])->name('aUpload');
    Route::post('remove-image',[ImageController::class, 'remove'])->name('aRemoveImage');

    //clear all cache
    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    });
});
