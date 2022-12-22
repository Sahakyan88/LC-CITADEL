<?php

namespace App\Http\Controllers\Admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Users;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Admin\ImageDB;

class UserController extends Controller
{
    public function usersIndex(){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;

        view()->share('page', $page);
        view()->share('menu', 'users');
        return view('admin.users.users');
    }

    public function userData(Request $request){
        $model = new Users();

        $filter = array('search' => $request->input('search'),
                        'status' => $request->input('filter_status'),
                        'verify' => $request->input('filter_verification'));

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir')
        );

        $data = json_encode(
            array('data' => $items['data'],
            'recordsFiltered' => $items['count'],
            'recordsTotal'=> $items['count']));
        return $data;
    }
    public function userGet(Request $request){
        $id = (int)$request['id'];
        $page = (isset($request['page']) && $request['page'] == 'verification' ) ? true : false;
        if($id){
            $item = Users::find($id);
            $packages = DB::table('package_user')
                ->where('user_id', $id)
                ->where('is_blocked',0)
                ->where('deactivated_at','=',null)
                ->select(
                    'package_user.user_id as user_id',
                    'package_user.id as package_user_id',
                    'services.price as amount',
                    'services.id as id',
                    'services.title_en as title',
                    'package_user.created_at as date',
                    'package_user.paid_at as paid')
                ->leftJoin('users', 'users.id', '=', 'package_user.user_id')
                ->leftJoin('services', 'services.id', '=', 'package_user.package_id')->get();
            if ($item->image_id) {
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            $mode = 'edit';
        }else{
            $item = new Service();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }

        $data = json_encode(
            array('data' =>
                (String) view('admin.users.item', array('item'=>$item,'mode' => $mode, 'packages'=>$packages, 'page' => $page)),'status' => 1)
            );
        return $data;
    }

    public function auserSave(Request $request){

        $validator  = Validator::make($request->all(), [
            'email'      => ['required',Rule::unique('users')->ignore($request->id)],
            'first_name' => 'required',
            'last_name'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        $validated = $validator->validated();
        $id = (int)$request['id'];
        if(!$id){
            return json_encode(array('status' => 0, 'message' => 'User is required.'));
        }else{
            $item = Users::find($id);
        }

        $item->first_name = $request['first_name'];
        $item->last_name  = $request['last_name'];
        $item->email      = $request['email'];

        $item->save();
        return json_encode(array('status' => 1));
    }

    public function verify(Request $request){
        $validator = \Validator::make($request->all(), [
            'verify_id' => 'required|int',
            'status' => 'required|in:base,pending,declined,approved',
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => $validator->errors()], 401);
        }

        $id = (int)$request['verify_id'];

        $verification =  DB::table('verification')->select('*')->where('id', $id)->first();
        if(!$verification){
            return json_encode(array('status' => 0, 'message' => 'User not submit'));
        }

        $data = array();
        $data['status'] = $request['status'];
        $data['message'] = $request['message'];

        DB::table('verification')->where('id', $id)->update($data);

        if($verification->status != $request['status']){
            DB::table('users')->where('id', $verification->user_id)->update(['verify'=> $request['status']]);

            if(in_array($request['status'],['approved','declined'])){
                $notification = new Notification();
                $description = $request['status'] == 'approved' ? 'Verification is successfull.' : 'Verification is faild.';
                $notificationData = array('type' => 'user_verification');
                $notification->send($verification->user_id,"Verification of account",$description,"order_request_timeout",false,$notificationData);
            }

        }
        return json_encode(array('status' => 1));
    }
}

