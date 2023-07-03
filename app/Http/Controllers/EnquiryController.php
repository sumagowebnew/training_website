<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Enquiry;
use Validator;
class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Enquiry::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'phone' => 'required|numeric|digits:10',
        'name'=>'required',
        ]);

    if ($validator->fails()) {
        return $validator->errors()->all();

    }else{
        $Enquiries = new Enquiry();
        $Enquiries->name = $request->name;
        $Enquiries->phone = $request->phone;
        $Enquiries->save();
        // $insert_data = ContactEnquiries::insert($data);
        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
    }
    }
    public function delete($id)
    {
        $all_data=[];
        $enquiries = Enquiry::find($id);
        $enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}