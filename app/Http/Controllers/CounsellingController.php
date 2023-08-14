<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Counselling;
use Validator;
class CounsellingController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Counselling::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'fullname'=>'required',
        'email'=>'required',
        'contact'=>'required|numeric|digits:10',
        'work_experience' => 'required',
        'schedule_datetime' => 'required',
        'interest' => 'required',
        
        ]);

    if ($validator->fails()) {
        return $validator->errors()->all();

    }else{
        $Enquiries = new Counselling();
        $Enquiries->fullname = $request->fullname;
        $Enquiries->email = $request->email;
        $Enquiries->contact = $request->contact;
        $Enquiries->work_experience = $request->work_experience;
        $Enquiries->schedule_datetime = $request->schedule_datetime;
        $Enquiries->interest = $request->interest;
        $Enquiries->save();
        // $insert_data = ContactEnquiries::insert($data);
        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
    }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fullname'=>'required',
            'email'=>'required',
            'contact'=>'required|numeric|digits:10',
            'work_experience' => 'required',
            'schedule_datetime' => 'required',
            'interest' => 'required',
            
            ]);
    
        if ($validator->fails()) {
            return $validator->errors()->all();
    
        }else{
            $consult = Counselling::find($id);
            $consult->fullname = $request->fullname;
            $consult->email = $request->email;
            $consult->contact = $request->contact;
            $consult->work_experience = $request->work_experience;
            $consult->schedule_datetime = $request->schedule_datetime;
            $consult->interest = $request->interest;

            $update_data = $consult->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }
        }

    public function delete($id)
    {
        $all_data=[];
        $enquiries = Counselling::find($id);
        $enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}