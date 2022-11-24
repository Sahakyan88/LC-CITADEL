<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Dictionary extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dictionary';

    public $timestamps  = false;
    
    
	public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('dictionary');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS dictionary.id'),
            'dictionary.id as DT_RowId',
            'dictionary.faq_en as title',
            'dictionary.published as published'));

        if($length != '-1'){
            $query->skip($start)->take($length);
        }
        if( isset($filter['search']) && strlen($filter['search']) > 0 ){
            $query->where('dictionary.title', 'LIKE', '%'. $filter['search'] .'%')->orWhere('dictionary.id', 'LIKE', '%'. $filter['search'] .'%');
        }
        $query->orderBy($sort_field, $sort_dir);
        $data = $query->get();
        $count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
        $return['data'] = $data;
        $return['count'] = $count->recordsTotal;
        return $return;
    }
    
}


