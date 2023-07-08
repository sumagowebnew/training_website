<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Consulting;
use Validator;
class ConsultingController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Consulting::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'fname'=>'required',
        'lname'=>'required',
        'email'=>'required',
        'contact'=>'required|numeric|digits:10',
        'company_name' => 'required',
        
        ]);

    if ($validator->fails()) {
        return $validator->errors()->all();

    }else{
        $Enquiries = new Consulting();
        $Enquiries->fname = $request->fname;
        $Enquiries->lname = $request->lname;
        $Enquiries->email = $request->email;
        $Enquiries->contact = $request->contact;
        $Enquiries->company_name = $request->company_name;
        $Enquiries->save();
        // $insert_data = ContactEnquiries::insert($data);
        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
    }
    }

    public function update(Request $request, $id)
    {
        
            $consult = Consulting::find($id);
            $consult->fname = $request->fname;
            $consult->lname = $request->lname;
            $consult->email = $request->email;
            $consult->contact = $request->contact;
            $consult->company_name = $request->company_name;

            $update_data = $consult->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $enquiries = Consulting::find($id);
        $enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}