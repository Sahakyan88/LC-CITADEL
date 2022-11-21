<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Home;
use App\Helpers\Translate;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\ImageDB;


class HomeController extends Controller
{
    public function home(Request $request){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'home');
        $data=Home::all();
        return view('admin.home.index',compact('data'));
    }


    public function homeData(Request $request){
        $model = new Home();
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

    public function getHome(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Home::find($id);
            if ($item->image_id) {
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            $mode = 'edit';
        }else{
            $item = new Home();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.home.item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
        );

        return $data;
    }

    public function saveHome(Request $request){

       
        // dd($request->all());
        $validator  = Validator::make($request->all(), [
            'title_en'         => 'required',
            'image'         => 'required',
            'description_en'   => 'required',
       
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        $validated = $validator->validated();

        $data = $request->all();

        $id = $request->input('id');
        if (!$id) {
            $item = new Home();
            $max = DB::table('home')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
        } else {
            $item = Home::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }

        $item->image_id = $data['image'];
        if ($item->image_id) {
            $imageDB = ImageDB::find($item->image_id);
            $imageDB->save();
        }
        $translateHelper = new Translate();
        $item->multilangualFiled =  ['title','description'];
        $item = $translateHelper->make($item,$data);

        $item->published   = $data['published'];
      
        $item->save();
        $id = $item->id;
        if (isset($publishedNotification)) {
            return json_encode(array('status' => 1, 'message' => "Cant publish Without image", 'published' => 0));
        } else {
            return json_encode(array('status' => 1));
        }

    }
    public function removeHome(Request $request){

        $ids = $request->input('ids');
        foreach ($ids as $id) {
            $item = Home::find($id);
            if ($item) {
                if ($item->image_id) {
                    $image = ImageDB::find($item->image_id);
                    if ($item->image_id) {
                        $image->remove($item->image_id);
                    }
                }
                $item->delete();
            } else {
                return json_encode(array('status' => 0, 'message' => "Can't save"));
            }
        }
        $data = json_encode(array('status' => 1));
        return $data;
    }

    public function reorderingHome(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = Home::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
        exit();
    }
}
