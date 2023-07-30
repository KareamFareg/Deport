<?php
namespace App\Traits;
use Intervention\Image\Facades\Image;
trait  saveImage{

    /**
     * save image
     * @param $photo
     * @param $folder
     * @return string
     */
    public function saveImage($image,$folder,$key=''){
        $file_extension=$image->extension();
        $file_name=time().$key.'.'.$file_extension;
        $location=public_path('assets/images/'.$folder.'/'.$file_name);
        // $img = Image::make($image);

        // $img->resize(1024, 758, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->save($location);
        // $img->save($location);
//        $image->storeAs($folder,$file_name);
        return $file_name;
    }

}
