<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Subcourses;
use Validator;

class SubcoursesController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Subcourses::join('course_fee_details', function($join) {
            $join->on('subcourses.id', '=', 'course_fee_details.sub_course_id');
          })
          ->where('subcourses.course_id',$request->id)
          ->select([
              'subcourses.course_id as subcourses_course_id', 
              'subcourses.id as subcourses_id', 
              'subcourses.name as subcourses_name', 
              'course_fee_details.id as course_fee_details_id',
              'course_fee_details.sub_course_duration as sub_course_duration'             
          ])->get();

        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function all_course(Request $request)
    {
        $all_data = Subcourses::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name'=>'required',
        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
                $programs = new Subcourses();
                $programs->course_id = $request->course_id;
                $programs->name = $request->name;
                $programs->save();
                return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function update(Request $request, $id)
    {
        $count = Subcourses::find($id);
        $count->name = $request->name;
        $count->course_id = $request->course_id;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = Subcourses::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
    }

   
}