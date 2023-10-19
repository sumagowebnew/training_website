<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\HighlightDetails;
use Validator;

class HighlightDetailsController extends Controller
{
    public function index(Request $request)
    {
        $all_data = HighlightDetails::where('course_id',$request->id)->get();
        $response = [];

        foreach ($all_data as $item) {
            $data = $item->toArray();

            $highlights = $data['highlights'];

            $data['highlights'] = $highlights;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function all_highlightDetails(Request $request)
    {
        $all_data = HighlightDetails::get()->toArray();
        $all_data = HighlightDetails::join('subcourses', 'subcourses.id', '=', 'highlight_details.course_id')
        ->get(['highlight_details.*','subcourses.name AS subcoursename']);

        $response = [];
        foreach ($all_data as $item) {
            $data = $item->toArray();
            $data['table_name'] = 'highlight_details';
            $response[] = $data;
            
        }

        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'course_id'=>'required',
            'highlights'=>'required',
        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
                $programs = new HighlightDetails();
                $programs->course_id = $request->course_id;
                $programs->highlights = $request->highlights;
                $programs->save();
                return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'course_id'=>'required',
            'highlights'=>'required',
        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
        $count = HighlightDetails::find($id);
        $count->course_id = $request->course_id;
        $count->highlights = json_encode($request->highlights);

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = HighlightDetails::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
    }

   
}