<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\SubcourseDetails;
use Validator;

class SubcourseDetailsController extends Controller
{
    public function index(Request $request)
    {
        $all_data = SubcourseDetails::where('course_id',$request->id)->get();
        $response = [];

        foreach ($all_data as $item) {
            $data = $item->toArray();

            $logo = $data['banner'];

            $imagePath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/course_banner/".$logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['banner'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function get_subcourse_details_list(Request $request)
    {
        $all_data = SubcourseDetails::get();
        $response = [];

        foreach ($all_data as $item) {
            $data = $item->toArray();

            $logo = $data['banner'];

            $imagePath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/course_banner/".$logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['banner'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'title'=>'required',
            'description'=>'required',
            'course_id'=>'required',
            'custome_text'=>'required',
        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
               
                $existingRecord = SubcourseDetails::orderBy('id','DESC')->first();
                $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
        
                $image = $request->banner;
                createDirecrotory('/all_web_data/images/course_banner/');
                $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/course_banner/";
                
                $base64Image = explode(";base64,", $image);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);
        
                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath.$file;
        
                file_put_contents($file_dir, $image_base64);
                $programs = new SubcourseDetails();
                $programs->course_id = $request->course_id;
                $programs->title = $request->title;
                $programs->description = $request->description;
                $programs->custome_text = $request->custome_text;
                $programs->banner = $file;
                $programs->save();
                return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'title'=>'required',
            'description'=>'required',
            'course_id'=>'required',
            'custome_text'=>'required',

        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
        $image = $request->banner;
        createDirecrotory('/all_web_data/images/course_banner/');
        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/course_banner/";
        
        $base64Image = explode(";base64,", $image);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $id . '_updated.' . $imageType;
        $file_dir = $folderPath.$file;

        file_put_contents($file_dir, $image_base64);
        $programs = SubcourseDetails::find($id);
        $programs->course_id = $request->course_id;
        $programs->title = $request->title;
        $programs->description = $request->description;
        $programs->custome_text = $request->custome_text;
        $programs->banner = $file;
        $update_data = $programs->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = SubcourseDetails::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
    }

   
}