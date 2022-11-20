<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Order;
use App\Models\Admin\Category;

class OrderController extends Controller
{
    public function index(){
        // $result = Category::select('id','title_en as title','parent_id')->orderBy('id', 'desc')->get();
            
        // if  (count($result) > 0){
        //     foreach($result as $cat){
        //         $cats[$cat['parent_id']][$cat['id']] =  $cat;
        //     }
        // }
        // $cats = $this->build_options_tree($cats,0,'-',false,false,[]);
        // view()->share('categories', $cats);
        view()->share('menu', 'orders');
        
        return view('admin.orders');
    }
    
    
    public function getOrder(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';
        
        $item =  DB::table('orders')->select('id','sku','total','status','created_at')->where('orders.id', $id)->first();
        
        $data = json_encode(
            array('data' => 
                (String) view('admin.order', array('item'=>$item)),'status' => 1)
            );
        return $data; 
    }

    public function data(Request $request){
        $model = new Order();

        $filter = array(
            'status' => $request->input('filter_status'),
            'type' => $request->input('filter_type'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        );

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

    // public  function build_options_tree($cats,$parent_id,$hh,$self,$disabelChiled,$selectedArray){
        
    //     $hh = $hh.'--';
        
    //     if(!is_array($cats) || !isset($cats[$parent_id])){
    //          return null;
    //     }

    //     $tree = '';

    //     foreach($cats[$parent_id] as $cat){
    //         $catId = $cat["id"];
    //         $catParentId = $cat["parent_id"];
    //         $catTitle = $cat["title"];
            
    //         $disabled = false;
    //         $selected = false;

    //         // If Set some self category
    //         if($self){
    //             $selfId = $self["id"];
    //             $selfParentId = $self["parent_id"];

    //             // Self or this or parent of this category, or self chiled 
    //             if(($catParentId === $selfId) || $catId == $selfId){//$disabelChiled
    //                 $disabelChiled = true;
    //                 $disabled = true;
    //             }

    //             //if this category is parent of self category
    //             if($catId == $selfParentId){
    //                 $selected = true;
    //             }
    //         }

    //         if($selectedArray && in_array($catId,$selectedArray)){
    //             $selected = true;
    //         }

    //         $disabled = $disabled ? 'disabled' : '';
    //         $selected = $selected ? 'selected="selected"' : '';

    //         $tree .= '<option '.$disabled.' '.$selected.' value='.$catId.'>'.$hh.' '.$catTitle.'</option>';
    //         $tree .= $this->build_options_tree($cats,$catId,$hh,$self,$disabelChiled,$selectedArray);
    //     }
    //     return $tree;
    // }
}