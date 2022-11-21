<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class home extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $multilangualFiled = false;

    protected $table = 'home';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('home');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS home.id'),
            'home.id as DT_RowId',
            'home.title_en as title',
            'home.ordering as ordering',
            'home.published as published'));

        if($length != '-1'){
            $query->skip($start)->take($length);
        }
        if( isset($filter['search']) && strlen($filter['search']) > 0 ){
            $query->where('home.title', 'LIKE', '%'. $filter['search'] .'%')->orWhere('home.price', 'LIKE', '%'. $filter['search'] .'%');
        }
        $query->orderBy($sort_field, $sort_dir);
        $data = $query->get();
        $count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
        $return['data'] = $data;
        $return['count'] = $count->recordsTotal;
        return $return;
    }
    public function forSlider1(){
        $home1 =  DB::table('home')->where('published',1)->get();
        $data1 = [];
        foreach ($home1 as $slideData) {
            $item=DB::table('images')->where('id',$slideData->image_id)->get('filename');
            $newitem = [
                'title'       => $slideData->title,
                'description' => $slideData->description,
                'filename'    => $item[0]->filename,
            ];
            array_push($data1,$newitem);
        };
        return $data1;
    }
}
