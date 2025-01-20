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
        'fullName' =>'required|string',
        'email' =>'required|email|unique:implant_training_new',
        'MobNo' =>'required|numeric|digits:10|unique:implant_training_new',
        'technology' => 'required',
        'branch' => 'required',
        ], [
            'fullName.required' => 'The full name field is required.',
            'fullName.string' => 'The full name must be a valid string.',
            
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'The email address is already in use.',
            
            'MobNo.required' => 'The mobile number field is required.',
            'MobNo.numeric' => 'The mobile number must contain only numbers.',
            'MobNo.digits' => 'The mobile number must be exactly 10 digits.',
            'MobNo.unique' => 'The mobile number is already in use.',
            
            'technology.required' => 'The technology field is required.',
            
            'branch.required' => 'The branch field is required.',
        ]);

    if ($validator->fails()) {
        return $validator->errors()->all();
        // return response()->json(['status' => 'Success', 'message' => $validator->errors()->all(),'StatusCode'=>'400']);


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