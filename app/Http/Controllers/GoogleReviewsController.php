<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\GoogleReviews;
use Validator;

class GoogleReviewsController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $googlereview = GoogleReviews::get();

        $response = [];

        foreach ($googlereview as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/googlereviews/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'=>'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $googlereviews = new GoogleReviews();
                    
                    // Check if there are any existing records
                    $existingRecord = GoogleReviews::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            
                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', base_path()) ."/uploads/googlereviews/";
                    
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath.$file;
            
                    file_put_contents($file_dir, $image_base64);
                    $googlereviews->image = $file;
                    
                    $googlereviews->save();
            
                    return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
    }
    public function update(Request $request, $id)
    {
        
            $googlereviews = GoogleReviews::find($id);
            $img_path = $request->image;
            $folderPath = str_replace('\\', '/', base_path()) ."/uploads/googlereviews/";
            
            $base64Image = explode(";base64,", $img_path);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);
    
            $file = $id . '.' . $imageType;
            $file_dir = $folderPath.$file;
    
            file_put_contents($file_dir, $image_base64);
            $googlereviews->image = $file;

            $update_data = $googlereviews->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }
    public function delete($id)
    {
        $all_data=[];
        $googlereviews = GoogleReviews::find($id);
        $googlereviews->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}