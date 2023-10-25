<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Syllabus;
use Validator;

class SyllabusController extends Controller
{
    public function index(Request $request)
    {
        // $all_data = Syllabus::where('course_id',$request->id)->get()->toArray();
        // $all_data = Syllabus::Join('module', function($join) {
        //     $join->on('syllabus.module_id', '=', 'module.id');
        //     $join->on('syllabus.course_id', '=', 'subcourses.id');
        //   })
        //  ->select('syllabus.*',
        //  'module.title','subcourses.name'
        //  )->where('course_id',$request->id)->get()->toArray();

         $all_data = Syllabus::leftJoin('subcourses', 'subcourses.id', '=', 'syllabus.course_id')
         ->join('module', 'module.id', '=', 'syllabus.module_id')
         ->select("syllabus.*",
         'subcourses.name as subcourses_name',
         'module.title as module_name'
         )->where('syllabus.course_id',$request->id)
         ->get()->toArray();

        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function all_syllabus(Request $request)
    {
        // // $all_data = Syllabus::get()->toArray();
        // $all_data = Syllabus::Join('module', function($join) {
        //     $join->on('syllabus.module_id', '=', 'module.id');
        //     $join->on('syllabus.course_id', '=', 'subcourses.id');
        //   })
        //  ->select('syllabus.*',
        //  'module.title','subcourses.name'
        //  )->get()->toArray();

        
        $all_data = Syllabus::leftJoin('subcourses', 'subcourses.id', '=', 'syllabus.course_id')
        ->join('module', 'module.id', '=', 'syllabus.module_id')
        ->select("syllabus.*",
        'subcourses.name as subcourses_name',
        'module.title as module_name'
        )->get()->toArray();

        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'course_id'=>'required',
            'module_id'=>'required',
            'title'=>'required',
            'description'=>'required',
        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
                $programs = new Syllabus();
                $programs->course_id = $request->course_id;
                $programs->module_id = $request->module_id;
                $programs->title = $request->title;
                $programs->description = $request->description;
                $programs->save();
                return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'course_id'=>'required',
            'module_id'=>'required',
            'title'=>'required',
            'description'=>'required',
        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
        $count = Syllabus::find($id);
        $count->course_id = $request->course_id;
        $count->module_id = $request->module_id;
        $count->title = $request->title;
        $count->description = $request->description;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = Syllabus::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
    }

   
}