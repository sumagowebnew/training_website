<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\ProgramDetails;
use Validator;

class ProgramDetailsController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $programdetails = ProgramDetails::get();

        $response = [];

        foreach ($programdetails as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/programdetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function view($id)
    {
        // Get all data from the database
        $programdetails = ProgramDetails::Where('program_id', $id)->get();

        $response = [];

        foreach ($programdetails as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/programdetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_id'=>'required',
            'introduction'=>'required',
            'course_overview'=>'required',
            'learning_outcome'=>'required',
            'prerequisite'=>'required',
            'duration'=>'required',
            'training_period'=>'required',
            'batch'=>'required',
            'project'=>'required',
            'average_salary'=>'required',
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                    $existingRecord = ProgramDetails::first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            
                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', base_path()) ."/uploads/programdetails/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                       
                        $courses = new ProgramDetails();
                        $courses->image = $file;
                        $courses->program_id = $request->program_id;
                        $courses->introduction = $request->introduction;
                        $courses->course_overview = $request->course_overview;
                        $courses->learning_outcome = $request->learning_outcome;
                        $courses->prerequisite = $request->prerequisite;
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
        $existingRecord = ProgramDetails::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image;
        $folderPath = str_replace('\\', '/', base_path()) ."/uploads/programdetails/";
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $courses = ProgramDetails::find($id);
        $courses->image = $file;
        $courses->program_id = $request->program_id;
        $courses->introduction = $request->introduction;
        $courses->course_overview = $request->course_overview;
        $courses->learning_outcome = $request->learning_outcome;
        $courses->prerequisite = $request->prerequisite;
        $courses->duration = $request->duration;
        $courses->training_period = $request->training_period;
        $courses->batch = $request->batch;
        $courses->project = $request->project;
        $courses->average_salary = $request->average_salary;

        $update_data = $courses->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $courses = ProgramDetails::find($id);
        $courses->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}