<?php

namespace App\Http\Controllers\Util;

use App\Services\Http\Response\APIResponse;
use Illuminate\Http\Request;

class DropZoneFileUploadController
{
    public function __invoke(Request $request)
    {
        try {
            $folder = !empty($request->path) ? $request->path : 'public/uploads/media';
            $imagePath = uploadFile($request->file('file'), $folder);

            return APIResponse::build()
                ->status('success')
                ->data([
                    'imagePath' => $imagePath,
                ])
                ->send();
        } catch (\Throwable $e) {
            return APIResponse::build()
                ->status('error')
                ->message($e->getMessage())
                ->send();
        }
    }
}
