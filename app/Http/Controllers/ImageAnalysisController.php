<?php

namespace App\Http\Controllers;

use App\Models\ImageAnaly;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageAnalysisController extends Controller
{
    public function uploadAndAnalyze(Request $request)
    {
        $request->validate([
'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,bmp,tiff,svg,heic,avif|max:2048',
        ]);

        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $filename);

        $fullPath = storage_path('app/public/images/' . $filename);
        $pythonScript = base_path('python_script/run.py');

        $command = escapeshellcmd("python \"$pythonScript\" " . escapeshellarg($fullPath));
        $output = shell_exec($command);

        if ($output) {
            $decoded = json_decode($output, true);

            if (isset($decoded['tone'])) {
                $user = auth()->user();
                $customer = $user->customer;

                if ($customer) {
                    $imageUrl = asset('storage/images/' . $filename);

                    if ($customer->image_analysis_id) {
                        $imageAnalysis = ImageAnaly::find($customer->image_analysis_id);

                        if ($imageAnalysis) {
                            $imageAnalysis->update([
                                'image_url' => $imageUrl,
                                'skin_tone_result' => $decoded['tone'],
                            ]);
                        }
                    } else {
                        $imageAnalysis = ImageAnaly::create([
                            'image_url' => $imageUrl,
                            'skin_tone_result' => $decoded['tone'],
                            'customer_id' => $customer->id,
                        ]);

                        // نربط النتيجة بالعميل
                        $customer->update([
                            'image_analysis_id' => $imageAnalysis->id,
                        ]);
                    }

                    return response()->json([
                        'success' => true,
                        'image_url' => $imageUrl,
                        'result' => $decoded,
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'العميل غير موجود'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'فشل في تحليل الصورة'
        ]);
    }
}
