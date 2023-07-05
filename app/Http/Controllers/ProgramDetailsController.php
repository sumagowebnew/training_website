<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\ProgramDetails;
use Validator;

class ProgramDetailsController extends Controller
{
    public function index(Request $request)
    {
        $all_data = ProgramDetails::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
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
                        $courses = new ProgramDetails();
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
        $courses = ProgramDetails::find($id);
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