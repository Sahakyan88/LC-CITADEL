<?php

namespace App\Http\Controllers\Admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\OnePayment;
use App\Models\Admin\Packages;
use App\Models\Admin\PackagesDeactivated;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Admin\ImageDB;

class PackagesPaymentControler extends Controller
{
    public function packagesPayments(){

        $deacivated  = DB::table('package_user')->select(array(DB::raw('SQL_CALC_FOUND_ROWS package_user.id'),
            'package_user.id as DT_RowId',
            'services.price as amount',
            'users.first_name',
            'users.last_name',
            'users.phone',
            'services.title_am as title',
            'users.created_at as date',
            'package_user.paid_at as paid',
            'package_user.is_blocked',
        ))
            ->leftJoin('services', 'services.id', '=', 'package_user.package_id')
            ->leftJoin('users', 'users.id', '=', 'package_user.user_id')
            ->where('package_user.is_blocked', 1)
            ->where('services.featured', 0)->count();;

        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'packagesPayments');
        return view('admin.package.package',compact('deacivated'));
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
