<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\EventDetails;

use Validator;

class EventDetailsController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $eventDetails = EventDetails::get();
        $response = [];
        foreach ($eventDetails as $item) {
            $data = $item->toArray();
            $logo = $data['image'];
            $imagePath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/eventDetails/" .$logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64;
            $response[] = $data;
        }
        return response()->json($response);
    }

    public function get_events_bycourse(Request $request,$id)
    {
        // Get all data from the database
        $eventDetails = EventDetails::where('subcourse_id',$id)->get();
        $response = [];
        foreach ($eventDetails as $item) {
            $data = $item->toArray();
            $logo = $data['image'];
            $imagePath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/eventDetails/" .$logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64;
            $response[] = $data;
        }
        return response()->json($response);
    }

    public function get_events_byevent(Request $request,$id)
    {
        // Get all data from the database
        $eventDetails = EventDetails::Join('event_list', function($join) {
            $join->on('event_details.event_id', '=', 'event_list.id');
          })
         ->select('event_details.*',
         'event_list.title AS event_name'
         )->where('event_details.event_id',$id)->get();
        $response = [];
        foreach ($eventDetails as $item) {
            $data = $item->toArray();
            $logo = $data['image'];
            $imagePath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/eventDetails/" .$logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64;
            $response[] = $data;
        }
        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'description'=>'required',
            'event_id'=>'required',
            'subcourse_id'=>'required',
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                    $existingRecord = EventDetails::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            
                    $img_path = $request->image;
                    createDirecrotory('/all_web_data/images/eventDetails/');
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/eventDetails/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                       
                        $courses = new EventDetails();
                        $courses->image = $file;
                        $courses->title = $request->title;
                        $courses->description = $request->description;
                        $courses->event_id = $request->event_id;
                        $courses->subcourse_id = $request->subcourse_id;
                        $courses->save();
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $existingRecord = EventDetails::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image;
        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/eventDetails/";
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $courses = EventDetails::find($id);
        $courses->image = $file;
        $courses->title = $request->title;
        $courses->description = $request->description;
        $courses->event_id = $request->event_id;
        $courses->subcourse_id = $request->subcourse_id;
        $update_data = $courses->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $courses = EventDetails::find($id);
        $courses->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
    }

   
}