<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DictionaryController;
use App\Http\Controllers\Admin\RequestsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\SliderController;
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
    Route::post('update-settings-price',[SettingsController::class,'updateSettingsPrice'])->name('updateSettingsPrice');
    //slider
    Route::get('slider',[SliderController::class, 'slider'])->name('adminSlider');
    Route::get('slider-data',[SliderController::class, 'sliderData'])->name('aSliderData');
    Route::get('slider-get',[SliderController::class, 'getSlider'])->name('aGetSlider');
    Route::post('slider-save',[SliderController::class, 'saveSlider'])->name('adminSliderSave');
    Route::post('slider-remove',[SliderController::class, 'removeSlider'])->name('aRemoveSlider');
    Route::post('slider-ordering',[SliderController::class, 'reorderingSlider'])->name('aSliderSort');


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

    Route::get('order-data',[OrderController::class, 'data'])->name('orderData');
    Route::get('orders',[OrderController::class, 'index'])->name('adminOrder');
    Route::get('order',[OrderController::class, 'getOrder'])->name('aGetOrder');

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
    
    Route::get('services-type-data',[ServicesController::class, 'servicesTypeData'])->name('aServicesTypeData');
    Route::get('services-type-get',[ServicesController::class, 'getServicesType'])->name('aGetServicesType');
    Route::post('services-type-remove',[ServicesController::class, 'removeServicesType'])->name('aRemoveServicesType');
    Route::post('services-type-save',[ServicesController::class, 'saveServicesType'])->name('adminServicesTypeSave');
    
    Route::get('services-replacement-data',[ServicesController::class, 'servicesReplacementData'])->name('aServicesReplacementData');
    Route::get('services-replacement-get',[ServicesController::class, 'getServicesReplacement'])->name('aGetServicesReplacement');
    Route::post('services-replacement-remove',[ServicesController::class, 'removeServicesReplacement'])->name('aRemoveServicesReplacement');
    Route::post('services-replacement-save',[ServicesController::class, 'saveServicesReplacement'])->name('adminServicesReplacementSave');

    //Customers
    Route::get('customers',[UserController::class, 'customerIndex'])->name('aCustomer');
    Route::get('customers-data',[UserController::class, 'customerData'])->name('aCustomerData');
    Route::get('customer-get',[UserController::class, 'customerGet'])->name('aGetCustomer');
    Route::post('customer-save',[UserController::class, 'customerSave'])->name('aCustomerSave');
    Route::get('suppliers',[UserController::class, 'supplierIndex'])->name('aSupplier');
    Route::get('suppliers-data',[UserController::class, 'supplierData'])->name('aSupplierData');
    Route::get('supplier-get',[UserController::class, 'supplierGet'])->name('aGetSupplier');
    Route::post('supplier-save',[UserController::class, 'supplierSave'])->name('aSupplierSave');

    Route::get('users',[UserController::class, 'usersIndex'])->name('ausers');
    Route::get('user-get',[UserController::class, 'userGet'])->name('aGetUser');
    Route::post('user-save',[UserController::class, 'auserSave'])->name('aUserSave');
    Route::get('user-data',[UserController::class, 'userData'])->name('aUserData');
    Route::post('user-vierfy',[UserController::class, 'verify'])->name('aUserSaveVerify');
    Route::post('user-upload-avatar',[ImageController::class, 'upload'])->name('uploadAvatar');

    Route::get('masters',[MasterController::class, 'index'])->name('adminMasters');
    Route::get('masters-data',[MasterController::class, 'data'])->name('adminMastersData');
    Route::get('master-get',[MasterController::class, 'get'])->name('adminMastersGet');
    Route::post('master-save',[MasterController::class, 'save'])->name('adminMastersSave');
    //Maintenance
    Route::get('maintenance',[MaintenanceController::class, 'index'])->name('adminMaintenance');
    Route::get('maintenance-data',[MaintenanceController::class, 'data'])->name('adminMaintenanceData');
    Route::get('maintenance-get',[MaintenanceController::class, 'get'])->name('adminMaintenanceGet');

    Route::get('requests',[RequestsController::class, 'index'])->name('adminRequests');
    Route::get('requests-data',[RequestsController::class, 'data'])->name('adminRequestsData');
    Route::get('requests-get',[RequestsController::class, 'get'])->name('adminRequestsGet');
    Route::post('requests-save',[RequestsController::class, 'save'])->name('adminRequestsSave');


    // Route::get('user-data',[UserController::class, 'userData'])->name('aUserData');
    // Route::post('user-vierfy',[UserController::class, 'verify'])->name('aUserSaveVerify');
    // Route::post('user-upload-avatar',[ImageController::class, 'upload'])->name('uploadAvatar');

    Route::post('upload-image',[ImageController::class, 'upload'])->name('aUpload');
    Route::post('remove-image',[ImageController::class, 'remove'])->name('aRemoveImage');

    // Route::get('get-services',[UserController::class, 'getService'])->name('AGetServices');
    // Route::post('save-services',[UserController::class, 'saveServices'])->name('saveServices');


    // Route::get('faq',[ContentController::class, 'indexFaq'])->name('adminFaq');
    // Route::get('faq-data',[ContentController::class, 'dataFaq'])->name('adminFaqData');
    // Route::get('faq-publish',[ContentController::class, 'publishFaq'])->name('adminFaqPublish');
    // Route::get('faq-get',[ContentController::class, 'getFaq'])->name('adminFaqGet');
    // Route::post('faq-save',[ContentController::class, 'saveFaq'])->name('adminFaqSave');
    // Route::post('faq-remove',[ContentController::class, 'removeFaq'])->name('adminFaqRemove');

    //clear all cache
    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    });
});
