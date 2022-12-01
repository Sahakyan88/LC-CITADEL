<?php



namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;


class Team extends Model
{
    public $multilangualFiled = false;

    protected $table = 'teams';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('teams');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS teams.id'),
            'teams.id as DT_RowId',
            'teams.title_en as title',
            'teams.ordering as ordering',
            'teams.published as published'));

        if($length != '-1'){
            $query->skip($start)->take($length);
        }
        if( isset($filter['search']) && strlen($filter['search']) > 0 ){
            $query->where('teams.title_en', 'LIKE', '%'. $filter['search'] .'%');
        }
        $query->orderBy($sort_field, $sort_dir);
        $data = $query->get();
        $count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
        $return['data'] = $data;
        $return['count'] = $count->recordsTotal;
        return $return;
    }
   
}

