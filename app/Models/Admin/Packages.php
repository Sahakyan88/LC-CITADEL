<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Packages extends Model
{
    use HasFactory;
	protected $table = 'orders';
    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('orders')->select(array(DB::raw('SQL_CALC_FOUND_ROWS orders.id'), 
        'orders.id as DT_RowId',
        'orders.status',
        'orders.total_amount as amount',
        'users.first_name',
        'users.last_name',
        'users.phone',
        'services.title_am as title',
        'package_user.created_at as date',
        'package_user.paid_at as paid',
     
        ))->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->leftJoin('services', 'services.id', '=', 'orders.product_id')
        ->leftJoin('package_user', 'package_user.user_id', '=', 'orders.user_id')
        ->where('services.featured', 0);    
      
		if($length != '-1'){
			$query->skip($start)->take($length);
		}
        if(isset($filter['status'])){
			$query->where('orders.status',$filter['status']);    
		}
		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('users.first_name', 'LIKE', '%'. $filter['search'] .'%')->orWhere('users.last_name', 'LIKE', '%'. $filter['search'] .'%')->where('users.id', '=', 'orders.user_id');
		}
       
		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();
		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
		$return['data'] = $data;

		$return['count'] = $count->recordsTotal;
    	return $return;
    }
}
