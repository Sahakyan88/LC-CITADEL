<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\About;
use App\Helpers\Translate;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\ImageDB;

class AboutAdminController extends Controller
{
    public function homeAbout(Request $request){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'about');
        return view('admin.about.index');
    }


    public function aboutData(Request $request){
        $model = new About();
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

    public function aboutGet(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = About::find($id);
            if ($item->image_id) {
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            $mode = 'edit';
        }else{
            $item = new About();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.about.item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
        );

        return $data;
    }

    public function aboutSave(Request $request){

        // $validator  = Validator::make($request->all(), [
        //     'title_am'  => 'required',
        //     'image'     => 'required',
        //     'body_am'   => 'required',
       
        // ]);


        $data = $request->all();

        $id = $request->input('id');
        if (!$id) {
            $item = new About();
            $max = DB::table('about')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
        } else {
            $item = About::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }

        $item->image_id = $data['image'];
        if ($item->image_id) {
            $imageDB = ImageDB::find($item->image_id);
            $imageDB->save();
        }
        $translateHelper = new Translate();
        $item->multilangualFiled =  ['title','body'];
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
    public function removeAbout(Request $request){

        $ids = $request->input('ids');
        foreach ($ids as $id) {
            $item = About::find($id);
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

    public function reorderingAbout(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = About::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
        exit();
    }
}

