<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function saveImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/images', $filename);
    
        return response()->json([
            'message' => 'Image uploaded successfully',
            'url' => asset('storage/images/' . $filename)
        ]);
    }


    public function uploadAndAnalyze(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);


    $image = $request->file('image');
    $filename = time() . '.' . $image->getClientOriginalExtension();
    $path = $image->storeAs('public/images', $filename);

    $fullPath = storage_path('app/public/images/' . $filename); 

    $pythonScript = base_path('python_script/run.py');
    $imagePathArg = escapeshellarg($fullPath);
    $command = escapeshellcmd("python \"$pythonScript\" $imagePathArg");
    $output = shell_exec($command);

   
    if ($output) {
        $decoded = json_decode($output, true);
        return response()->json([
            'success' => true,
            'image_url' => asset('storage/images/' . $filename),
            'result' => $decoded
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'فشل في تحليل الصورة'
    ]);
}

    
}
