<?php

namespace App\Http\Controllers;

use Validator;
use Session;
use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\PasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Response;
use File;
use App\Models\ImageDB;
use Redirect;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ordersPprofile(Request $request){
        return view('app.orders-profile');
    }

    public function personaIinfo(){

        return view('app.login');
    }
    public function passport(){
        $image = DB::table('users')
        ->select(
            'users.image_id',
            'images.filename as image_file_name',
            'images.id',
        )
        ->where('users.id', Auth::user()->id)
        ->leftJoin('images', 'images.id', '=', 'users.image_id')
        ->get();
        return view('app.passport',compact('image'));
    }
    public function  storeImage(Request $request){
        $data= new ImageDB();
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('passport'), $filename);
            $data['filename']= $filename;
            $data->save();
            $id=Auth::user()->id;
            $user= User::find($id);
            $user->image_id=$data['id'];
            $user->save();
            return redirect()->back()->withSuccess('Image Upload Successfully!');
        }
        return redirect()->back()->withSuccess('Plesee upload image','Error');
    }
    public function  deleteImage(Request $request){
        $file = ImageDB::find($request->image_id);
        $user = User::find(Auth::user()->id);
        $user->image_id=null;
        $user->save();
        if ($file) {
            $path = 'passport/'.$file->filename;
            File::delete($path);
            $file->delete();
            return redirect()->back()->withSuccess('Image Delete Successfully!');
        }
    }
    public function  orderData(Request $request){
        $model = new Order();

        $filter = array(
            'status' => $request->input('filter_status'),
            'category' => $request->input('filter_category'),
        );

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
    public function orderGet(Request $request){

        $id = (int)$request['id'];
        if($id){
            $item = Order::find($id);
            $mode = 'edit';
        }
        $data = json_encode(
            array('data' =>
                (String) view('app.orders-item-profile', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
            );

        return $data;
    }

    public function signup(RegisterRequest $request)
    {
        Auth::login($user = User::create([

            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'terms'             => $request->checkbox,
            'password'          => Hash::make($request->password),

        ]));
        return  back();
    }
    public function logout(Request $request)
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('homepage');
    }

    public function signin(LoginRequest $request){

        $request->authenticate();
        $request->session()->regenerate();

        return  back();      
    }
    public function saveProfile(Request $request)
    {

        $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'phone'          => 'required|numeric',
            'email'           => ['required','string',Rule::unique('users')->ignore(Auth::guard('web')->user()->id),
            ],
        ]);
        $data = array();
        $data['first_name']      = $request['first_name'];
        $data['last_name']       = $request['last_name'];
        $data['email']           = $request['email'];
        $data['phone']           = $request['phone'];

        if(User::where('id', Auth::guard('web')->user()->id)->update($data)){
            Session::flash('success', 'save successfully!');
            return back();
        }
        return json_encode(array('status' => 0, 'message' => 'Something wrong, please try later!'));
    }
    public function profilePassword()
    {
        return view('app.change-password');

    }
    public function changePassword(PasswordRequest $request)
    {
        $current_password = Auth::user()->password;
        if (Hash::check($request['old_password'], $current_password)) {
            $user_id = Auth::id();
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request['confirm_password']);
            $obj_user->save();
            return redirect()->back()->withSuccess('Password was changed successfully!');
        } else {
         
            return redirect()->back()->withSuccess('Old Password invalid', 'Old Password invalid');
        }
    }
     

}
