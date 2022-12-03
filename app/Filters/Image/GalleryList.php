<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class GalleryList implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(80, 80, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}