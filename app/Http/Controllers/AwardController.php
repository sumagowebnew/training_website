<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Award;
use Validator;

class AwardController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $award = Award::get();

        $response = [];

        foreach ($award as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/award/" . $logo;


            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'=>'required|mimes:jpeg,png,jpg|size:2048',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $award = new Award();
                    
                    // Check if there are any existing records
                    $existingRecord = Award::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            
                    $img_path = $request->image;
                    createDirecrotory('/all_web_data/images/award/');
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/award/";

                    
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath.$file;
            
                    file_put_contents($file_dir, $image_base64);
                    $award->image = $file;
                    
                    $award->save();
            
                    return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
    }
    public function delete($id)
    {
        $all_data=[];
        $award_details = Award::find($id);
        $award_details->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}