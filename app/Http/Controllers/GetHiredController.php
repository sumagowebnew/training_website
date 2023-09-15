<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\GetHired;
use Validator;

class GetHiredController extends Controller
{
    public function index(Request $request)
    {
        $gethired = GetHired::get();

        $response = [];

        foreach ($gethired as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/gethired/" . $logo;


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
            'title'=>'required',
            'description'=>'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $news = new GetHired();
                    
                    // Check if there are any existing records
                    $existingRecord = GetHired::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $title = $request->title;
                    $img_path = $request->image;
                    createDirecrotory('/all_web_data/images/gethired/');
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/gethired/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                    $news->image = $file;
                    $news->title = $request->title;
                    $news->description = $request->description;
                    $news->save();
            
                    return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
    }
    public function update(Request $request, $id)
    {
        $count = GetHired::find($id);
        $existingRecord = GetHired::orderBy('id','DESC')->first();
   
        $img_path = $request->image;
        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/gethired/";

        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $id . '_updated.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $count->image = $file;
        $count->title = $request->title;
        $count->description = $request->description;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }
    public function delete($id)
    {
        $all_data=[];
        $certificate = GetHired::find($id);
        $certificate->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}