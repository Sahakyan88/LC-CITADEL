<?php

namespace App\Models\Admin;
use DB;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    public $multilangualFiled = false;

    protected $table = 'about';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('about');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS about.id'),
            'about.id as DT_RowId',
            'about.title_en as title',
            'about.ordering as ordering',
            'about.published as published'));

        if($length != '-1'){
            $query->skip($start)->take($length);
        }
        if( isset($filter['search']) && strlen($filter['search']) > 0 ){
            $query->where('about.title_en', 'LIKE', '%'. $filter['search'] .'%')->orWhere('about.price', 'LIKE', '%'. $filter['search'] .'%');
        }
        $query->orderBy($sort_field, $sort_dir);
        $data = $query->get();
        $count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
        $return['data'] = $data;
        $return['count'] = $count->recordsTotal;
        return $return;
    }
   
}


