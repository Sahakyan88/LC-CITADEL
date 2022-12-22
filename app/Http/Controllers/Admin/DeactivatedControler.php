<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PackagesDeactivated;
use Illuminate\Support\Facades\DB;

class DeactivatedControler extends Controller
{
    public function index(){
      
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        return view('admin.package.deactivated');
    }

    public function deactivatedData(Request $request){
        $model = new PackagesDeactivated();
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