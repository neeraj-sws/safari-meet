<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class CkEditorController extends Controller
{
    public function ImageUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $image = $request->file('upload');
            $path = 'uploads/species/test';
            $origPath = $image->store($path, 'public_root');
            $avifPath = ImageHelper::convertToAvif($origPath, $path);

            return response()->json([
                'uploaded' => true,
                'url' => asset($avifPath)
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'No file uploaded.'
            ]
        ], 400);
    }
}
