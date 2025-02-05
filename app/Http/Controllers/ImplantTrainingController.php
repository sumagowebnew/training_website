<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\ {
    Counselling,
    Bootcamp,
    BootcampApplyNow,
    ImplantTrainingNew,
    PopupEnquiryForm
};
use Validator;
class ImplantTrainingController extends Controller
{
    public function index(Request $request)
    {
        $all_data = PopupEnquiryForm::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    
    public function AddPopupEnquiryFormData(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fullName' => 'required|string',
        'email' => 'required|email|unique:popup_enquiry_form',
        'MobNo' => 'required|numeric|digits:10|unique:popup_enquiry_form',
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
        // Return a 400 status code with validation errors
        return response()->json([
            'status' => 'Error',
            'message' => $validator->errors()->all(),
            'StatusCode' => '400'
        ], 400);
    } else {
        $addBootcampData = new PopupEnquiryForm();
        $addBootcampData->fullName = $request->fullName;
        $addBootcampData->email = $request->email;
        $addBootcampData->MobNo = $request->MobNo;
        $addBootcampData->technology = $request->technology;
        $addBootcampData->branch = $request->branch;
        $addBootcampData->save();

        // Return a 200 status code with success message
        return response()->json([
            'status' => 'Success',
            'message' => 'Information submitted successfully',
            'StatusCode' => '200'
        ], 200);
    }
}

public function getPopupEnquiryFormData()
    {
        $student_info = PopupEnquiryForm::select('*')
            ->get();

        return response()->json($student_info);
    }

public function AddImplantTrainingData(Request $request)
{
    $validator = Validator::make($request->all(), [
        'stud_name' => 'required|string',
        'email' => 'required|email|unique:implant_training_new',
        'contact' => 'required|numeric|digits:10|unique:implant_training_new',
        // 'stud_name' => 'required|string',
        // 'contact' => 'required|numeric|digits:10',
        'wapp_no' => 'nullable|numeric|digits:10',
        'dob' => 'required|date',
        'college' => 'required|string',
        'branch' => 'required|string',
        'year' => 'required|string',
        'technology' => 'required|string',
        'location' => 'required|string',
        'mode' => 'required|string',
    ], [
        'stud_name.required' => 'The Student Name field is required.',
        'stud_name.string' => 'The Student Name must be a valid string.',

        'email.required' => 'The email field is required.',
        'email.email' => 'Please provide a valid email address.',
        'email.unique' => 'The email address is already in use.',

        'contact.required' => 'The Contact field is required.',
        'contact.numeric' => 'The Contact must contain only numbers.',
        'contact.digits' => 'The Contact must be exactly 10 digits.',
        'contact.unique' => 'The Contact is already in use.',

        // 'stud_name.required' => 'The student name field is required.',
        // 'stud_name.string' => 'The student name must be a valid string.',

        // 'contact.required' => 'The contact number field is required.',
        // 'contact.numeric' => 'The contact number must contain only numbers.',
        // 'contact.digits' => 'The contact number must be exactly 10 digits.',

        'wapp_no.numeric' => 'The WhatsApp number must contain only numbers.',
        'wapp_no.digits' => 'The WhatsApp number must be exactly 10 digits.',

        'dob.required' => 'The date of birth field is required.',
        'dob.date' => 'Please provide a valid date of birth.',

        'college.required' => 'The college field is required.',
        'branch.required' => 'The branch field is required.',
        'year.required' => 'The year field is required.',
        'technology.required' => 'The technology field is required.',
        'location.required' => 'The location field is required.',
        'mode.required' => 'The mode field is required.',
    ]);

    if ($validator->fails()) {
        // Return a 400 status code with validation errors
        return response()->json([
            'status' => 'Error',
            'message' => $validator->errors()->all(),
            'StatusCode' => '400'
        ], 400);
    } else {
        $addBootcampData = new ImplantTrainingNew();
        $addBootcampData->stud_name = $request->stud_name;
        $addBootcampData->email = $request->email;
        $addBootcampData->contact = $request->contact;
        // $addBootcampData->stud_name = $request->stud_name;
        // $addBootcampData->contact = $request->contact;
        $addBootcampData->wapp_no = $request->wapp_no;
        $addBootcampData->dob = $request->dob;
        $addBootcampData->college = $request->college;
        $addBootcampData->branch = $request->branch;
        $addBootcampData->year = $request->year;
        $addBootcampData->technology = $request->technology;
        $addBootcampData->location = $request->location;
        $addBootcampData->mode = $request->mode;
        $addBootcampData->save();

        // Return a 200 status code with success message
        return response()->json([
            'status' => 'Success',
            'message' => 'Information submitted successfully',
            'StatusCode' => '200'
        ], 200);
    }
}


// public function AddImplantTrainingData(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'fullName' => 'required|string',
//         'email' => 'required|email|unique:implant_training_new',
//         'MobNo' => 'required|numeric|digits:10|unique:implant_training_new',
//         'technology' => 'required',
//         'branch' => 'required',
//     ], [
//         'fullName.required' => 'The full name field is required.',
//         'fullName.string' => 'The full name must be a valid string.',

//         'email.required' => 'The email field is required.',
//         'email.email' => 'Please provide a valid email address.',
//         'email.unique' => 'The email address is already in use.',

//         'MobNo.required' => 'The mobile number field is required.',
//         'MobNo.numeric' => 'The mobile number must contain only numbers.',
//         'MobNo.digits' => 'The mobile number must be exactly 10 digits.',
//         'MobNo.unique' => 'The mobile number is already in use.',

//         'technology.required' => 'The technology field is required.',

//         'branch.required' => 'The branch field is required.',
//     ]);

//     if ($validator->fails()) {
//         // Return a 400 status code with validation errors
//         return response()->json([
//             'status' => 'Error',
//             'message' => $validator->errors()->all(),
//             'StatusCode' => '400'
//         ], 400);
//     } else {
//         $addBootcampData = new ImplantTrainingNew();
//         $addBootcampData->fullName = $request->fullName;
//         $addBootcampData->email = $request->email;
//         $addBootcampData->MobNo = $request->MobNo;
//         $addBootcampData->technology = $request->technology;
//         $addBootcampData->branch = $request->branch;
//         $addBootcampData->save();

//         // Return a 200 status code with success message
//         return response()->json([
//             'status' => 'Success',
//             'message' => 'Information submitted successfully',
//             'StatusCode' => '200'
//         ], 200);
//     }
// }


    public function delete($id)
    {
        $all_data=[];
        $enquiries = ImplantTrainingNew::find($id);
        $enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}