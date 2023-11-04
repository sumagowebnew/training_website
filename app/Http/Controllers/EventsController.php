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
        $all_data = Events::where('event_id',$request->id)->get()->toArray();
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
            'start_time'=>'required',
            'start_date'=>'required',
            'duration'=>'required',
            'registered_people'=>'required',
            'image'=>'required|mimes:jpeg,png,jpg|size:2048',
            'event_id'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
                }else{
                        $programs = new Events();
                        $existingRecord = Events::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                
                        $img_path = $request->image;
                        $folderPath =str_replace('\\', '/', storage_path())."/all_web_data/images/events/";

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
                        $programs->course_id = '0';
                        $programs->event_id = $request->event_id;

                        $programs->save();
                        // $insert_data = programs::insert($data);
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'start_time'=>'required',
            'start_date'=>'required',
            'duration'=>'required',
            'registered_people'=>'required',
            'image'=>'required|mimes:jpeg,png,jpg|size:2048',
            'event_id'=>'required',
            ]);
        
        if ($validator->fails()) {
                return $validator->errors()->all();
    
            }else{
                $count = Events::find($id);
                $existingRecord = Events::orderBy('id','DESC')->first();

                $img_path = $request->image;
                $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/events/";

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
                $count->course_id = '0';
                $count->event_id = $request->event_id;
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