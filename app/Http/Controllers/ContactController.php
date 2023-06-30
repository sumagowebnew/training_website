<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Award;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Award::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $contactEnquiries = new Award();
        // $data = [
        //     'name'      => $request->name,
        //     'mobile_no' => $request->mobile_no,
        //     'email'     => $request->email,
        //     'messege'   => $request->messege,
        // ];
        $contactEnquiries->name = $request->name;
        $contactEnquiries->subject = $request->subject;
        $contactEnquiries->email = $request->email;
        $contactEnquiries->phone = $request->phone;
        $contactEnquiries->message = $request->message;
        $contactEnquiries->save();
        // $insert_data = ContactEnquiries::insert($data);
        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
    }
    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = Award::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}