<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\ {
    ITSap
};
use Validator;
class ITSapController extends Controller
{

    public function AddITSapData(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'fullName' =>'required',
        'email' =>'required',
        'contact' =>'required|numeric|digits:10|unique:bootcamp',
        'whatsapp' => 'required|numeric|digits:10|unique:bootcamp',
        'college' => 'required',
        'qualification' => 'required',
        'year' => 'required',
        'city' => 'required'
        ]);

    if ($validator->fails()) {
        // return $validator->errors()->all();
        return response()->json(['status' => 'Success', 'message' => $validator->errors()->all(),'StatusCode'=>'400']);


    }else{
        $addBootcampData = new ITSap();
        $addBootcampData->fullName = $request->fullName;
        $addBootcampData->email = $request->email;
        $addBootcampData->contact = $request->contact;
        $addBootcampData->whatsapp = $request->whatsapp;
        $addBootcampData->college = $request->college;
        $addBootcampData->qualification = $request->qualification;
        $addBootcampData->year = $request->year;
        $addBootcampData->city = $request->city;
        $addBootcampData->save();
        // $insert_data = ContactEnquiries::insert($data);
        return response()->json(['status' => 'Success', 'message' => 'Information submitted successfully','StatusCode'=>'200']);
    }
    }


   
}