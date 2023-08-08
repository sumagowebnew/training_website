<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Mentor;
use Validator;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Mentor::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'designation'=>'required',
            'company'=>'required',
            'image'=>'required'

            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                        $programs = new Mentor();
                        $existingRecord = Mentor::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                
                        $img_path = $request->image;
                        $folderPath = str_replace('\\', '/', base_path()) ."/uploads/events/";
                        
                        $base64Image = explode(";base64,", $img_path);
                        $explodeImage = explode("image/", $base64Image[0]);
                        $imageType = $explodeImage[1];
                        $image_base64 = base64_decode($base64Image[1]);
                
                        $file = $recordId . '.' . $imageType;
                        $file_dir = $folderPath.$file;
                
                        file_put_contents($file_dir, $image_base64);
                        $programs->name = $request->name;
                        $programs->image = $file;
                        $programs->designation = $request->designation;
                        $programs->company = $request->company;
                        $programs->save();
                        // $insert_data = programs::insert($data);
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $count = Mentor::find($id);
        $existingRecord = Mentor::orderBy('id','DESC')->first();

        $img_path = $request->image;
        $folderPath = str_replace('\\', '/', base_path()) ."/uploads/events/";
        
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $id . '.' . $imageType;
        $file_dir = $folderPath.$file;

        file_put_contents($file_dir, $image_base64);
        $count->name = $request->name;
        $count->image = $file;
        $count->designation = $request->designation;
        $count->company = $request->company;
        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = Mentor::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}