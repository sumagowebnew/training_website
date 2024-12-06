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
                            ->select('fname','mname','fathername','lname','parmanenat_address','current_address','contact_details','email','dob',
            'whatsappno', 'age', 'blood', 'aadhar','linkdin','facebook','youtube','anyother_add','school_name',
            'tenth_per','twelve_diploma_per','graduation_details', 'graduation_per', 'post_graduation_details','post_graduation_per',
            'anyother_cirt','selected_branches','other_branch','father_name','fatherOccupation','father_contactdetails','father_aadharno',
            'mother_pareantgauaradiandetails','mother_name','mother_contactdetails','mother_aadharno','marriedStatus','husband_name','HusbandOccupation',
            'Husband_contactdetails','Husband_aadharno','guardian_name','GuardianOccupation','Guardian_aadharno','Guardian_contactdetails',
            'technology_name','duration','selectedModules','intern_experience',
            'experience','characteristics_describe','applicant_name','place','reference_name','contact_number','buttom_applicant_name',
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
            'parmanenat_address' => 'required|string|max:500',
            'current_address' => 'nullable|string|max:500',
            'contact_details' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'whatsappno' => 'nullable|string|max:15',
            'age' => 'required|integer|min:1',
            'blood' => 'nullable|string|max:10',
            'aadhar' => 'required|string|max:12|min:12', // Assuming a 12-digit Aadhaar number
            'linkdin' => 'nullable|url',
            'facebook' => 'nullable|url',
            'youtube' => 'nullable|url',
            'anyother_add' => 'nullable|string|max:500',
        
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
            'father_aadharno' => 'required|string|max:12|min:12',
            'mother_pareantgauaradiandetails' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_contactdetails' => 'nullable|string|max:15',
            'mother_aadharno' => 'nullable|string|max:12|min:12',
            'marriedStatus' => 'required',
            'husband_name' => 'nullable|required_if:marriedStatus,Yes|string|max:255',
            'Husband_contactdetails' => 'nullable|required_if:marriedStatus,Yes|string|max:15',
            'Husband_aadharno' => 'nullable|required_if:marriedStatus,Yes|string|max:12|min:12',
            'HusbandOccupation' => 'nullable|required_if:marriedStatus,Yes|string|max:255',
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
            'reference_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'buttom_applicant_name' => 'nullable|string|max:255',
            'buttom_place' => 'nullable|string|max:255',
        ]);
        
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        
        
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

                        // $studentEducationDetails = new StudentEdducationDetails();
                        // $studentEducationDetails->stude_id = $recordId;
                        // $studentEducationDetails->school_name = $request->school_name;
                        // $studentEducationDetails->tenth_per = $request->tenth_per;
                        // $studentEducationDetails->twelve_diploma_per = $request->twelve_diploma_per;
                        // $studentEducationDetails->graduation_details = $request->graduation_details;
                        // $studentEducationDetails->graduation_per = $request->graduation_per;
                        // $studentEducationDetails->post_graduation_details = $request->post_graduation_details;
                        // $studentEducationDetails->post_graduation_per = $request->post_graduation_per;
                        // $studentEducationDetails->anyother_cirt = $request->anyother_cirt;
                        // $studentEducationDetails->selected_branches = $request->selected_branches;
                        // $studentEducationDetails->other_branch = $request->other_branch;
                        // $studentEducationDetails->save();

                        $studentPerentsDetails = new StudentParentDetails();
                        $studentPerentsDetails->stude_id = $recordId;
                        $studentPerentsDetails->father_name = $request->father_name;
                        $studentPerentsDetails->fatherOccupation = $request->fatherOccupation;
                        $studentPerentsDetails->father_contactdetails = $request->father_contactdetails;
                        $studentPerentsDetails->father_aadharno = $request->father_aadharno;
                        $studentPerentsDetails->mother_pareantgauaradiandetails = $request->mother_pareantgauaradiandetails;
                        $studentPerentsDetails->mother_name = $request->mother_name;
                        $studentPerentsDetails->mother_contactdetails = $request->mother_contactdetails;
                        $studentPerentsDetails->mother_aadharno = $request->mother_aadharno;
                        $studentPerentsDetails->marriedStatus = $request->marriedStatus;
                        $studentPerentsDetails->husband_name = $request->husband_name;
                        $studentPerentsDetails->Husband_contactdetails = $request->Husband_contactdetails;
                        $studentPerentsDetails->Husband_aadharno = $request->Husband_aadharno;
                        $studentPerentsDetails->HusbandOccupation = $request->HusbandOccupation;
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
                        $studentPerentsDetails->reference_name = $request->reference_name;
                        $studentPerentsDetails->contact_number = $request->contact_number;
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
            'title'=>'required',
            'description' => 'required',
            'image_file'=>'required',
            'website_link'=>'required',
            ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                $portfolio_data = Portfolio::find($id);
                $portfolio_data->title = $request->title;
                $portfolio_data->description = $request->description;
                $portfolio_data->website_link = $request->website_link;
                
                $img_path = $request->image_file;

                        $folderPath = "uploads/portfolio/";
                        
                        $base64Image = explode(";base64,", $img_path);
                        //dd($base64Image);
                        $explodeImage = explode("image/", $base64Image[0]);
                        //dd($explodeImage);
                        $imageType = $explodeImage[1];

                        //dd($imageType);
                        $image_base64 = base64_decode($base64Image[1]);
                        //dd($image_base64);
                        $posts = Portfolio::get();
                        $file = $id .'_updated.'. $imageType;
                        // $file = uniqid() .'.'. $imageType;
                        $file_dir = $folderPath . $file;
                        
                        file_put_contents($file_dir, $image_base64);
                        $portfolio_data->image = $file;

                $update_data = $portfolio_data->update();

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

                $studet_education_data = StudentEdducationDetails::where('stude_id', $id)
                            ->first();
                $is_deleted = $studet_education_data->is_deleted == 1 ? 0 : 1;
                $studet_education_data->is_deleted = $is_deleted;
                $studet_education_data->save();

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

                $studet_completion_data = StudentInternshipCompletionDetails::where('stude_id', $id)
                            ->first();
                $is_deleted = $studet_completion_data->is_deleted == 1 ? 0 : 1;
                $studet_completion_data->is_deleted = $is_deleted;
                $studet_completion_data->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Portfolio Deleted Successfully!',
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
            'message' => 'Student details not found.',
        ], 404);

    }

    
}
