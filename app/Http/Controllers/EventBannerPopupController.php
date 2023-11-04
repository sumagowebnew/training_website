<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\EventBannerPopup;
use Illuminate\Support\Facades\Storage;


use Validator;

class EventBannerPopupController extends Controller
{
    public function index(Request $request)
    {
        $all_data = EventBannerPopup::get();
        $response = [];

        foreach ($all_data as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/eventbannerpopup/".$logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;
            $data['table_name'] = 'event_banner_popup';

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'image'=>'required|mimes:jpeg,png,jpg|size:2048',
        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
               
                $existingRecord = EventBannerPopup::orderBy('id','DESC')->first();
                $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
        
                $image = $request->image;
                createDirecrotory('/all_web_data/images/eventbannerpopup/');
                $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/eventbannerpopup/";
                
                $base64Image = explode(";base64,", $image);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);
        
                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath.$file;
        
                file_put_contents($file_dir, $image_base64);
                $programs = new EventBannerPopup();
                $programs->image = $file;
                $programs->save();
                return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    
    // public function update(Request $request, $id)
    // {
    //     $existingRecord = EventBannerPopup::first();
    //     $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

    //     $img_path = $request->image;
    //     $folderPath = str_replace('\\', '/', base_path()) ."/all_web_data/images/eventbannerpopup/";
    //     $base64Image = explode(";base64,", $img_path);
    //     $explodeImage = explode("image/", $base64Image[0]);
    //     $imageType = $explodeImage[1];
    //     $image_base64 = base64_decode($base64Image[1]);

    //     $file = $recordId . '.' . $imageType;
    //     $file_dir = $folderPath . $file;

    //     file_put_contents($file_dir, $image_base64);
    //     $courses = EventBannerPopup::find($id);
    //     $courses->images = $file;
      
    //     $update_data = $courses->update();
    //     return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    // }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'image'=>'required|mimes:jpeg,png,jpg|size:2048',
        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
        $image = $request->image;
        createDirecrotory('/all_web_data/images/eventbannerpopup/');
        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/eventbannerpopup/";
        
        $base64Image = explode(";base64,", $image);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $id.'_updated' . '.' . $imageType;
        $file_dir = $folderPath.$file;

        file_put_contents($file_dir, $image_base64);
            $contact_details = EventBannerPopup::find($id);
            $contact_details->image = $file;

            $update_data = $contact_details->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }

    }
    
    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(),
    //     [
    //         'image'=>'required',
            

    //     ]);
        
    //     if($validator->fails())
    //     {
    //             return $validator->errors()->all();
    //     }else{
    //     $image = $request->EventBannerPopup;
    //     createDirecrotory('/all_web_data/images/eventbannerpopup/');
    //     $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/eventbannerpopup/";
        
    //     $base64Image = explode(";base64,", $image);
    //     $explodeImage = explode("image/", $base64Image[0]);
    //     $imageType = $explodeImage[1];
    //     $image_base64 = base64_decode($base64Image[1]);

    //     $file = $id . '_updated.' . $imageType;
    //     $file_dir = $folderPath.$file;

    //     file_put_contents($file_dir, $image_base64);
    //     $programs = EventBannerPopup::find($id);
    //     $programs->EventBannerPopup = $file;
    //     $update_data = $programs->update();
    //     return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    //     }
    // }

    
    public function delete($id)
    {
        $all_data=[];
        $eventimagepopup = EventBannerPopup::find($id);
        $eventimagepopup->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}