<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\ {
    Counselling,
    Bootcamp,
    BootcampApplyNow,
    ImplantTrainingNew
};
use Validator;
class ImplantTrainingController extends Controller
{
    public function index(Request $request)
    {
        $all_data = ImplantTrainingNew::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    
    public function AddImplantTrainingData(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'fullName' =>'required',
        'email' =>'required',
        'MobNo' =>'required|numeric|digits:10',
        'technology' => 'required',
        'branch' => 'required',
        ]);

    if ($validator->fails()) {
        // return $validator->errors()->all();
        return response()->json(['status' => 'Success', 'message' => $validator->errors()->all(),'StatusCode'=>'400']);


    }else{
        $addBootcampData = new ImplantTrainingNew();
        $addBootcampData->fullName = $request->fullName;
        $addBootcampData->email = $request->email;
        $addBootcampData->MobNo = $request->MobNo;
        $addBootcampData->technology = $request->technology;
        $addBootcampData->branch = $request->branch;
        $addBootcampData->save();
        // $insert_data = ContactEnquiries::insert($data);
        return response()->json(['status' => 'Success', 'message' => 'Information submitted successfully','StatusCode'=>'200']);
    }
    }

    public function delete($id)
    {
        $all_data=[];
        $enquiries = ImplantTrainingNew::find($id);
        $enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}