<?php

namespace App\Services;

use Exception;

class ImageService
{
    public function imageUpload($image){
        try{
            if($image != null){
                return $image->store('images', 'public');
            }
        }catch(Exception $ex){
            return response()->json([
                'status' => 500,
                'message' => 'Co loi khi upload anh',
            ], 500);
        }
    }
}