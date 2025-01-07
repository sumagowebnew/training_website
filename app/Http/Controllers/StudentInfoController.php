<?php

namespace App\Http\Controllers;

use App\Models\
{
StudentInfo,
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
class StudentInfoController extends Controller
{
    public function index()
    {
        // Get all data from the database
        // $portfolio = Portfolio::get();

        $student_info = StudentInfo::leftJoin('student_parents_details', 'student_info.id', '=', 'student_parents_details.stude_id')
                            ->leftJoin('student_education_details', 'student_info.id', '=', 'student_education_details.stude_id')
                            ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
                            ->where('student_info.is_deleted','0')
                            ->select('student_info.id','fname','mname','fathername','lname','gender','training_mode','parmanenat_address','current_address','contact_details','email','dob',
            'whatsappno', 'age', 'blood', 'aadhar','linkdin','facebook','youtube','anyother_add','school_name',
            'tenth_per','twelve_diploma_per','graduation_details', 'graduation_per', 'post_graduation_details','post_graduation_per',
            'anyother_cirt','selected_branches','other_branch','father_name','fatherOccupation','father_contactdetails','father_aadharno',
            'mother_name','motherOccupation','mother_contactdetails','mother_aadharno','marriedStatus','husband_name','HusbandOccupation',
            'Husband_contactdetails','Husband_aadharno','guardian_name','GuardianOccupation','Guardian_aadharno','Guardian_contactdetails',
            'technology_name','duration','selectedModules','intern_experience',
            'experience','characteristics_describe','applicant_name','place','refrance_social_media','refrance_friend',
            'refrance_family','refrance_relatives','refrance_other',
            'reference_name','reference_name1','contact_number','contact_number1','buttom_applicant_name',
            'buttom_place')
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
            'training_mode' => 'required',
            'parmanenat_address' => 'required|string|max:500',
            'current_address' => 'nullable|string|max:500',
            'contact_details' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'whatsappno' => 'nullable|string|max:15',
            'age' => 'required',
            'blood' => 'nullable|string|max:10',
            'aadhar' => 'required|string|max:12|min:12',
        
            // StudentEducationDetails fields
            'school_name' => 'required|string|max:255',
            'tenth_per' => 'required|numeric|min:0|max:100',
            'twelve_diploma_per' => 'nullable|numeric|min:0|max:100',
            'graduation_details' => 'nullable|string|max:255',
            'graduation_per' => 'nullable|numeric|min:0|max:100',
            'post_graduation_details' => 'nullable|string|max:255',
            'post_graduation_per' => 'nullable|numeric|min:0|max:100',
            'anyother_cirt' => 'nullable|string|max:255',
            'selected_branches' => 'required',
            'other_branch' => 'nullable|string|max:255',
        
            // StudentParentDetails fields
            'father_name' => 'required|string|max:255',
            'fatherOccupation' => 'nullable|string|max:255',
            'father_contactdetails' => 'required|string|max:15',
            'father_aadharno' => 'nullable|string|max:12|min:12',
            'mother_name' => 'nullable|string|max:255',
            'motherOccupation' => 'nullable|string|max:255',
            'mother_contactdetails' => 'nullable|string|max:15',
            'mother_aadharno' => 'nullable|string|max:12|min:12',
            'marriedStatus' => 'required',
            'husbandDetails.name' => 'nullable|required_if:marriedStatus,Yes|string|max:255',
            'husbandDetails.contact' => 'nullable|required_if:marriedStatus,Yes|string|max:15',
            'husbandDetails.aadhar' => 'nullable|required_if:marriedStatus,Yes|string|max:12|min:12',
            'husbandDetails.occupation' => 'nullable|required_if:marriedStatus,Yes|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'Guardian_aadharno' => 'nullable|string|max:12|min:12',
            'Guardian_contactdetails' => 'nullable|string|max:15',
            'GuardianOccupation' => 'nullable|string|max:255',
        
            // StudentInternshipDetails fields
            'technology_name' => 'required|string|max:255',
            'duration' => 'nullable|string|max:50',
            'selectedModules' => 'required',
            'intern_experience' => 'nullable|string|max:1000',
            'experience' => 'nullable|string|max:1000',
            'characteristics_describe' => 'nullable|string|max:1000',
            'applicant_name' => 'required|string|max:255',
            'place' => 'nullable|string|max:255',
            // 'refrance' => 'required',
            'reference_name' => 'nullable|string|max:255',
            'reference_name1' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'contact_number1' => 'nullable|string|max:15',
            'buttom_applicant_name' => 'nullable|string|max:255',
            'buttom_place' => 'nullable|string|max:255',
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

            'school_name.required' => 'School Name is required.',
            'school_name.string' => 'School Name must be a string.',
            'school_name.max' => 'School Name should not exceed 255 characters.',
            
            'tenth_per.required' => '10th Percentage is required.',
            'tenth_per.numeric' => '10th Percentage must be a number.',
            'tenth_per.min' => '10th Percentage must be at least 0.',
            'tenth_per.max' => '10th Percentage must not exceed 100.',
            
            'twelve_diploma_per.numeric' => '12th/Diploma Percentage must be a number.',
            'twelve_diploma_per.min' => '12th/Diploma Percentage must be at least 0.',
            'twelve_diploma_per.max' => '12th/Diploma Percentage must not exceed 100.',
            
            'graduation_details.string' => 'Graduation Details must be a string.',
            'graduation_details.max' => 'Graduation Details should not exceed 255 characters.',
            
            'graduation_per.numeric' => 'Graduation Percentage must be a number.',
            'graduation_per.min' => 'Graduation Percentage must be at least 0.',
            'graduation_per.max' => 'Graduation Percentage must not exceed 100.',
            
            'post_graduation_details.string' => 'Post Graduation Details must be a string.',
            'post_graduation_details.max' => 'Post Graduation Details should not exceed 255 characters.',
            
            'post_graduation_per.numeric' => 'Post Graduation Percentage must be a number.',
            'post_graduation_per.min' => 'Post Graduation Percentage must be at least 0.',
            'post_graduation_per.max' => 'Post Graduation Percentage must not exceed 100.',
            
            'anyother_cirt.string' => 'Other Certification Details must be a string.',
            'anyother_cirt.max' => 'Other Certification Details should not exceed 255 characters.',
            
            'selected_branches.required' => 'Selected Branches are required.',
            
            'other_branch.string' => 'Other Branch must be a string.',
            'other_branch.max' => 'Other Branch should not exceed 255 characters.',

            'father_name.required' => 'Father Name is required.',
            'father_name.string' => 'Father Name must be a string.',
            'father_name.max' => 'Father Name should not exceed 255 characters.',
            
            'fatherOccupation.string' => 'Father Occupation must be a string.',
            'fatherOccupation.max' => 'Father Occupation should not exceed 255 characters.',
            
            'father_contactdetails.required' => 'Father Contact Details are required.',
            'father_contactdetails.string' => 'Father Contact Details must be a string.',
            'father_contactdetails.max' => 'Father Contact Details should not exceed 15 characters.',
            
            'father_aadharno.string' => 'Father Aadhaar Number must be a string.',
            'father_aadharno.max' => 'Father Aadhaar Number should not exceed 12 characters.',
            'father_aadharno.min' => 'Father Aadhaar Number must be exactly 12 characters.',
            
            'mother_name.string' => 'Mother Parent Guardian Details must be a string.',
            'mother_name.max' => 'Mother Parent Guardian Details should not exceed 255 characters.',
            
            'motherOccupation.string' => 'Mother Occupation must be a string.',
            'motherOccupation.max' => 'Mother Occupation should not exceed 255 characters.',
            
            'mother_contactdetails.string' => 'Mother Contact Details must be a string.',
            'mother_contactdetails.max' => 'Mother Contact Details should not exceed 15 characters.',
            
            'mother_aadharno.string' => 'Mother Aadhaar Number must be a string.',
            'mother_aadharno.max' => 'Mother Aadhaar Number should not exceed 12 characters.',
            'mother_aadharno.min' => 'Mother Aadhaar Number must be exactly 12 characters.',
            
            'marriedStatus.required' => 'Marital Status is required.',

            'husbandDetails.name.required_if' => 'Husband Name is required if Married Status is Yes.',
            'husbandDetails.name.string' => 'Husband Name must be a string.',
            'husbandDetails.name.max' => 'Husband Name should not exceed 255 characters.',

            'husbandDetails.contact.required_if' => 'Husband Contact Details are required if Married Status is Yes.',
            'husbandDetails.contact.string' => 'Husband Contact Details must be a string.',
            'husbandDetails.contact.max' => 'Husband Contact Details should not exceed 15 characters.',

            'husbandDetails.aadhar.required_if' => 'Husband Aadhar Number is required if Married Status is Yes.',
            'husbandDetails.aadhar.string' => 'Husband Aadhar Number must be a string.',
            'husbandDetails.aadhar.max' => 'Husband Aadhar Number should not exceed 12 characters.',
            'husbandDetails.aadhar.min' => 'Husband Aadhar Number must be at least 12 characters.',

            'husbandDetails.occupation.required_if' => 'Husband Occupation is required if Married Status is Yes.',
            'husbandDetails.occupation.string' => 'Husband Occupation must be a string.',
            'husbandDetails.occupation.max' => 'Husband Occupation should not exceed 255 characters.',
            
            'guardian_name.string' => 'Guardian Name must be a string.',
            'guardian_name.max' => 'Guardian Name should not exceed 255 characters.',
            
            'Guardian_aadharno.string' => 'Guardian Aadhaar Number must be a string.',
            'Guardian_aadharno.max' => 'Guardian Aadhaar Number should not exceed 12 characters.',
            'Guardian_aadharno.min' => 'Guardian Aadhaar Number must be exactly 12 characters.',
            
            'Guardian_contactdetails.string' => 'Guardian Contact Details must be a string.',
            'Guardian_contactdetails.max' => 'Guardian Contact Details should not exceed 15 characters.',
            
            'GuardianOccupation.string' => 'Guardian Occupation must be a string.',
            'GuardianOccupation.max' => 'Guardian Occupation should not exceed 255 characters.',

            'technology_name.required' => 'Technology Name is required.',
            'technology_name.string' => 'Technology Name must be a string.',
            'technology_name.max' => 'Technology Name should not exceed 255 characters.',
            
            'duration.string' => 'Duration must be a string.',
            'duration.max' => 'Duration should not exceed 50 characters.',
            
            'selectedModules.required' => 'Selected Modules are required.',
            
            'intern_experience.string' => 'Internship Experience must be a string.',
            'intern_experience.max' => 'Internship Experience should not exceed 1000 characters.',
            
            'experience.string' => 'Experience must be a string.',
            'experience.max' => 'Experience should not exceed 1000 characters.',
            
            'characteristics_describe.string' => 'Characteristics Description must be a string.',
            'characteristics_describe.max' => 'Characteristics Description should not exceed 1000 characters.',
            
            'applicant_name.required' => 'Applicant Name is required.',
            'applicant_name.string' => 'Applicant Name must be a string.',
            'applicant_name.max' => 'Applicant Name should not exceed 255 characters.',
            
            'place.string' => 'Place must be a string.',
            'place.max' => 'Place should not exceed 255 characters.',

            // 'refrance.required' => 'Refrence is required.',
            
            'reference_name.string' => 'Reference Name must be a string.',
            'reference_name.max' => 'Reference Name should not exceed 255 characters.',

            'reference_name1.string' => 'Reference Name must be a string.',
            'reference_name1.max' => 'Reference Name should not exceed 255 characters.',
            
            'contact_number.string' => 'Contact Number must be a string.',
            'contact_number.max' => 'Contact Number should not exceed 15 characters.',

            'contact_number1.string' => 'Contact Number must be a string.',
            'contact_number1.max' => 'Contact Number should not exceed 15 characters.',
            
            'buttom_applicant_name.string' => 'Bottom Applicant Name must be a string.',
            'buttom_applicant_name.max' => 'Bottom Applicant Name should not exceed 255 characters.',
            
            'buttom_place.string' => 'Bottom Place must be a string.',
            'buttom_place.max' => 'Bottom Place should not exceed 255 characters.',
        ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                
                    try{
                        $studentInfo = new StudentInfo();
                        $studentInfo->fname = $request->fname;
                        $studentInfo->mname = $request->mname;
                        $studentInfo->fathername = $request->fathername;
                        $studentInfo->lname = $request->lname;
                        $studentInfo->gender = $request->gender;
                        $studentInfo->training_mode = $request->training_mode;
                        $studentInfo->parmanenat_address = $request->parmanenat_address;
                        $studentInfo->current_address = $request->current_address;
                        $studentInfo->contact_details = $request->contact_details;
                        $studentInfo->email = $request->email;
                        $studentInfo->dob = $request->dob;
                        $studentInfo->whatsappno = $request->whatsappno;
                        $studentInfo->age = $request->age;
                        $studentInfo->blood = $request->blood;
                        $studentInfo->aadhar = $request->aadhar;
                        $studentInfo->linkdin = $request->linkdin;
                        $studentInfo->facebook = $request->facebook;
                        $studentInfo->youtube = $request->youtube;
                        $studentInfo->anyother_add = $request->anyother_add;

                        $existingRecord = StudentInfo::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                        $studentInfo->save();

                        $studentEducationDetails = new StudentEdducationDetails();
                        $studentEducationDetails->stude_id = $recordId;
                        $studentEducationDetails->school_name = $request->school_name;
                        $studentEducationDetails->tenth_per = $request->tenth_per;
                        $studentEducationDetails->twelve_diploma_per = $request->twelve_diploma_per;
                        $studentEducationDetails->graduation_details = $request->graduation_details;
                        $studentEducationDetails->graduation_per = $request->graduation_per;
                        $studentEducationDetails->post_graduation_details = $request->post_graduation_details;
                        $studentEducationDetails->post_graduation_per = $request->post_graduation_per;
                        $studentEducationDetails->anyother_cirt = $request->anyother_cirt;
                        $studentEducationDetails->selected_branches = $request->selected_branches;
                        $studentEducationDetails->other_branch = $request->other_branch;
                        $studentEducationDetails->save();

                        $studentPerentsDetails = new StudentParentDetails();
                        $studentPerentsDetails->stude_id = $recordId;
                        $studentPerentsDetails->father_name = $request->father_name;
                        $studentPerentsDetails->fatherOccupation = $request->fatherOccupation;
                        $studentPerentsDetails->father_contactdetails = $request->father_contactdetails;
                        $studentPerentsDetails->father_aadharno = $request->father_aadharno;
                        $studentPerentsDetails->mother_name = $request->mother_name;
                        $studentPerentsDetails->motherOccupation = $request->motherOccupation;
                        $studentPerentsDetails->mother_contactdetails = $request->mother_contactdetails;
                        $studentPerentsDetails->mother_aadharno = $request->mother_aadharno;
                        $studentPerentsDetails->marriedStatus = $request->marriedStatus;
                        $studentPerentsDetails->husband_name =  $request->husbandDetails['name'];
                        $studentPerentsDetails->Husband_contactdetails = $request->husbandDetails['contact'];
                        $studentPerentsDetails->Husband_aadharno = $request->husbandDetails['aadhar'];
                        $studentPerentsDetails->HusbandOccupation = $request->husbandDetails['occupation'];
                        $studentPerentsDetails->guardian_name = $request->guardian_name;
                        $studentPerentsDetails->Guardian_aadharno = $request->Guardian_aadharno;
                        $studentPerentsDetails->GuardianOccupation = $request->GuardianOccupation;
                        $studentPerentsDetails->Guardian_contactdetails = $request->Guardian_contactdetails;
                        $studentPerentsDetails->save();

                        $studentPerentsDetails = new StudentInternshipDetails();
                        $studentPerentsDetails->stude_id = $recordId;
                        $studentPerentsDetails->technology_name = $request->technology_name;
                        $studentPerentsDetails->duration = $request->duration;
                        $studentPerentsDetails->selectedModules = $request->selectedModules;
                        $studentPerentsDetails->intern_experience = $request->intern_experience;
                        $studentPerentsDetails->experience = $request->experience;
                        $studentPerentsDetails->characteristics_describe = $request->characteristics_describe;
                        $studentPerentsDetails->applicant_name = $request->applicant_name;
                        $studentPerentsDetails->place = $request->place;
                        // $studentPerentsDetails->refrance = $request->refrance;
                        // $studentPerentsDetails->refrance = implode(',', $request->refrance);
                        
                        $studentPerentsDetails->refrance_social_media = $request->refrance_social_media;
                        $studentPerentsDetails->refrance_friend = $request->refrance_friend;
                        $studentPerentsDetails->refrance_family = $request->refrance_family;
                        $studentPerentsDetails->refrance_relatives = $request->refrance_relatives;
                        $studentPerentsDetails->refrance_other = $request->refrance_other;

                        $studentPerentsDetails->reference_name = $request->reference_name;
                        $studentPerentsDetails->reference_name1 = $request->reference_name1;
                        $studentPerentsDetails->contact_number = $request->contact_number;
                        $studentPerentsDetails->contact_number1 = $request->contact_number1;
                        $studentPerentsDetails->buttom_applicant_name = $request->buttom_applicant_name;
                        $studentPerentsDetails->buttom_place = $request->buttom_place;
                        $studentPerentsDetails->save();

                        //return response()->json($client_logo);
                        return response()->json(['status' => 'Success', 'message' => 'Portfolio added successfully','Statuscode'=>'200']);

                        
                    }

                    catch (exception $e) {
                        return response()->json(['status' => 'error', 'message' => 'Intern Details not added', 'error' => $e->getMessage()],500);
                    }
            }
    }    

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // StudentInfo fields
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'fathername' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required',
            'training_mode' => 'required',
            'parmanenat_address' => 'required|string|max:500',
            'current_address' => 'nullable|string|max:500',
            'contact_details' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'whatsappno' => 'nullable|string|max:15',
            'age' => 'required',
            'blood' => 'nullable|string|max:10',
            'aadhar' => 'required|string|max:12|min:12',
        
            // StudentEducationDetails fields
            'school_name' => 'required|string|max:255',
            'tenth_per' => 'required|numeric|min:0|max:100',
            'twelve_diploma_per' => 'nullable|numeric|min:0|max:100',
            'graduation_details' => 'nullable|string|max:255',
            'graduation_per' => 'nullable|numeric|min:0|max:100',
            'post_graduation_details' => 'nullable|string|max:255',
            'post_graduation_per' => 'nullable|numeric|min:0|max:100',
            'anyother_cirt' => 'nullable|string|max:255',
            'selected_branches' => 'required',
            'other_branch' => 'nullable|string|max:255',
        
            // StudentParentDetails fields
            'father_name' => 'required|string|max:255',
            'fatherOccupation' => 'nullable|string|max:255',
            'father_contactdetails' => 'required|string|max:15',
            'father_aadharno' => 'nullable|string|max:12|min:12',
            'mother_name' => 'nullable|string|max:255',
            'motherOccupation' => 'nullable|string|max:255',
            'mother_contactdetails' => 'nullable|string|max:15',
            'mother_aadharno' => 'nullable|string|max:12|min:12',
            'marriedStatus' => 'required',
            'husbandDetails.name' => 'nullable|required_if:marriedStatus,Yes|string|max:255',
            'husbandDetails.contact' => 'nullable|required_if:marriedStatus,Yes|string|max:15',
            'husbandDetails.aadhar' => 'nullable|required_if:marriedStatus,Yes|string|max:12|min:12',
            'husbandDetails.occupation' => 'nullable|required_if:marriedStatus,Yes|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'Guardian_aadharno' => 'nullable|string|max:12|min:12',
            'Guardian_contactdetails' => 'nullable|string|max:15',
            'GuardianOccupation' => 'nullable|string|max:255',
        
            // StudentInternshipDetails fields
            'technology_name' => 'required|string|max:255',
            'duration' => 'nullable|string|max:50',
            'selectedModules' => 'required',
            'intern_experience' => 'nullable|string|max:1000',
            'experience' => 'nullable|string|max:1000',
            'characteristics_describe' => 'nullable|string|max:1000',
            'applicant_name' => 'required|string|max:255',
            'place' => 'nullable|string|max:255',
            // 'refrance' => 'required',
            'reference_name' => 'nullable|string|max:255',
            'reference_name1' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'contact_number1' => 'nullable|string|max:15',
            'buttom_applicant_name' => 'nullable|string|max:255',
            'buttom_place' => 'nullable|string|max:255',
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

            'school_name.required' => 'School Name is required.',
            'school_name.string' => 'School Name must be a string.',
            'school_name.max' => 'School Name should not exceed 255 characters.',
            
            'tenth_per.required' => '10th Percentage is required.',
            'tenth_per.numeric' => '10th Percentage must be a number.',
            'tenth_per.min' => '10th Percentage must be at least 0.',
            'tenth_per.max' => '10th Percentage must not exceed 100.',
            
            'twelve_diploma_per.numeric' => '12th/Diploma Percentage must be a number.',
            'twelve_diploma_per.min' => '12th/Diploma Percentage must be at least 0.',
            'twelve_diploma_per.max' => '12th/Diploma Percentage must not exceed 100.',
            
            'graduation_details.string' => 'Graduation Details must be a string.',
            'graduation_details.max' => 'Graduation Details should not exceed 255 characters.',
            
            'graduation_per.numeric' => 'Graduation Percentage must be a number.',
            'graduation_per.min' => 'Graduation Percentage must be at least 0.',
            'graduation_per.max' => 'Graduation Percentage must not exceed 100.',
            
            'post_graduation_details.string' => 'Post Graduation Details must be a string.',
            'post_graduation_details.max' => 'Post Graduation Details should not exceed 255 characters.',
            
            'post_graduation_per.numeric' => 'Post Graduation Percentage must be a number.',
            'post_graduation_per.min' => 'Post Graduation Percentage must be at least 0.',
            'post_graduation_per.max' => 'Post Graduation Percentage must not exceed 100.',
            
            'anyother_cirt.string' => 'Other Certification Details must be a string.',
            'anyother_cirt.max' => 'Other Certification Details should not exceed 255 characters.',
            
            'selected_branches.required' => 'Selected Branches are required.',
            
            'other_branch.string' => 'Other Branch must be a string.',
            'other_branch.max' => 'Other Branch should not exceed 255 characters.',

            'father_name.required' => 'Father Name is required.',
            'father_name.string' => 'Father Name must be a string.',
            'father_name.max' => 'Father Name should not exceed 255 characters.',
            
            'fatherOccupation.string' => 'Father Occupation must be a string.',
            'fatherOccupation.max' => 'Father Occupation should not exceed 255 characters.',
            
            'father_contactdetails.required' => 'Father Contact Details are required.',
            'father_contactdetails.string' => 'Father Contact Details must be a string.',
            'father_contactdetails.max' => 'Father Contact Details should not exceed 15 characters.',
            
            'father_aadharno.string' => 'Father Aadhaar Number must be a string.',
            'father_aadharno.max' => 'Father Aadhaar Number should not exceed 12 characters.',
            'father_aadharno.min' => 'Father Aadhaar Number must be exactly 12 characters.',
            
            'mother_name.string' => 'Mother Parent Guardian Details must be a string.',
            'mother_name.max' => 'Mother Parent Guardian Details should not exceed 255 characters.',
            
            'motherOccupation.string' => 'Mother Occupation must be a string.',
            'motherOccupation.max' => 'Mother Occupation should not exceed 255 characters.',
            
            'mother_contactdetails.string' => 'Mother Contact Details must be a string.',
            'mother_contactdetails.max' => 'Mother Contact Details should not exceed 15 characters.',
            
            'mother_aadharno.string' => 'Mother Aadhaar Number must be a string.',
            'mother_aadharno.max' => 'Mother Aadhaar Number should not exceed 12 characters.',
            'mother_aadharno.min' => 'Mother Aadhaar Number must be exactly 12 characters.',
            
            'marriedStatus.required' => 'Marital Status is required.',

            'husbandDetails.name.required_if' => 'Husband Name is required if Married Status is Yes.',
            'husbandDetails.name.string' => 'Husband Name must be a string.',
            'husbandDetails.name.max' => 'Husband Name should not exceed 255 characters.',

            'husbandDetails.contact.required_if' => 'Husband Contact Details are required if Married Status is Yes.',
            'husbandDetails.contact.string' => 'Husband Contact Details must be a string.',
            'husbandDetails.contact.max' => 'Husband Contact Details should not exceed 15 characters.',

            'husbandDetails.aadhar.required_if' => 'Husband Aadhar Number is required if Married Status is Yes.',
            'husbandDetails.aadhar.string' => 'Husband Aadhar Number must be a string.',
            'husbandDetails.aadhar.max' => 'Husband Aadhar Number should not exceed 12 characters.',
            'husbandDetails.aadhar.min' => 'Husband Aadhar Number must be at least 12 characters.',

            'husbandDetails.occupation.required_if' => 'Husband Occupation is required if Married Status is Yes.',
            'husbandDetails.occupation.string' => 'Husband Occupation must be a string.',
            'husbandDetails.occupation.max' => 'Husband Occupation should not exceed 255 characters.',
            
            'guardian_name.string' => 'Guardian Name must be a string.',
            'guardian_name.max' => 'Guardian Name should not exceed 255 characters.',
            
            'Guardian_aadharno.string' => 'Guardian Aadhaar Number must be a string.',
            'Guardian_aadharno.max' => 'Guardian Aadhaar Number should not exceed 12 characters.',
            'Guardian_aadharno.min' => 'Guardian Aadhaar Number must be exactly 12 characters.',
            
            'Guardian_contactdetails.string' => 'Guardian Contact Details must be a string.',
            'Guardian_contactdetails.max' => 'Guardian Contact Details should not exceed 15 characters.',
            
            'GuardianOccupation.string' => 'Guardian Occupation must be a string.',
            'GuardianOccupation.max' => 'Guardian Occupation should not exceed 255 characters.',

            'technology_name.required' => 'Technology Name is required.',
            'technology_name.string' => 'Technology Name must be a string.',
            'technology_name.max' => 'Technology Name should not exceed 255 characters.',
            
            'duration.string' => 'Duration must be a string.',
            'duration.max' => 'Duration should not exceed 50 characters.',
            
            'selectedModules.required' => 'Selected Modules are required.',
            
            'intern_experience.string' => 'Internship Experience must be a string.',
            'intern_experience.max' => 'Internship Experience should not exceed 1000 characters.',
            
            'experience.string' => 'Experience must be a string.',
            'experience.max' => 'Experience should not exceed 1000 characters.',
            
            'characteristics_describe.string' => 'Characteristics Description must be a string.',
            'characteristics_describe.max' => 'Characteristics Description should not exceed 1000 characters.',
            
            'applicant_name.required' => 'Applicant Name is required.',
            'applicant_name.string' => 'Applicant Name must be a string.',
            'applicant_name.max' => 'Applicant Name should not exceed 255 characters.',
            
            'place.string' => 'Place must be a string.',
            'place.max' => 'Place should not exceed 255 characters.',

            // 'refrance.required' => 'Refrence is required.',
            
            'reference_name.string' => 'Reference Name must be a string.',
            'reference_name.max' => 'Reference Name should not exceed 255 characters.',

            'reference_name1.string' => 'Reference Name must be a string.',
            'reference_name1.max' => 'Reference Name should not exceed 255 characters.',
            
            'contact_number.string' => 'Contact Number must be a string.',
            'contact_number.max' => 'Contact Number should not exceed 15 characters.',

            'contact_number1.string' => 'Contact Number must be a string.',
            'contact_number1.max' => 'Contact Number should not exceed 15 characters.',
            
            'buttom_applicant_name.string' => 'Bottom Applicant Name must be a string.',
            'buttom_applicant_name.max' => 'Bottom Applicant Name should not exceed 255 characters.',
            
            'buttom_place.string' => 'Bottom Place must be a string.',
            'buttom_place.max' => 'Bottom Place should not exceed 255 characters.',
        ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                        $studentInfo = StudentInfo::find($id);
                        $studentInfo->fname = $request->fname;
                        $studentInfo->mname = $request->mname;
                        $studentInfo->fathername = $request->fathername;
                        $studentInfo->lname = $request->lname;
                        $studentInfo->gender = $request->gender;
                        $studentInfo->training_mode = $request->training_mode;
                        $studentInfo->parmanenat_address = $request->parmanenat_address;
                        $studentInfo->current_address = $request->current_address;
                        $studentInfo->contact_details = $request->contact_details;
                        $studentInfo->email = $request->email;
                        $studentInfo->dob = $request->dob;
                        $studentInfo->whatsappno = $request->whatsappno;
                        $studentInfo->age = $request->age;
                        $studentInfo->blood = $request->blood;
                        $studentInfo->aadhar = $request->aadhar;
                        $studentInfo->linkdin = $request->linkdin;
                        $studentInfo->facebook = $request->facebook;
                        $studentInfo->youtube = $request->youtube;
                        $studentInfo->anyother_add = $request->anyother_add;

                        $existingRecord = StudentInfo::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                        // $studentInfo->save();
                        $update_data = $studentInfo->update();

                        
                        $studentEducationDetails = StudentEdducationDetails::where('stude_id', $id)->first();
                        if ($studentEducationDetails) {
                        // $studentEducationDetails = StudentEdducationDetails::find($id);
                        // $studentEducationDetails->stude_id = $recordId;
                        $studentEducationDetails->school_name = $request->school_name;
                        $studentEducationDetails->tenth_per = $request->tenth_per;
                        $studentEducationDetails->twelve_diploma_per = $request->twelve_diploma_per;
                        $studentEducationDetails->graduation_details = $request->graduation_details;
                        $studentEducationDetails->graduation_per = $request->graduation_per;
                        $studentEducationDetails->post_graduation_details = $request->post_graduation_details;
                        $studentEducationDetails->post_graduation_per = $request->post_graduation_per;
                        $studentEducationDetails->anyother_cirt = $request->anyother_cirt;
                        $studentEducationDetails->selected_branches = $request->selected_branches;
                        $studentEducationDetails->other_branch = $request->other_branch;
                        $update_data = $studentEducationDetails->update();
                        }

                        $studentPerentsDetails = StudentParentDetails::where('stude_id', $id)->first();
                        if ($studentPerentsDetails) {
                        // $studentPerentsDetails = new StudentParentDetails();
                        // $studentPerentsDetails = StudentParentDetails::find($id);
                        // $studentPerentsDetails->stude_id = $recordId;
                        $studentPerentsDetails->father_name = $request->father_name;
                        $studentPerentsDetails->fatherOccupation = $request->fatherOccupation;
                        $studentPerentsDetails->father_contactdetails = $request->father_contactdetails;
                        $studentPerentsDetails->father_aadharno = $request->father_aadharno;
                        $studentPerentsDetails->mother_name = $request->mother_name;
                        $studentPerentsDetails->motherOccupation = $request->motherOccupation;
                        $studentPerentsDetails->mother_contactdetails = $request->mother_contactdetails;
                        $studentPerentsDetails->mother_aadharno = $request->mother_aadharno;
                        $studentPerentsDetails->marriedStatus = $request->marriedStatus;
                        $studentPerentsDetails->husband_name =  $request->husbandDetails['name'];
                        $studentPerentsDetails->Husband_contactdetails = $request->husbandDetails['contact'];
                        $studentPerentsDetails->Husband_aadharno = $request->husbandDetails['aadhar'];
                        $studentPerentsDetails->HusbandOccupation = $request->husbandDetails['occupation'];
                        $studentPerentsDetails->guardian_name = $request->guardian_name;
                        $studentPerentsDetails->Guardian_aadharno = $request->Guardian_aadharno;
                        $studentPerentsDetails->GuardianOccupation = $request->GuardianOccupation;
                        $studentPerentsDetails->Guardian_contactdetails = $request->Guardian_contactdetails;
                        // $studentPerentsDetails->save();
                        $update_data = $studentPerentsDetails->update();
                        }

                        $studentPerentsDetails = StudentInternshipDetails::where('stude_id', $id)->first();
                        if ($studentPerentsDetails) {
                        // $studentPerentsDetails = new StudentInternshipDetails();
                        // $studentPerentsDetails = StudentInternshipDetails::find($id);
                        $studentPerentsDetails->stude_id = $id;
                        $studentPerentsDetails->technology_name = $request->technology_name;
                        $studentPerentsDetails->duration = $request->duration;
                        $studentPerentsDetails->selectedModules = $request->selectedModules;
                        $studentPerentsDetails->intern_experience = $request->intern_experience;
                        $studentPerentsDetails->experience = $request->experience;
                        $studentPerentsDetails->characteristics_describe = $request->characteristics_describe;
                        $studentPerentsDetails->applicant_name = $request->applicant_name;
                        $studentPerentsDetails->place = $request->place;
                        // $studentPerentsDetails->refrance = $request->refrance;
                        // $studentPerentsDetails->refrance = implode(',', $request->refrance);
                        
                        $studentPerentsDetails->refrance_social_media = $request->refrance_social_media;
                        $studentPerentsDetails->refrance_friend = $request->refrance_friend;
                        $studentPerentsDetails->refrance_family = $request->refrance_family;
                        $studentPerentsDetails->refrance_relatives = $request->refrance_relatives;
                        $studentPerentsDetails->refrance_other = $request->refrance_other;

                        $studentPerentsDetails->reference_name = $request->reference_name;
                        $studentPerentsDetails->reference_name1 = $request->reference_name1;
                        $studentPerentsDetails->contact_number = $request->contact_number;
                        $studentPerentsDetails->contact_number1 = $request->contact_number1;
                        $studentPerentsDetails->buttom_applicant_name = $request->buttom_applicant_name;
                        $studentPerentsDetails->buttom_place = $request->buttom_place;
                        // $studentPerentsDetails->save();
                        $update_data = $studentPerentsDetails->update();
                        }
                return $this->responseApi($update_data,'Data Updated','success',200);
            }
    }

    public function destroy($id)
    {
        $all_data=[];
        // $portfolio = Portfolio::find($id);

        $studet_data = StudentInfo::find($id);
            if ($studet_data) {
                // Delete the images from the storage folder

                // Delete the record from the database
                $is_deleted = $studet_data->is_deleted == 1 ? 0 : 1;
                $studet_data->is_deleted = $is_deleted;
                $studet_data->save();
                // Log::info($studet_data);    

                $studet_education_data = StudentEdducationDetails::where('stude_id', $id)
                            ->first();
                $is_deleted = $studet_education_data->is_deleted == 1 ? 0 : 1;
                $studet_education_data->is_deleted = $is_deleted;
                $studet_education_data->save();
                // Log::info($studet_data);

                $studet_parent_data = StudentParentDetails::where('stude_id', $id)
                            ->first();
                $is_deleted = $studet_parent_data->is_deleted == 1 ? 0 : 1;
                $studet_parent_data->is_deleted = $is_deleted;
                $studet_parent_data->save();

                $studet_internship_data = StudentInternshipDetails::where('stude_id', $id)
                            ->first();
                $is_deleted = $studet_internship_data->is_deleted == 1 ? 0 : 1;
                $studet_internship_data->is_deleted = $is_deleted;
                $studet_internship_data->save();
                // Log::info($studet_data);

                // $studet_completion_data = StudentInternshipCompletionDetails::where('stude_id', $id)
                //             ->first();
                // $is_deleted = $studet_completion_data->is_deleted == 1 ? 0 : 1;
                // $studet_completion_data->is_deleted = $is_deleted;
                // $studet_completion_data->save();
                // Log::info($studet_data);

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
