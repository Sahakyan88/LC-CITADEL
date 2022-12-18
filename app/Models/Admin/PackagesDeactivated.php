<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PackagesDeactivated extends Model
{
    use HasFactory;
	protected $table = 'orders';
    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
        $query = DB::table('package_user')->select(array(DB::raw('SQL_CALC_FOUND_ROWS package_user.id'),
            'package_user.id as DT_RowId',
            'services.price as amount',
            'users.first_name',
            'users.last_name',
            'users.phone',
            'services.title_am as title',
            'package_user.paid_at as date',
            'package_user.deactivated_at as deactivated',
            'package_user.is_blocked',
        ))
            ->leftJoin('services', 'services.id', '=', 'package_user.package_id')
            ->leftJoin('users', 'users.id', '=', 'package_user.user_id')
            ->where('package_user.is_blocked', 1)
            ->where('services.featured', 0);

		if($length != '-1'){
			$query->skip($start)->take($length);
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
