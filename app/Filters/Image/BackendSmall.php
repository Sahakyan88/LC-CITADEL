<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class BackendSmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(50, 50, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}