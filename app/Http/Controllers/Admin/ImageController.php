<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ImageDB;
use Response;
use Validator;

class ImageController extends Controller
{
	protected $request;

    public function __construct(Request $request, Redirector $redirector)
    {
        $this->request = $request;
    }
    
    public function upload(){
        $image = $this->request->file('file');
        $gallery_id = (int)$this->request->input('gallery_id');
        $temp = (int)$this->request->input('temp');
        $avatar = (int)$this->request->input('avatar');
        $master = (int)$this->request->input('master');
        $original = (int)$this->request->input('original');
        $filename = $this->request->input('filename');

        $thumb = $this->request->input('thumb') ? $this->request->input('thumb') : 'path';
        
        $fileArray = array('image' => $image);

        $rules = array(
          'image' => 'mimes:jpeg,jpg,JPG,png|required|max:200000' // max 10000kb
        );

        $validator = Validator::make($fileArray, $rules);
        if ($validator->fails())
        {   
            $messages = $validator->errors();
            
            $responseMessages = '';
            foreach ($messages->all(':message') as $message) {
                $responseMessages .= $message;
            }
            return Response::json(['status' => 0, 'message'=> $responseMessages]);
        }else{
            $model = new ImageDB();
           
            if($avatar){
                $image = $model->addAvatar($image,$avatar); 
                return Response::json(['status' => 1, 'imageId'=> $avatar, 'path' => $image ]);
            }
            if($master){
                $image = $model->master($image,$master);
                return Response::json(['status' => 1, 'imageId'=> $master, 'path' => $image ]);
            }else{
                $image = $model->add($image,$gallery_id,$temp);
                return Response::json(['status' => 1, 'imageId'=> $image->id, 'path' => $image->$thumb ]);
            }
        }
    }

    public function remove(){
        $image_id = (int)$this->request->input('imageId');
        $avatar = (int)$this->request->input('avatar');
        $category = (int)$this->request->input('category');
        
        $model = new ImageDB();
        if($avatar){
            $model->removeAvatar($avatar);
        }elseif($category){
            $model->removeCategoryImage($category);
        }else{
            $model->remove($image_id);
        }
        return true;
    }

    public function sort(){
        $imageIds = $this->request->input('ids');
        foreach($imageIds as $value => $key)
        {
            $image = ImageDB::find($key);
            $image->ordering = $value;
            $image->save();
        }
    }
}
