<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Certificate;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $certificate = Certificate::get();

        $response = [];

        foreach ($certificate as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/certificate/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        try {
            $news = new Certificate();
            
            // Check if there are any existing records
            $existingRecord = Certificate::first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            $title = $request->title;
            $img_path = $request->image;
            $folderPath = str_replace('\\', '/', base_path()) ."/uploads/certificate/";
            $base64Image = explode(";base64,", $img_path);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);
    
            $file = $recordId . '.' . $imageType;
            $file_dir = $folderPath . $file;
    
            file_put_contents($file_dir, $image_base64);
            $news->image = $file;
            $news->title = $request->title;
            $news->save();
    
            return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
        } 
        catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        $all_data=[];
        $certificate = Certificate::find($id);
        $certificate->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}