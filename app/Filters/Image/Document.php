<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Document implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(800, 708, function ($constraint) {
		    $constraint->upsize();
		});
    }
}