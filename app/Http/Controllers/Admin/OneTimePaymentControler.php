<?php

namespace App\Http\Controllers\Admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\OnePayment;
use App\Models\Admin\Order;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Admin\ImageDB;

class OneTimePaymentControler extends Controller
{
    public function onePayment(){
      
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'onePayments');
        return view('admin.payments.oneTimePayment');
    }

    public function onePaymentData(Request $request){
      
      
        $model = new Order();
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
    public function onePaymentGet(Request $request){
     
        $id = (int)$request['id'];
      
        if($id){
            $item = Order::find($id);
            $mode = 'edit';
        }

        $data = json_encode(
            array('data' => 
                (String) view('admin.payments.oneTimePaymentItem', array('item'=>$item,'mode' => $mode)),'status' => 1)
            );
        return $data; 
    }

    public function aPaymentOneSave(Request $request){
        $id = (int)$request['id'];
        if(!$id){
            return json_encode(array('status' => 0, 'message' => 'User is required.'));
        }else{
            $item = Order::find($id);
        }
        $item->status_been   =$request->been;
        $item->save();
        return json_encode(array('status' => 1));
    }
    
  
}