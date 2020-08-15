<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CkeditorUploadController
{
    public function uploadImage(Request $request)
    {
        $image = request()->file('upload');
        if($image->getSize() > 1024 * 1024 * 6) {
            return json_encode(['uploaded' => 0, 'error' => ['message' => '图片不能大于 6MB!']]);
        }

        $path = $image->store('ck_images/'.date('Ymd'));

        $url = Storage::disk('public')->url($path);

        return json_encode(['uploaded' => 1, 'fileName' => $image->hashName(), 'url' => $url]);
    }
}
