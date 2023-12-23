<?php

namespace App\Traits;

use App\Models\Product;

trait ImageTraint
{

    public function StoreImage($folder_name, $request, $dist)
    {
        $imageFile = $request->file('image');
        $image_name = $request->title . '' . $imageFile->getClientOriginalName();
        $imageFile->storeAs($folder_name, $image_name, $dist);
    }


    // image delete
    public function DeleteImage($image_name, $path)
    {
        $imageUrl = $image_name;
        $filename = pathinfo($imageUrl, PATHINFO_BASENAME);

        $imagePath = public_path('' . $path . '' . $filename);

        unlink($imagePath);
    }
}
