<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Events;
use Validator;

class EventsController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Events::where('course_id',$request->id)->get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }

    public function all_events(Request $request)
    {
        $all_data = Events::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'course_id'=>'required',
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                        $programs = new Events();
                        $existingRecord = Events::orderBy('id','DESC')->first();
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
                        $programs->start_time = $request->start_time;
                        $programs->start_date = $request->start_date;
                        $programs->duration = $request->duration;
                        $programs->registered_people = $request->registered_people;
                        $programs->course_id = $request->course_id;
                        $programs->save();
                        // $insert_data = programs::insert($data);
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'course_id'=>'required',
            ]);
        
        if ($validator->fails()) {
                return $validator->errors()->all();
    
            }else{
                $count = Events::find($id);
                $existingRecord = Events::orderBy('id','DESC')->first();

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
                $count->image =  $file;
                $count->start_time = $request->start_time;
                $count->start_date = $request->start_date;
                $count->duration = $request->duration;
                $count->registered_people = $request->registered_people;
                $count->course_id = $request->course_id;
                $update_data = $count->update();
                return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
            }
            }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = Events::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}