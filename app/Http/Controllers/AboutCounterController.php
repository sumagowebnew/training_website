<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\AboutCounter;
use Validator;
class AboutCounterController extends Controller
{
    public function index(Request $request)
    {
        $all_data = AboutCounter::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'count' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();

        }else{
            $Count = new AboutCounter();
            $Count->name = $request->name;
            $Count->count = $request->count;
            $Count->save();
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);

        }
        
        // $insert_data = ContactEnquiries::insert($data);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();

        }else{
        $count = AboutCounter::find($id);
        $count->name = $request->name;
        $count->count = $request->count;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }
    }

    public function delete($id)
    {
        $all_data=[];
        $count = Aboutcounter::find($id);
        $count->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact AboutCounter Deleted Successfully!");
    }

   
}