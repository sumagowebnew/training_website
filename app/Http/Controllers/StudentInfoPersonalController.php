<?php

namespace App\Http\Controllers;

use App\Models\
{
StudentInfo,
StudentPersonalInfo,
StudentEdducationDetails,
StudentParentDetails,
StudentInternshipDetails,
StudentInternshipCompletionDetails
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Validator;
class StudentInfoPersonalController extends Controller
{
    public function index()
    {
        // Get all data from the database
        // $portfolio = Portfolio::get();

        $student_info = StudentPersonalInfo::where('student_personal_info.is_deleted','0')
                            ->select('student_personal_info.id','fname','mname','fathername','lname','gender','parmanenat_address','current_address','contact_details','email','dob',
            'whatsappno', 'age', 'blood', 'aadhar')
            ->get();

        // $response = [];

        // foreach ($portfolio as $item) {
        //     $data = $item->toArray();
          
        //     $logo = $data['image'];

        //     $imagePath = "uploads/portfolio/" . $logo;

        //     $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

        //     $data['image'] = $base64;
        //     // $data['title']= $data['title'];
        //     // $data['description']=$data['description'];
        //     // $data['website_link']=$data['website_link'];
        //     // $data['website_status']=$data['website_status'];
        //     // $data['created_at']=$data['created_at'];
        //     // $data['updated_at']=$data['updated_at'];
          
        //     $response[] = $data;
        // }

        return response()->json($student_info);
    }


    public function getAllRecord(Request $request)
    {
        $all_data = Count::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }


    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // StudentInfo fields
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'fathername' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required',
            'parmanenat_address' => 'required|string|max:500',
            'current_address' => 'nullable|string|max:500',
            'contact_details' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'whatsappno' => 'nullable|string|max:15',
            'age' => 'required',
            'blood' => 'nullable|string|max:10',
            'aadhar' => 'required|string|max:12|min:12',
        
        ], [
            // Custom validation messages
            'fname.required' => 'First Name is required.',
            'fname.string' => 'First Name must be a string.',
            'fname.max' => 'First Name should not exceed 255 characters.',
            
            'mname.string' => 'Middle Name must be a string.',
            'mname.max' => 'Middle Name should not exceed 255 characters.',
            
            'fathername.required' => 'Father Name is required.',
            'fathername.string' => 'Father Name must be a string.',
            'fathername.max' => 'Father Name should not exceed 255 characters.',
            
            'lname.required' => 'Last Name is required.',
            'lname.string' => 'Last Name must be a string.',
            'lname.max' => 'Last Name should not exceed 255 characters.',

            'gender.required' => 'Gender is required.',
            'training_mode.required' => 'Training Mode is required.',

            
            'parmanenat_address.required' => 'Permanent Address is required.',
            'parmanenat_address.string' => 'Permanent Address must be a string.',
            'parmanenat_address.max' => 'Permanent Address should not exceed 500 characters.',
            
            'current_address.string' => 'Current Address must be a string.',
            'current_address.max' => 'Current Address should not exceed 500 characters.',
            
            'contact_details.required' => 'Contact Details are required.',
            'contact_details.string' => 'Contact Details must be a string.',
            'contact_details.max' => 'Contact Details should not exceed 15 characters.',
            
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email should not exceed 255 characters.',
            
            'dob.required' => 'Date of Birth is required.',
            'dob.date' => 'Date of Birth must be a valid date.',
            
            'whatsappno.string' => 'WhatsApp Number must be a string.',
            'whatsappno.max' => 'WhatsApp Number should not exceed 15 characters.',
            
            'age.required' => 'Age is required.',
            
            'blood.string' => 'Blood Group must be a string.',
            'blood.max' => 'Blood Group should not exceed 10 characters.',
            
            'aadhar.required' => 'Aadhar Number is required.',
            'aadhar.string' => 'Aadhar Number must be a string.',
            'aadhar.max' => 'Aadhar Number should not exceed 12 characters.',
            'aadhar.min' => 'Aadhar Number should be exactly 12 characters.',
        ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                
                    try{
                        $studentInfo = new StudentPersonalInfo();
                        $studentInfo->fname = $request->fname;
                        $studentInfo->mname = $request->mname;
                        $studentInfo->fathername = $request->fathername;
                        $studentInfo->lname = $request->lname;
                        $studentInfo->gender = $request->gender;
                        $studentInfo->parmanenat_address = $request->parmanenat_address;
                        $studentInfo->current_address = $request->current_address;
                        $studentInfo->contact_details = $request->contact_details;
                        $studentInfo->email = $request->email;
                        $studentInfo->dob = $request->dob;
                        $studentInfo->whatsappno = $request->whatsappno;
                        $studentInfo->age = $request->age;
                        $studentInfo->blood = $request->blood;
                        $studentInfo->aadhar = $request->aadhar;
                        
                        $existingRecord = StudentInfo::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                        $studentInfo->save();

                        //return response()->json($client_logo);
                        return response()->json(['status' => 'Success', 'message' => 'Portfolio added successfully','Statuscode'=>'200']);

                        
                    }

                    catch (exception $e) {
                        return response()->json(['status' => 'error', 'message' => 'Intern Details not added', 'error' => $e->getMessage()],500);
                    }
            }
    }    

    public function getPerticularPersonalInfo($id)
    {

        $student_info = StudentPersonalInfo::where('student_personal_info.id',$id)
        ->leftJoin('student_info', 'student_personal_info.id', '=', 'student_info.stude_id')
        ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
        ->select('student_personal_info.id','student_info.stude_id','student_personal_info.fname','student_personal_info.mname','student_personal_info.fathername',
        'student_personal_info.lname','student_personal_info.gender','student_personal_info.parmanenat_address','student_personal_info.current_address',
        'student_personal_info.contact_details','student_personal_info.email','student_personal_info.dob',
        'student_personal_info.whatsappno', 'student_personal_info.age', 'student_personal_info.blood', 'student_personal_info.aadhar',
        'student_info.date_of_joining','student_internship_details.technology_name')
        ->groupBy('student_personal_info.id')
        ->get();


        return response()->json($student_info);
    }

    public function update(Request $request, $id)
    {
        // dd($id);
        $validator = Validator::make($request->all(), [
            // StudentInfo fields
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'fathername' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required',
            'parmanenat_address' => 'required|string|max:500',
            'current_address' => 'nullable|string|max:500',
            'contact_details' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'whatsappno' => 'nullable|max:15',
            'age' => 'required',
            'blood' => 'nullable|string|max:10',
            'aadhar' => 'required|max:12|min:12'
        ], [
            // Custom validation messages
            'fname.required' => 'First Name is required.',
            'fname.string' => 'First Name must be a string.',
            'fname.max' => 'First Name should not exceed 255 characters.',
            
            'mname.string' => 'Middle Name must be a string.',
            'mname.max' => 'Middle Name should not exceed 255 characters.',
            
            'fathername.required' => 'Father Name is required.',
            'fathername.string' => 'Father Name must be a string.',
            'fathername.max' => 'Father Name should not exceed 255 characters.',
            
            'lname.required' => 'Last Name is required.',
            'lname.string' => 'Last Name must be a string.',
            'lname.max' => 'Last Name should not exceed 255 characters.',

            'gender.required' => 'Gender is required.',

            'parmanenat_address.required' => 'Permanent Address is required.',
            'parmanenat_address.string' => 'Permanent Address must be a string.',
            'parmanenat_address.max' => 'Permanent Address should not exceed 500 characters.',
            
            'current_address.string' => 'Current Address must be a string.',
            'current_address.max' => 'Current Address should not exceed 500 characters.',
            
            'contact_details.required' => 'Contact Details are required.',
            'contact_details.string' => 'Contact Details must be a string.',
            'contact_details.max' => 'Contact Details should not exceed 15 characters.',
            
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email should not exceed 255 characters.',
            
            'dob.required' => 'Date of Birth is required.',
            'dob.date' => 'Date of Birth must be a valid date.',
            
            // 'whatsappno.string' => 'WhatsApp Number must be a string.',
            'whatsappno.max' => 'WhatsApp Number should not exceed 15 characters.',
            
            'age.required' => 'Age is required.',
            
            'blood.string' => 'Blood Group must be a string.',
            'blood.max' => 'Blood Group should not exceed 10 characters.',
            
            'aadhar.required' => 'Aadhar Number is required.',
            'aadhar.max' => 'Aadhar Number should not exceed 12 characters.',
            'aadhar.min' => 'Aadhar Number should be exactly 12 characters.'
        ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                        $studentInfo = StudentPersonalInfo::find($id);
                        // dd($studentInfo);
                        $studentInfo->fname = $request->fname;
                        $studentInfo->mname = $request->mname;
                        $studentInfo->fathername = $request->fathername;
                        $studentInfo->lname = $request->lname;
                        $studentInfo->gender = $request->gender;
                        // $studentInfo->training_mode = $request->training_mode;
                        $studentInfo->parmanenat_address = $request->parmanenat_address;
                        $studentInfo->current_address = $request->current_address;
                        $studentInfo->contact_details = $request->contact_details;
                        $studentInfo->email = $request->email;
                        $studentInfo->dob = $request->dob;
                        $studentInfo->whatsappno = $request->whatsappno;
                        $studentInfo->age = $request->age;
                        $studentInfo->blood = $request->blood;
                        $studentInfo->aadhar = $request->aadhar;
                        $existingRecord = StudentInfo::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                        
                        // $studentInfo->save();
                        $update_data = $studentInfo->update();

                        
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Intern Data Updated Successfully!',
                            'data' => $update_data,
                        ], 200);
                // return $this->responseApi($update_data,'Data Updated','success',200);
            }
    }

    public function destroy($id)
    {
        $all_data=[];
        // $portfolio = Portfolio::find($id);

        $student_personal_data = StudentPersonalInfo::find($id);
            if ($student_personal_data) {
                // Delete the images from the storage folder

                // Delete the record from the database
                $is_deleted = $student_personal_data->is_deleted == 1 ? 0 : 1;
                $student_personal_data->is_deleted = $is_deleted;
                $student_personal_data->save();
                // Log::info($student_data);    

                $student_data = StudentInfo::where('stude_id', $id)
                            ->first();
                if ($student_data) {            
                    $is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
                    $student_data->is_deleted = $is_deleted;
                    $student_data->save();
                }

                $studet_education_data = StudentEdducationDetails::where('stude_id', $id)
                            ->first();
                if ($studet_education_data) { 
                    $is_deleted = $studet_education_data->is_deleted == 1 ? 0 : 1;
                    $studet_education_data->is_deleted = $is_deleted;
                    $studet_education_data->save();
                    // Log::info($student_data);
                }    

                $studet_parent_data = StudentParentDetails::where('stude_id', $id)
                            ->first();
                if ($studet_parent_data) {             
                    $is_deleted = $studet_parent_data->is_deleted == 1 ? 0 : 1;
                    $studet_parent_data->is_deleted = $is_deleted;
                    $studet_parent_data->save();
                }


                $studet_internship_data = StudentInternshipDetails::where('stude_id', $id)
                            ->first();
                if ($studet_internship_data) {             
                    $is_deleted = $studet_internship_data->is_deleted == 1 ? 0 : 1;
                    $studet_internship_data->is_deleted = $is_deleted;
                    $studet_internship_data->save();
                    // Log::info($student_data);
                }

                $studet_completion_data = StudentInternshipCompletionDetails::where('stude_id', $id)
                            ->first();
                if ($studet_completion_data) { 
                    $is_deleted = $studet_completion_data->is_deleted == 1 ? 0 : 1;
                    $studet_completion_data->is_deleted = $is_deleted;
                    $studet_completion_data->save();
                    // Log::info($student_data);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Intern Data Deleted Successfully!',
                    'data' => $all_data,
                ], 200);
        

            }
            // else[
            //     return response()->json(['status' => 'error', 'message' => 'Intern Details not added', 'error' => $e->getMessage()],500);

            // ]    
        
        // $portfolio->delete();
        // return response()->json("Deleted Successfully!");
        // return $this->responseApi($all_data,'Portfolio Deleted Successfully!','success',200);
        return response()->json([
            'status' => 'error',
            'message' => 'Intern details not found.',
        ], 404);

    }

    
}
