<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\PopularCoursesDetails;
use Validator;

class PopularCoursesDetailsController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $popularCoursesDetails = PopularCoursesDetails::get();

        $response = [];

        foreach ($popularCoursesDetails as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/popularcoursesdetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'popularcourses_id'=>'required',
            'name'=>'required',
            'image'=>'required',
            'duration'=>'required',
            'training_period'=>'required',
            'batch'=>'required',
            'project'=>'required',
            'average_salary'=>'required',
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                    $existingRecord = PopularCoursesDetails::first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            
                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', base_path()) ."/uploads/popularcoursesdetails/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                       
                        $courses = new PopularCoursesDetails();
                        $courses->popularcourses_id = $request->popularcourses_id;
                        $courses->name = $request->name;
                        $courses->image = $file;
                        $courses->duration = $request->duration;
                        $courses->training_period = $request->training_period;
                        $courses->batch = $request->batch;
                        $courses->project = $request->project;
                        $courses->average_salary = $request->average_salary;
                        $courses->save();
                        // $insert_data = courses::insert($data);
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $existingRecord = PopularCoursesDetails::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image;
        $folderPath = str_replace('\\', '/', base_path()) ."/uploads/popularcoursesdetails/";
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $courses = PopularCoursesDetails::find($id);
        $courses->image = $file;
        $courses->popularcourses_id = $request->popularcourses_id;
        $courses->name = $request->name;
        $courses->duration = $request->duration;
        $courses->training_period = $request->training_period;
        $courses->batch = $request->batch;
        $courses->project = $request->project;
        $courses->average_salary = $request->average_salary;
        $courses->save();

        $update_data = $courses->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $courses = PopularCoursesDetails::find($id);
        $courses->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}