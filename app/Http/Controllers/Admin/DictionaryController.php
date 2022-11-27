<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Dictionary;
use App\Models\Admin\Settings;
use Illuminate\Routing\Redirector;
use Response;
use View;
use File;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use DB;
use App\Helpers\Translate;
use Validator;

class DictionaryController extends Controller
{
    protected $request;

    public function __construct(Request $request, Redirector $redirector)
    {
        $this->request = $request;
    }


    public function index()
    {
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'dictionary');
        return view('admin.dictionary.index');
    }

    public function data(Request $request)

    {
        $model = new Dictionary();
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
    public function get(Request $request)
    {

        $id = (int)$request['id'];
        if($id){
            $item = Dictionary::find($id);
            $mode = 'edit';
        }else{
            $item = new Dictionary();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.dictionary.item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
        );

        return $data;
    }
    public function save(Request $request)
    {
        $validator  = Validator::make($request->all(), [

                'faq_en' => 'required',
                'service_en' => 'required',
                'team_en' => 'required',
                'contact_en' => 'required',
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
            $item = new Dictionary();
            $max = DB::table('home')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
        } else {
            $item = Dictionary::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }

        $translateHelper = new Translate();
        $item->multilangualFiled =  ['faq','service','team','contact'];
        $item = $translateHelper->make($item,$data);

        $item->published   = $data['published'];

        $item->save();
        $id = $item->id;
        if (isset($publishedNotification)) {
            return json_encode(array('status' => 1, 'message' => "Can't publish Without image", 'published' => 0));
        } else {
            return json_encode(array('status' => 1));
        }

    }

}