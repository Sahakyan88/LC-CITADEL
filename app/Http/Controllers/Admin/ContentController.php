<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    // Categories
    public function categories(){
        // TODO: add ordering for categories
        $result = Category::select('id','title_en as title','parent_id')->orderBy('id', 'desc')->whereNull('temp')->get();
            
        $self = false;
        if  (count($result) > 0){
            foreach($result as $cat){
                $cats[$cat['parent_id']][$cat['id']] =  $cat;
            }
        }
        $cats = $this->build_options_tree($cats,0,'-',$self,false,[]);
        view()->share('categories', $cats);
        view()->share('menu', 'categories');
        return view('admin.content.category_index');
    }
    
    public  function build_options_tree($cats,$parent_id,$hh,$self,$disabelChiled,$selectedArray,$onlyRoot = false){
        
        $hh = $hh.'--';
        
        if(!is_array($cats) || !isset($cats[$parent_id])){
             return null;
        }

        $tree = '';

        foreach($cats[$parent_id] as $cat){
            $catId = $cat["id"];
            $catParentId = $cat["parent_id"];
            $catTitle = $cat["title"];
            
            $disabled = false;
            $selected = false;

            // If Set some self category
            if($self){
                $selfId = $self["id"];
                $selfParentId = $self["parent_id"];

                // Self or this or parent of this category, or self chiled 
                if(($catParentId === $selfId) || $catId == $selfId){//$
                    $disabelChiled = true;
                    $disabled = true;
                }

                //if this category is parent of self category
                if($catId == $selfParentId){
                    $selected = true;
                }
            }

            if($selectedArray && in_array($catId,$selectedArray)){
                $selected = true;
            }

            if($disabelChiled && $catParentId != 0){
                $disabled = true;       
            }
            if($onlyRoot){
                $disabled = true;       
            }
            $disabled = $disabled ? 'disabled' : '';
            $selected = $selected ? 'selected="selected"' : '';

            $tree .= '<option '.$disabled.' '.$selected.' value='.$catId.'>'.$hh.' '.$catTitle.'</option>';
            $tree .= $this->build_options_tree($cats,$catId,$hh,$self,$disabelChiled,$selectedArray,$onlyRoot);
        }
        return $tree;
    }

    public function categoriesData(Request $request){
        $model = new Category();

        $filter = array('search' => $request->input('search'),
                        'status' => $request->input('filter_status'));

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

    public function getCategory(Request $request){

        $id = (int)$request['id'];
        if($id){
            $item = Category::find($id);
            $mode = "Edit";
        }else{
            $item = new Category();
            $item->parent_id = 0;
            $item->temp = 1;
            $item->created_at = date("Y-m-d H:i:s");
            $max = DB::table('categories')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
            $item->save();
            $mode= "add";
        }

        if($item->icon && $item->icon != null){
            $item->icon = asset('images/backendSmall/'.$item->icon);
        }
        $result = Category::select('id','title_en as title','parent_id')->orderBy('id', 'desc')->whereNull('temp')->get();
            
        $self = false;
        if  (count($result) > 0){
            foreach($result as $cat){
                if($id == $cat['id']){
                    $self = $cat;
                }
                $cats[$cat['parent_id']][$cat['id']] =  $cat;
            }
        }
        
        $cantHaveParent = false;
        if($id != 0){
            $haveChild = Category::select('id')->where('parent_id',$id)->first();
            $cantHaveParent = $haveChild ? true : false; 
        }

        $cats = $this->build_options_tree($cats,0,'-',$self,true,[$item->parent_id],$cantHaveParent);

        $data = json_encode(
            array('data' =>
                (String) view('admin.content.category_item', array(
                    'item'=>$item,
                    'mode' => $mode,
                    'categories' => $cats,
                )),
                'status' => 1)
            );

        return $data;
    }

    public function saveCategory(Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|int',
            'parent_id' => 'int|nullable',
            'published' => 'required|in:0,1',
            'title_am' => 'required|string|min:2|max:50',
            'title_ru' => 'required|string|min:2|max:50',
            'title_en' => 'required|string|min:2|max:50'
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['status'=>0,'errors'=>$validator->errors()->all()]);
        }

        $id = $request['id'];
        $parent_id = $request['parent_id'];
        if($id){
            $item = Category::find($id);
        }else{
            return json_encode(array('status' => 0, 'errors' => 'Id requierd'));
        }
        
        if($parent_id != 0){
            $categoryHasChild = Category::select('id')->where('parent_id',$id)->whereNull('deleted_at')->first();
            if($categoryHasChild){
                return json_encode(array('status' => 0, 'errors' => "This category can we only root, becouse it have subcategory"));    
            }
        }
        $item->temp = null;
        $item->parent_id = $parent_id;
        $item->published = $request['published'];
        $item->title_am = $request['title_am'];
        $item->title_ru = $request['title_ru'];
        $item->title_en = $request['title_en'];
        
        $item->save();
        DB::table('settings')->where('key', 'sync_time')->update(['value' => date("Y-m-d H:i:s")]);
        return json_encode(array('status' => 1));
    }

    public function removeCategory(Request $request){
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $categoryHasChild = Category::select('id')->where('parent_id',$id)->whereNull('deleted_at')->first();
            if($categoryHasChild){
                return json_encode(array('status' => 0, 'message' => "Please first remove or move subcategory"));  
            }
            $item = Category::find($id);
            $item->published = 0;
            $item->save();
            if(!$item->delete()){
                return json_encode(array('status' => 0, 'message' => "Can't remove"));
            }
        }

        $data = json_encode(array('status' => 1));
        return $data;
    }

    public function reorderingCategory(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = Category::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
        DB::table('settings')->where('key', 'sync_time')->update(['value' => date("Y-m-d H:i:s")]);
        exit();
    }
}
