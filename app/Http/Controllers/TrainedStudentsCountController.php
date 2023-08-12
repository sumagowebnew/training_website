<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\TrainedStudentsCount;
use Validator;
class TrainedStudentsCountController extends Controller
{
    public function index(Request $request)
    {
        $all_data = TrainedStudentsCount::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'count' => 'required|numeric',
            'name'=>'required',
            ]);
        
        if ($validator->fails()) {
                return $validator->errors()->all();
    
        }else{
            $Count = new TrainedStudentsCount();
            $Count->name = $request->name;
            $Count->count = $request->count;
            $Count->save();
            // $insert_data = ContactEnquiries::insert($data);
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }


    public function update(Request $request, $id)
    {
        
            $count = TrainedStudentsCount::find($id);
            $count->name = $request->name;
            $count->count = $request->count;

            $update_data = $count->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $count = TrainedStudentsCount::find($id);
        $count->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact HomeCounter Deleted Successfully!");
    }

   
}