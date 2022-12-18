<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Service;
use App\Http\Controllers\Controller;
use Validator;
use App\Helpers\Translate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\ImageDB;


class ServicesController extends Controller
{
    public function services(Request $request){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'services');
        return view('admin.services.services_index');
    }
    

    public function servicesData(Request $request){
        $model = new Service();
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

    public function getServices(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Service::find($id);
            if ($item->image_id) {
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            if ($item->file_id) {
                $imageDb = new ImageDB();
                $item->file = $imageDb->get($item->file_id);
            }
            $mode = 'edit';
        }else{
            $item = new Service();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.services.services_item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
            );

        return $data;
    }
    
    public function saveServices(Request $request){
    
        $validator  = Validator::make($request->all(), [
            'title_en'      => 'required',
            'image'         => 'required',
            'file'         => 'required',
            'price'         => 'required',
            'body_en'       => 'required'
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
            $item = new Service();
            $max = DB::table('services')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
        } else {
            $item = Service::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }
      
        $item->image_id = $data['image'];
        if ($item->image_id) {
            $imageDB = ImageDB::find($item->image_id);
            $imageDB->save();
        }
        $item->file_id = $data['file'];
        if ($item->file_id) {
            $imageDB = ImageDB::find($item->file_id);
            $imageDB->save();
        }
        $translateHelper = new Translate();
        $item->multilangualFiled =  ['title','body'];
        $item = $translateHelper->make($item,$data);

        $item->published   = $data['published'];
        $item->price       = $data['price'];
        $item->featured    = isset($data['featured']) ? 1 : 0;

        $item->save();
        $id = $item->id;

        if (isset($publishedNotification)) {
            return json_encode(array('status' => 1, 'message' => "Cant publish Without image", 'published' => 0));
        } else {
            return json_encode(array('status' => 1));
        }
    
    }

    public function removeServices(Request $request){
     
        $ids = $request->input('ids');
        foreach ($ids as $id) {
            $item = Service::find($id);
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

    public function reorderingServices(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = Service::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
        exit();
    }

}
