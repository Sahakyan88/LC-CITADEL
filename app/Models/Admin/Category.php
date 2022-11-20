<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
	use SoftDeletes;
    protected $table = 'categories';
    public $timestamps = false;

    // protected $fillable = ['code','account_id'];

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table($this->table);

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS categories.id'), 
										'categories.id as DT_RowId',
										'categories.title_en as title',
										'categories.published as published',
										'categories.ordering as ordering',
										)
								);
		
		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('categories.title_en', 'LIKE', '%'. $filter['search'] .'%')->orWhere('categories.title_am', 'LIKE', '%'. $filter['search'] .'%')->orWhere('categories.title_ru', 'LIKE', '%'. $filter['search'] .'%');
		}


		if(isset($filter['status']) && $filter['status'] != -1){
			$query->where('categories.parent_id',$filter['status']);    
		}
		$query->whereNull('categories.temp');  
		
		$query->whereNull('categories.deleted_at');

		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();

		foreach ($data as $d) {
			$d->DT_RowId = "row_".$d->DT_RowId;
		}

		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];

		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
    	return $return;
    }
}
