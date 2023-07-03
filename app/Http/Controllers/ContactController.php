<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Contact;
use Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Contact::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'subject'=>'required',
            'email'=>'required'|'email',
            'phone' => 'required|numeric|digits:10',
            'message' => 'required',
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                        $contactEnquiries = new Contact();
                        $contactEnquiries->name = $request->name;
                        $contactEnquiries->subject = $request->subject;
                        $contactEnquiries->email = $request->email;
                        $contactEnquiries->phone = $request->phone;
                        $contactEnquiries->message = $request->message;
                        $contactEnquiries->save();
                        // $insert_data = ContactEnquiries::insert($data);
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }
    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = Contact::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}