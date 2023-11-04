<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Highlight;
use Validator;
class HighlightController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Highlight::get();
        $response = [];

        foreach ($all_data as $item) {
            $data = $item->toArray();

            $logo = $data['icon'];

            $imagePath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/icon/".$logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['icon'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'title'=>'required',
        'icon'=>'required',
        
        ]);

    if ($validator->fails()) {
        return $validator->errors()->all();

    }else{
        $existingRecord = Highlight::orderBy('id','DESC')->first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $image = $request->icon;
        createDirecrotory('/all_web_data/images/icon/');
        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/icon/";
        
        $base64Image = explode(";base64,", $image);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath.$file;

        file_put_contents($file_dir, $image_base64);
        $Enquiries = new Highlight();
        $Enquiries->title = $request->title;
        $Enquiries->icon = $file;
        $Enquiries->save();
        // $insert_data = ContactEnquiries::insert($data);
        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
    }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'icon'=>'required',

            ]);
    
        if ($validator->fails()) {
            return $validator->errors()->all();
    
        }else{
            $image = $request->icon;
            createDirecrotory('/all_web_data/images/icon/');
            $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/icon/";
            
            $base64Image = explode(";base64,", $image);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);
    
            $file = $id . '_updated.' . $imageType;
            $file_dir = $folderPath.$file;
    
            file_put_contents($file_dir, $image_base64);
            $consult = Highlight::find($id);
            $consult->title = $request->title;
            $consult->icon = $file;
            $update_data = $consult->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }
    }

    public function delete($id)
    {
        $all_data=[];
        $enquiries = Highlight::find($id);
        $enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}