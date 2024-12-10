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
class StudentInternshipCompletionController extends Controller
{
    public function index()
    {
        // Get all data from the database
        // $portfolio = Portfolio::get();

        $student_info = StudentInternshipCompletionDetails::leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.id')
                            ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
                            ->select('student_info.id','student_info.fname','student_info.mname','student_info.fathername','student_info.lname','student_info.email','student_internship_details.technology_name','date_of_joining',
                            'current_working','selected_mode','project_title','describe_project','placed','employer_name','designation_in_current_company','package_in_lpa','task_links_1','task_links_2','task_links_3','task_links_4','task_links_5',
                            'project_github','final_year_project_link','name_contact_of_first_candidate','name_contact_of_second_candidate','name_contact_of_third_candidate','name_contact_of_fourth_candidate','name_contact_of_fifth_candidate','blog_on_your_selected_technology')
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

    public function getPerticular($id)
    {

        $student_info = StudentInfo::leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
        ->leftJoin('student_parents_details', 'student_info.id', '=', 'student_parents_details.stude_id')
        ->leftJoin('student_education_details', 'student_info.id', '=', 'student_education_details.stude_id')
        ->where('student_info.id',$id)
        ->select('student_info.id','fname','mname','fathername','lname','parmanenat_address','current_address','contact_details','email','dob',
        'whatsappno', 'age', 'blood', 'aadhar','linkdin','facebook','youtube','anyother_add','school_name',
        'tenth_per','twelve_diploma_per','graduation_details', 'graduation_per', 'post_graduation_details','post_graduation_per',
        'anyother_cirt','selected_branches','other_branch','father_name','fatherOccupation','father_contactdetails','father_aadharno',
        'mother_name','motherOccupation','mother_contactdetails','mother_aadharno','marriedStatus','husband_name','HusbandOccupation',
        'Husband_contactdetails','Husband_aadharno','guardian_name','GuardianOccupation','Guardian_aadharno','Guardian_contactdetails',
        'technology_name','duration','selectedModules','intern_experience',
        'experience','characteristics_describe','applicant_name','place','reference_name','contact_number','buttom_applicant_name',
        'buttom_place')
        ->get();


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
            'name' => 'required|string|max:255',
            'technology' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date_of_joining' => 'required|date',
            'current_working' => 'required|string|max:255',
            'selected_mode' => 'required|string|max:50',
            'project_title' => 'required|string|max:255',
            'describe_project' => 'required|string|max:1000',
            'placed' => 'required|string|max:255',
            'employer_name' => 'required|required_if:placed,Yes|string|max:255',
            'designation_in_current_company' => 'required|required_if:placed,Yes|string|max:255',
            'package_in_lpa' => 'required|required_if:placed,Yes|numeric|min:0',
            'task_links_1' => 'required|string|max:1000',
            'task_links_2' => 'required|string|max:1000',
            'task_links_3' => 'required|string|max:1000',
            'task_links_4' => 'required|string|max:1000',
            'task_links_5' => 'required|string|max:1000',
            'project_github' => 'required|url|max:255',
            'final_year_project_link' => 'required|url|max:255',
            'name_contact_of_first_candidate' => 'required|string|max:255',
            'name_contact_of_second_candidate' => 'required|string|max:255',
            'name_contact_of_third_candidate' => 'required|string|max:255',
            'name_contact_of_fourth_candidate' => 'required|string|max:255',
            'name_contact_of_fifth_candidate' => 'required|string|max:255',
            'blog_on_your_selected_technology' => 'required|string|max:1000',
            // 'created_at' => 'nullable|date',
            // 'updated_at' => 'nullable|date',
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
                        $studentDetail = new StudentInternshipCompletionDetails();

                        $studentDetail->name = $request->name;
                        $studentDetail->stude_id = $request->stude_id;
                        $studentDetail->technology = $request->technology;
                        $studentDetail->email = $request->email;
                        $studentDetail->date_of_joining = $request->date_of_joining;
                        $studentDetail->current_working = $request->current_working;
                        $studentDetail->selected_mode = $request->selected_mode;
                        $studentDetail->project_title = $request->project_title;
                        $studentDetail->describe_project = $request->describe_project;
                        $studentDetail->placed = $request->placed;
                        $studentDetail->employer_name = $request->employer_name;
                        $studentDetail->designation_in_current_company = $request->designation_in_current_company;
                        $studentDetail->package_in_lpa = $request->package_in_lpa;
                        $studentDetail->task_links_1 = $request->task_links_1;
                        $studentDetail->task_links_2 = $request->task_links_2;
                        $studentDetail->task_links_3 = $request->task_links_3;
                        $studentDetail->task_links_4 = $request->task_links_4;
                        $studentDetail->task_links_5 = $request->task_links_5;
                        $studentDetail->project_github = $request->project_github;
                        $studentDetail->final_year_project_link = $request->final_year_project_link;
                        $studentDetail->name_contact_of_first_candidate = $request->name_contact_of_first_candidate;
                        $studentDetail->name_contact_of_second_candidate = $request->name_contact_of_second_candidate;
                        $studentDetail->name_contact_of_third_candidate = $request->name_contact_of_third_candidate;
                        $studentDetail->name_contact_of_fourth_candidate = $request->name_contact_of_fourth_candidate;
                        $studentDetail->name_contact_of_fifth_candidate = $request->name_contact_of_fifth_candidate;
                        $studentDetail->blog_on_your_selected_technology = $request->blog_on_your_selected_technology;

                        // Generate an ID for the new record if necessary
                        $existingRecord = StudentInternshipCompletionDetails::orderBy('id', 'DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

                        $studentDetail->save();



                        //return response()->json($client_logo);
                        return response()->json(['status' => 'Success', 'message' => 'Internship Completoin Details Added Successfully','Statuscode'=>'200']);

                        
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
