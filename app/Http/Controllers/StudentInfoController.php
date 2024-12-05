<?php

namespace App\Http\Controllers;

use App\Models\
{
StudentInfo,
StudentEdducationDetails,
StudentParentDetails,
StudentInternshipDetails
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
            'anyother_cirt','selected_branches','other_branch','father_name','father_occupation','father_contact_details','father_aadhar_no',
            'mother_name','mother_occupation','mother_contact_details','mother_aadhar_no','married_status','husband_name',
            'husband_contact_details','husband_aadhar_no','husband_guardian_details','guardian_name','guardian_occupation',
            'guardian_contact_details','guardian_aadhar_no','technology_name','duration','selected_modules','intern_experience',
            'experience','characteristics_describe','applicant_name','place','reference_name','contact_number','button_applicant_name',
            'button_place')
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
            'father_occupation' => 'nullable|string|max:255',
            'father_contact_details' => 'required|string|max:15',
            'father_aadhar_no' => 'required|string|max:12|min:12',
            'mother_name' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'mother_contact_details' => 'nullable|string|max:15',
            'mother_aadhar_no' => 'nullable|string|max:12|min:12',
            'married_status' => 'required',
            'husband_name' => 'nullable|required_if:married_status,Yes|string|max:255',
            'husband_contact_details' => 'nullable|required_if:married_status,Yes|string|max:15',
            'husband_aadhar_no' => 'nullable|required_if:married_status,Yes|string|max:12|min:12',
            'husband_occupation' => 'nullable|required_if:married_status,Yes|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_occupation' => 'nullable|string|max:255',
            'guardian_contact_details' => 'nullable|string|max:15',
            'guardian_aadhar_no' => 'nullable|string|max:12|min:12',
        
            // StudentInternshipDetails fields
            'technology_name' => 'required|string|max:255',
            'duration' => 'nullable|string|max:50',
            'selected_modules' => 'required',
            'intern_experience' => 'nullable|string|max:1000',
            'experience' => 'nullable|string|max:1000',
            'characteristics_describe' => 'nullable|string|max:1000',
            'applicant_name' => 'required|string|max:255',
            'place' => 'nullable|string|max:255',
            'reference_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'button_applicant_name' => 'nullable|string|max:255',
            'button_place' => 'nullable|string|max:255',
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
                        $studentPerentsDetails->father_occupation = $request->father_occupation;
                        $studentPerentsDetails->father_contact_details = $request->father_contact_details;
                        $studentPerentsDetails->father_aadhar_no = $request->father_aadhar_no;
                        $studentPerentsDetails->mother_name = $request->mother_name;
                        $studentPerentsDetails->mother_occupation = $request->mother_occupation;
                        $studentPerentsDetails->mother_contact_details = $request->mother_contact_details;
                        $studentPerentsDetails->mother_aadhar_no = $request->mother_aadhar_no;
                        $studentPerentsDetails->married_status = $request->married_status;
                        $studentPerentsDetails->husband_name = $request->husband_name;
                        $studentPerentsDetails->husband_contact_details = $request->husband_contact_details;
                        $studentPerentsDetails->husband_aadhar_no = $request->husband_aadhar_no;
                        $studentPerentsDetails->husband_occupation = $request->husband_occupation;
                        $studentPerentsDetails->guardian_name = $request->guardian_name;
                        $studentPerentsDetails->guardian_occupation = $request->guardian_occupation;
                        $studentPerentsDetails->guardian_contact_details = $request->guardian_contact_details;
                        $studentPerentsDetails->guardian_aadhar_no = $request->guardian_aadhar_no;
                        $studentPerentsDetails->save();

                        $studentPerentsDetails = new StudentInternshipDetails();
                        $studentPerentsDetails->stude_id = $recordId;
                        $studentPerentsDetails->technology_name = $request->technology_name;
                        $studentPerentsDetails->duration = $request->duration;
                        $studentPerentsDetails->selected_modules = $request->selected_modules;
                        $studentPerentsDetails->intern_experience = $request->intern_experience;
                        $studentPerentsDetails->experience = $request->experience;
                        $studentPerentsDetails->characteristics_describe = $request->characteristics_describe;
                        $studentPerentsDetails->applicant_name = $request->applicant_name;
                        $studentPerentsDetails->place = $request->place;
                        $studentPerentsDetails->reference_name = $request->reference_name;
                        $studentPerentsDetails->contact_number = $request->contact_number;
                        $studentPerentsDetails->button_applicant_name = $request->button_applicant_name;
                        $studentPerentsDetails->button_place = $request->button_place;
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

        return $this->responseApi($all_data,'Portfolio Deleted Successfully!','success',200);

            }
            // else[
            //     return response()->json(['status' => 'error', 'message' => 'Intern Details not added', 'error' => $e->getMessage()],500);

            // ]    
        
        // $portfolio->delete();
        // return response()->json("Deleted Successfully!");
        // return $this->responseApi($all_data,'Portfolio Deleted Successfully!','success',200);

    }

    
}
