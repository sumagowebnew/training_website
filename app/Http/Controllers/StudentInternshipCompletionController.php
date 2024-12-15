<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;

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
class StudentInternshipCompletionController extends Controller
{
    // public function index()
    // {
    //     // Get all data from the database
    //     // $portfolio = Portfolio::get();

    //     $student_info = StudentInternshipCompletionDetails::leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.id')
    //                         ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
    //                         ->select('student_interns_completion_details.id','student_info.fname','student_info.mname','student_info.fathername','student_info.lname','student_info.email','student_internship_details.technology_name','date_of_joining',
    //                         'current_working','selected_mode','project_title','describe_project','placed','employer_name','designation_in_current_company','package_in_lpa','task_links_1','task_links_2','task_links_3','task_links_4','task_links_5',
    //                         'project_github','final_year_project_link','name_contact_of_first_candidate','name_contact_of_second_candidate','name_contact_of_third_candidate','name_contact_of_fourth_candidate','name_contact_of_fifth_candidate',
    //                         'blog_on_your_selected_technology','review_image','resume_pdf','feedback_video')
    //                         ->get();

    //     // $response = [];

    //     // foreach ($portfolio as $item) {
    //     //     $data = $item->toArray();
          
    //     //     $logo = $data['image'];

    //     //     $imagePath = "uploads/portfolio/" . $logo;

    //     //     $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

    //     //     $data['image'] = $base64;
    //     //     // $data['title']= $data['title'];
    //     //     // $data['description']=$data['description'];
    //     //     // $data['website_link']=$data['website_link'];
    //     //     // $data['website_status']=$data['website_status'];
    //     //     // $data['created_at']=$data['created_at'];
    //     //     // $data['updated_at']=$data['updated_at'];
          
    //     //     $response[] = $data;
    //     // }

    //     return response()->json($student_info);
    // }
    public function index()
    {
        $student_info = StudentInternshipCompletionDetails::leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.id')
            ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
            ->select(
                'student_interns_completion_details.id', 
                'student_info.fname', 
                'student_info.mname', 
                'student_info.fathername', 
                'student_info.lname', 
                'student_info.email', 
                'student_internship_details.technology_name', 
                'date_of_joining', 
                'current_working', 
                'selected_mode', 
                'project_title', 
                'describe_project', 
                'placed', 
                'employer_name', 
                'designation_in_current_company', 
                'package_in_lpa', 
                'task_links_1', 
                'task_links_2', 
                'task_links_3', 
                'task_links_4', 
                'task_links_5', 
                'project_github', 
                'final_year_project_link', 
                'name_contact_of_first_candidate', 
                'name_contact_of_second_candidate', 
                'name_contact_of_third_candidate', 
                'name_contact_of_fourth_candidate', 
                'name_contact_of_fifth_candidate', 
                'blog_on_your_selected_technology', 
                'google_review_img', 
                'resume_pdf', 
                'feedback_video'
            )
            ->get();
    
        $response = [];
    
        foreach ($student_info as $item) {
            $data = $item->toArray();
    
            // Process `review_image` as base64
            if (!empty($data['google_review_img'])) {
                $imagePath = public_path("uploads/review_images/" . $data['google_review_img']);
                if (file_exists($imagePath)) {
                    $data['google_review_img'] = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
                } else {
                    $data['google_review_img'] = null;
                }
            }
    
            // Process `resume_pdf` as base64
            if (!empty($data['resume_pdf'])) {
                $pdfPath = public_path("uploads/resumes/" . $data['resume_pdf']);
                if (file_exists($pdfPath)) {
                    $data['resume_pdf'] = "data:application/pdf;base64," . base64_encode(file_get_contents($pdfPath));
                } else {
                    $data['resume_pdf'] = null;
                }
            }
    
            // Process `feedback_video` as base64
            if (!empty($data['feedback_video'])) {
                $videoPath = public_path("uploads/videos/" . $data['feedback_video']);
                if (file_exists($videoPath)) {
                    $data['feedback_video'] = "data:video/mp4;base64," . base64_encode(file_get_contents($videoPath));
                } else {
                    $data['feedback_video'] = null;
                }
            }
    
            $response[] = $data;
        }
    
        return response()->json($response);
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
        'experience','characteristics_describe','applicant_name','place','refrance','reference_name','contact_number','buttom_applicant_name',
        'buttom_place')
        ->get();


        return response()->json($student_info);
    }

    public function getPerticularCompletion($id)
    {
        $student_info = StudentInternshipCompletionDetails::where('student_interns_completion_details.id',$id)
        ->where('is_deleted','0')  
        ->select('id','name','technology','email','date_of_joining','current_working','selected_mode','project_title','describe_project',
        'placed','employer_name', 'designation_in_current_company', 'package_in_lpa', 'task_links_1','task_links_2',
        'task_links_3','task_links_4','task_links_5','project_github','final_year_project_link','name_contact_of_first_candidate',
        'name_contact_of_second_candidate', 'name_contact_of_third_candidate', 'name_contact_of_fourth_candidate','name_contact_of_fifth_candidate',
        'blog_on_your_selected_technology','is_active')
        ->get();

        // $student_info = StudentInternshipCompletionDetails::leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.id')
        // leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
        // ->where('student_info.id',$id)  
        // ->select('student_info.id','fname','mname','fathername','lname','parmanenat_address','current_address','contact_details','email','dob',
        // 'whatsappno', 'age', 'blood', 'aadhar','linkdin','facebook','youtube','anyother_add','school_name',
        // 'tenth_per','twelve_diploma_per','graduation_details', 'graduation_per', 'post_graduation_details','post_graduation_per',
        // 'anyother_cirt','selected_branches','other_branch','father_name','fatherOccupation','father_contactdetails','father_aadharno',
        // 'mother_name','motherOccupation','mother_contactdetails','mother_aadharno','marriedStatus','husband_name','HusbandOccupation',
        // 'Husband_contactdetails','Husband_aadharno','guardian_name','GuardianOccupation','Guardian_aadharno','Guardian_contactdetails',
        // 'technology_name','duration','selectedModules','intern_experience',
        // 'experience','characteristics_describe','applicant_name','place','refrance','reference_name','contact_number','buttom_applicant_name',
        // 'buttom_place')
        // ->get();


        return response()->json($student_info);
    }

    public function getAllRecord(Request $request)
    {
        $all_data = Count::get()->toArray();
        return $this->responseApi($all_data,'All data get','success',200);
    }
// Method to handle saving base64 files (Image, Video, PDF)
public function saveBase64File($base64File, $directory, $prefix, $type)
{
    // Validate base64 format
    if (strpos($base64File, ';base64,') === false) {
        return null; // Invalid base64 format
    }

    // Extract file content from base64 string
    $base64Data = explode(";base64,", $base64File);
    if (count($base64Data) != 2) {
        return null; // Invalid base64 structure
    }

    // Decode the file content
    $fileContent = base64_decode($base64Data[1]);
    if (!$fileContent) {
        return null; // Failed to decode base64
    }

    // Generate a random filename for the file
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 18; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    // Determine file extension based on file type
    $fileName = $prefix . '_' . $randomString;
    switch ($type) {
        case 'image':
            // Handling image files
            $imageInfo = explode("image/", $base64Data[0]);
            $fileType = isset($imageInfo[1]) ? $imageInfo[1] : 'png'; // Default to png if type is missing
            $fileName .= '.' . $fileType;
            break;
        case 'pdf':
            // Handling PDF files
            $fileName .= '.pdf';
            break;
        case 'video':
            // Handling video files
            $fileName .= '.mp4'; // Default video format
            break;
        default:
            return null; // Invalid file type
    }

    // Set the folder path for storage
    $folderPath = str_replace('\\', '/', storage_path($directory));
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true); // Create directory if it doesn't exist
    }

    // Define the full file path
    $filePath = $folderPath . '/' . $fileName;

    // Write the content to the file
    if (file_put_contents($filePath, $fileContent)) {
        return $fileName; // Return the filename of the saved file
    }

    return null; // Failure to write the file
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
            'task_links_1' => 'required|max:1000',
            'task_links_2' => 'required|max:1000',
            'task_links_3' => 'required|max:1000',
            'task_links_4' => 'required|max:1000',
            'task_links_5' => 'required|max:1000',
            'project_github' => 'required|url|max:255',
            'final_year_project_link' => 'required|url|max:255',
            'name_contact_of_first_candidate' => 'required|string|max:255',
            'name_contact_of_second_candidate' => 'required|string|max:255',
            'name_contact_of_third_candidate' => 'required|string|max:255',
            'name_contact_of_fourth_candidate' => 'required|string|max:255',
            'name_contact_of_fifth_candidate' => 'required|string|max:255',
            'blog_on_your_selected_technology' => 'required|string|max:1000',

            // 'review_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Image must be one of the specified formats and max size 2MB
            // 'resume_pdf' => 'required|mimes:pdf|max:5120', // PDF must be a PDF format and max size 5MB
            // 'feedback_video' => 'required|mimes:mp4,avi,mov,wmv|max:10240', // Video formats and max size 10MB
            
            // 'created_at' => 'nullable|date',
            // 'updated_at' => 'nullable|date',
        ], [
            'name.required' => 'The name field is required.',
    'name.string' => 'The name must be a valid string.',
    'name.max' => 'The name may not be greater than 255 characters.',

    'technology.required' => 'The technology field is required.',
    'technology.string' => 'The technology must be a valid string.',
    'technology.max' => 'The technology may not be greater than 255 characters.',

    'email.required' => 'The email field is required.',
    'email.email' => 'The email must be a valid email address.',
    'email.max' => 'The email may not be greater than 255 characters.',

    'date_of_joining.required' => 'The date of joining field is required.',
    'date_of_joining.date' => 'The date of joining must be a valid date.',

    'current_working.required' => 'The current working field is required.',
    'current_working.string' => 'The current working must be a valid string.',
    'current_working.max' => 'The current working may not be greater than 255 characters.',

    'selected_mode.required' => 'The selected mode field is required.',
    'selected_mode.string' => 'The selected mode must be a valid string.',
    'selected_mode.max' => 'The selected mode may not be greater than 50 characters.',

    'project_title.required' => 'The project title field is required.',
    'project_title.string' => 'The project title must be a valid string.',
    'project_title.max' => 'The project title may not be greater than 255 characters.',

    'describe_project.required' => 'The describe project field is required.',
    'describe_project.string' => 'The describe project must be a valid string.',
    'describe_project.max' => 'The describe project may not be greater than 1000 characters.',

    'placed.required' => 'The placed field is required.',
    'placed.string' => 'The placed field must be a valid string.',
    'placed.max' => 'The placed field may not be greater than 255 characters.',

    'employer_name.required_if' => 'The employer name is required if placed is Yes.',
    'employer_name.string' => 'The employer name must be a valid string.',
    'employer_name.max' => 'The employer name may not be greater than 255 characters.',

    'designation_in_current_company.required_if' => 'The designation in current company is required if placed is Yes.',
    'designation_in_current_company.string' => 'The designation must be a valid string.',
    'designation_in_current_company.max' => 'The designation may not be greater than 255 characters.',

    'package_in_lpa.required_if' => 'The package in LPA is required if placed is Yes.',
    'package_in_lpa.numeric' => 'The package in LPA must be a valid number.',
    'package_in_lpa.min' => 'The package in LPA must be at least 0.',

    'task_links_1.required' => 'The task link 1 field is required.',
    'task_links_1.max' => 'The task link 1 may not be greater than 1000 characters.',

    'task_links_2.required' => 'The task link 2 field is required.',
    'task_links_2.max' => 'The task link 2 may not be greater than 1000 characters.',

    'task_links_3.required' => 'The task link 3 field is required.',
    'task_links_3.max' => 'The task link 3 may not be greater than 1000 characters.',

    'task_links_4.required' => 'The task link 4 field is required.',
    'task_links_4.max' => 'The task link 4 may not be greater than 1000 characters.',

    'task_links_5.required' => 'The task link 5 field is required.',
    'task_links_5.max' => 'The task link 5 may not be greater than 1000 characters.',

    // Repeat similar messages for `task_links_2`, `task_links_3`, `task_links_4`, and `task_links_5`.

    'project_github.required' => 'The project GitHub field is required.',
    'project_github.url' => 'The project GitHub must be a valid URL.',
    'project_github.max' => 'The project GitHub may not be greater than 255 characters.',

    'final_year_project_link.required' => 'The final year project link field is required.',
    'final_year_project_link.url' => 'The final year project link must be a valid URL.',
    'final_year_project_link.max' => 'The final year project link may not be greater than 255 characters.',

    // Repeat similar messages for candidate names and contacts.

    'blog_on_your_selected_technology.required' => 'The blog on your selected technology field is required.',
    'blog_on_your_selected_technology.string' => 'The blog must be a valid string.',
    'blog_on_your_selected_technology.max' => 'The blog may not be greater than 1000 characters.',

    // 'review_image.required' => 'The review image is required.',
    // 'review_image.image' => 'The review image must be a valid image file.',
    // 'review_image.mimes' => 'The review image must be in jpeg, png, jpg, or gif format.',
    // 'review_image.max' => 'The review image size must not exceed 2MB.',
    // 'resume_pdf.required' => 'The resume PDF is required.',
    // 'resume_pdf.mimes' => 'The resume must be a valid PDF file.',
    // 'resume_pdf.max' => 'The resume PDF size must not exceed 5MB.',
    // 'feedback_video.required' => 'The feedback video is required.',
    // 'feedback_video.mimes' => 'The feedback video must be in mp4, avi, mov, or wmv format.',
    // 'feedback_video.max' => 'The feedback video size must not exceed 10MB.',
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
                        
                            // Assigning request data to model
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
                        
                            $studentDetail->save();
                            $last_insert_id = $studentDetail->id;
                       // Handle the review image (base64)
                if ($request->review_image) {
                    $ImageName = $this->saveBase64File($request->review_image, '/all_web_data/images/google_review', $last_insert_id, 'image');
                    if ($ImageName) {
                        $studentDetail->google_review_img = $ImageName;
                    }
                }

                // Handle the resume PDF (base64)
                if ($request->resume_pdf) {
                    $PDFName = $this->saveBase64File($request->resume_pdf, '/all_web_data/pdf/resume', $last_insert_id, 'pdf');
                    if ($PDFName) {
                        $studentDetail->resume_pdf = $PDFName;
                    }
                }

                // Handle the feedback video (base64)
                if ($request->feedback_video) {
                    $VideoName = $this->saveBase64File($request->feedback_video, '/all_web_data/videos/feedback', $last_insert_id, 'video');
                    if ($VideoName) {
                        $studentDetail->feedback_video = $VideoName;
                    }
                }

                // Save the updated student details with the uploaded files
                $studentDetail->save();
                        
                            return response()->json(['status' => 'Success', 'message' => 'Internship Completion Details Added Successfully', 'Statuscode' => '200']);

                      
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

        $student_data = StudentInternshipCompletionDetails::find($id);
            if ($student_data) {
                // Delete the images from the storage folder

                // Delete the record from the database
                $is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
                $student_data->is_deleted = $is_deleted;
                $student_data->save();

        // return $this->responseApi($all_data,'Portfolio Deleted Successfully!','success',200);
        return response()->json([
            'status' => 'success',
            'message' => 'Intern Data Deleted Successfully!',
            'data' => $all_data,
        ], 200);

            }
            return response()->json([
                'status' => 'error',
                'message' => 'Intern details not found.',
            ], 404);

    }

    
}
