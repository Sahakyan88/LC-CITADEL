<?php

namespace App\Http\Controllers\Admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\OnePayment;
use App\Models\Admin\Packages;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Admin\ImageDB;

class PackagesPaymentControler extends Controller
{
    public function packagesPayments(){
    
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'packagesPayments');
        return view('admin.package.package');
    }

    public function packagesData(Request $request){
      
        $model = new Packages();
        $filter = array('search' => $request->input('search'),
        'status' => $request->input('filter_status'),
        'featured'=> $request->input('featured',false));

    $items = $model->getAll(
        $request->input('start'),
        $request->input('length'),
        $filter,
        $request->input('sort_field'),
        $request->input('sort_dir'),
    );

    $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
    return $data;
    }
    
}