<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;

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
        $student_info = StudentInternshipCompletionDetails::leftJoin('student_personal_info', 'student_interns_completion_details.stude_id', '=', 'student_personal_info.id')
            ->leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.stude_id')
            ->leftJoin('student_internship_details', 'student_personal_info.id', '=', 'student_internship_details.stude_id')
            ->where('student_interns_completion_details.is_deleted', 0)
            ->select(
                'student_interns_completion_details.id',
                'student_personal_info.id as personal_id',
                'student_personal_info.fname',
                'student_personal_info.mname',
                'student_personal_info.fathername',
                'student_personal_info.lname',
                'student_personal_info.gender',
                'student_info.training_mode',
                'student_personal_info.email',
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
            ->groupBy('student_personal_info.id')
            ->get();
    
        $response = [];
    
        foreach ($student_info as $item) {
            $data = $item->toArray();
    
            // Construct file paths using storage_path
            $googleReviewImagePath = storage_path("app/all_web_data/images/review_images/" . $data['google_review_img']);
            $resumePath = storage_path("app/all_web_data/documents/resumes/" . $data['resume_pdf']);
            $videoPath = storage_path("app/all_web_data/videos/" . $data['feedback_video']);
    
            // Process each file
            $data['google_review_img'] = $this->encodeBase64($googleReviewImagePath);
            $data['resume_pdf'] = $this->encodeBase64($resumePath);
            $data['feedback_video'] = $this->encodeBase64($videoPath);
    
            $response[] = $data;
        }
    
        return response()->json($response);
    }
    
    private function encodeBase64($filePath)
    {
        if (file_exists($filePath)) {
            $mimeType = mime_content_type($filePath);
            return "data:$mimeType;base64," . base64_encode(file_get_contents($filePath));
        }
        return null;
    }
    
    public function getPerticular($id)
    {

        $student_info = StudentInfo::leftJoin('student_personal_info', 'student_info.stude_id', '=', 'student_personal_info.id')
        ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
        ->leftJoin('student_parents_details', 'student_info.id', '=', 'student_parents_details.stude_id')
        ->leftJoin('student_education_details', 'student_info.id', '=', 'student_education_details.stude_id')
        ->where('student_info.id',$id)
        ->select('student_info.id','student_personal_info.id as personal_id','student_personal_info.fname','student_personal_info.mname','student_personal_info.fathername',
                'student_personal_info.lname','student_personal_info.gender','training_mode','student_personal_info.parmanenat_address','student_personal_info.current_address','student_personal_info.contact_details',
                'student_personal_info.email','student_personal_info.dob','student_personal_info.whatsappno', 'student_personal_info.age', 'student_personal_info.blood',
                    'student_personal_info.aadhar','linkdin','facebook','youtube','anyother_add','school_name',
        'tenth_per','twelve_diploma_per','graduation_details', 'graduation_per', 'post_graduation_details','post_graduation_per',
        'anyother_cirt','selected_branches','other_branch','father_name','fatherOccupation','father_contactdetails','father_aadharno',
        'mother_name','motherOccupation','mother_contactdetails','mother_aadharno','marriedStatus','husband_name','HusbandOccupation',
        'Husband_contactdetails','Husband_aadharno','guardian_name','GuardianOccupation','Guardian_aadharno','Guardian_contactdetails',
        'technology_name','duration','selectedModules','intern_experience',
        'experience','characteristics_describe','applicant_name','place','refrance_social_media','refrance_friend',
            'refrance_family','refrance_relatives','refrance_other','reference_name','reference_name1','contact_number','contact_number1','buttom_applicant_name',
        'buttom_place','scoperefer')
        ->groupBy('student_personal_info.id')
        ->get();


        return response()->json($student_info);
    }

    

    // public function getPerticularCompletion($id)
    // {
    //     $student_info = StudentInternshipCompletionDetails::where('student_interns_completion_details.id',$id)
    //     ->where('is_deleted','0')  
    //     ->select('id','name','technology','email','date_of_joining','current_working','selected_mode','project_title','describe_project',
    //     'placed','employer_name', 'designation_in_current_company', 'package_in_lpa', 'task_links_1','task_links_2',
    //     'task_links_3','task_links_4','task_links_5','project_github','final_year_project_link','name_contact_of_first_candidate',
    //     'name_contact_of_second_candidate', 'name_contact_of_third_candidate', 'name_contact_of_fourth_candidate','name_contact_of_fifth_candidate',
    //     'blog_on_your_selected_technology','is_active')
    //     ->get();

    //     // $student_info = StudentInternshipCompletionDetails::leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.id')
    //     // leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
    //     // ->where('student_info.id',$id)  
    //     // ->select('student_info.id','fname','mname','fathername','lname','parmanenat_address','current_address','contact_details','email','dob',
    //     // 'whatsappno', 'age', 'blood', 'aadhar','linkdin','facebook','youtube','anyother_add','school_name',
    //     // 'tenth_per','twelve_diploma_per','graduation_details', 'graduation_per', 'post_graduation_details','post_graduation_per',
    //     // 'anyother_cirt','selected_branches','other_branch','father_name','fatherOccupation','father_contactdetails','father_aadharno',
    //     // 'mother_name','motherOccupation','mother_contactdetails','mother_aadharno','marriedStatus','husband_name','HusbandOccupation',
    //     // 'Husband_contactdetails','Husband_aadharno','guardian_name','GuardianOccupation','Guardian_aadharno','Guardian_contactdetails',
    //     // 'technology_name','duration','selectedModules','intern_experience',
    //     // 'experience','characteristics_describe','applicant_name','place','refrance','reference_name','contact_number','buttom_applicant_name',
    //     // 'buttom_place')
    //     // ->get();


    //     return response()->json($student_info);
    // }
    // public function getPerticularCompletion($id)
    // {
    //     // Join necessary tables and select the required columns
    //     $student_info = StudentInternshipCompletionDetails::leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.id')
    //         ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
    //         ->where('student_interns_completion_details.id', $id)
    //         ->where('student_interns_completion_details.is_deleted', '0')
    //         ->select(
    //             'student_interns_completion_details.id',
    //             'student_info.fname',
    //             'student_info.mname',
    //             'student_info.fathername',
    //             'student_info.lname',
    //             'student_info.email',
    //             'student_internship_details.technology_name',
    //             'date_of_joining',
    //             'current_working',
    //             'selected_mode',
    //             'project_title',
    //             'describe_project',
    //             'placed',
    //             'employer_name',
    //             'designation_in_current_company',
    //             'package_in_lpa',
    //             'task_links_1',
    //             'task_links_2',
    //             'task_links_3',
    //             'task_links_4',
    //             'task_links_5',
    //             'project_github',
    //             'final_year_project_link',
    //             'name_contact_of_first_candidate',
    //             'name_contact_of_second_candidate',
    //             'name_contact_of_third_candidate',
    //             'name_contact_of_fourth_candidate',
    //             'name_contact_of_fifth_candidate',
    //             'blog_on_your_selected_technology',
    //             'google_review_img',
    //             'resume_pdf',
    //             'feedback_video'
    //         )
    //         ->first();  // We use `first()` here since we're fetching a specific student's record by ID
    
    //     if (!$student_info) {
    //         return response()->json(['message' => 'Student not found'], 404);
    //     }
    
    //     // Convert the retrieved data into an array
    //     $data = $student_info->toArray();
    
    //     // Construct file paths using storage_path
    //     $googleReviewImagePath = storage_path("app/all_web_data/images/review_images/" . $data['google_review_img']);
    //     $resumePath = storage_path("app/all_web_data/pdf/resume/" . $data['resume_pdf']);
    //     $videoPath = storage_path("app/all_web_data/videos/feedback/" . $data['feedback_video']);
    
    //     // Check if the files exist and encode them to Base64
    //     $data['google_review_img'] = file_exists($googleReviewImagePath) ? $this->encodeBase64($googleReviewImagePath) : null;
    //     $data['resume_pdf'] = file_exists($resumePath) ? $this->encodeBase64($resumePath) : null;
    //     $data['feedback_video'] = file_exists($videoPath) ? $this->encodeBase64($videoPath) : null;
    
    //     return response()->json($data);
    // }
//     public function getPerticularCompletion($id)
// {
//     // Join necessary tables and select the required columns
//     $student_info = StudentInternshipCompletionDetails::leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.id')
//         ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
//         ->where('student_interns_completion_details.id', $id)
//         ->where('student_interns_completion_details.is_deleted', '0')
//         ->select(
//             'student_interns_completion_details.id',
//             'student_info.fname',
//             'student_info.mname',
//             'student_info.fathername',
//             'student_info.lname',
//             'student_info.email',
//             'student_internship_details.technology_name',
//             'date_of_joining',
//             'current_working',
//             'selected_mode',
//             'project_title',
//             'describe_project',
//             'placed',
//             'employer_name',
//             'designation_in_current_company',
//             'package_in_lpa',
//             'task_links_1',
//             'task_links_2',
//             'task_links_3',
//             'task_links_4',
//             'task_links_5',
//             'project_github',
//             'final_year_project_link',
//             'name_contact_of_first_candidate',
//             'name_contact_of_second_candidate',
//             'name_contact_of_third_candidate',
//             'name_contact_of_fourth_candidate',
//             'name_contact_of_fifth_candidate',
//             'blog_on_your_selected_technology',
//             'google_review_img',
//             'resume_pdf',
//             'feedback_video'
//         )
//         ->first();

//     // Check if record exists
//     if (!$student_info) {
//         return response()->json(['message' => 'Student not found'], 404);
//     }

//     // Convert to array
//     $data = $student_info->toArray();

//     // File paths
//     $googleReviewImagePath = str_replace('\\', '/', storage_path()) . "/all_web_data/images/google_review/" . $data['google_review_img'];
//     $resumePath = str_replace('\\', '/', storage_path()) . "/all_web_data/pdf/resume/" . $data['resume_pdf'];
//     $videoPath = str_replace('\\', '/', storage_path()) . "/all_web_data/videos/feedback/" . $data['feedback_video'];

//     // Encode files as Base64 with appropriate headers
//     $data['google_review_img'] = $this->fileToBase64WithPrefix($googleReviewImagePath, 'image/jpeg'); // Adjust mime type if needed
//     $data['resume_pdf'] = $this->fileToBase64WithPrefix($resumePath, 'application/pdf');
//     $data['feedback_video'] = $this->fileToBase64WithPrefix($videoPath, 'video/mp4'); // Adjust mime type if video type differs

//     $data['table_name'] = 'student_interns_completion_details';

//     return response()->json($data);
// }
public function getPerticularCompletion($id)
{
    // Join necessary tables and select the required columns
    $student_info = StudentInternshipCompletionDetails::leftJoin('student_personal_info', 'student_interns_completion_details.stude_id', '=', 'student_personal_info.id')
        ->leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.stude_id')
        ->leftJoin('student_internship_details', 'student_personal_info.id', '=', 'student_internship_details.stude_id')
        ->where('student_interns_completion_details.id', $id)
        ->where('student_interns_completion_details.is_deleted', '0')
        ->select(
            'student_interns_completion_details.id',
            'student_personal_info.id as personal_id',
            'student_personal_info.fname',
            'student_personal_info.mname',
            'student_personal_info.fathername',
            'student_personal_info.lname',
            'student_personal_info.gender',
            'student_info.training_mode',
            'student_personal_info.email',
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
            'feedback_video',
            'student_personal_info.blood'
        )
        ->groupBy('student_personal_info.id')
        ->first();

    // Check if record exists
    if (!$student_info) {
        return response()->json(['message' => 'Student not found'], 404);
    }

    // Convert to array
    $data = $student_info->toArray();

    // File paths
    $googleReviewImagePath = storage_path("all_web_data/images/google_review/") . $data['google_review_img'];
    $resumePath = storage_path("all_web_data/pdf/resume/") . $data['resume_pdf'];
    $videoPath = storage_path("all_web_data/videos/feedback/") . $data['feedback_video'];

    // Encode files as Base64 with appropriate headers only if files exist
    $data['google_review_img'] = (isset($data['google_review_img']) && is_file($googleReviewImagePath))
        ? $this->fileToBase64WithPrefix($googleReviewImagePath, 'image/jpeg')
        : null;

    $data['resume_pdf'] = (isset($data['resume_pdf']) && is_file($resumePath))
        ? $this->fileToBase64WithPrefix($resumePath, 'application/pdf')
        : null;

    $data['feedback_video'] = (isset($data['feedback_video']) && is_file($videoPath))
        ? $this->fileToBase64WithPrefix($videoPath, 'video/mp4')
        : null;

    $data['table_name'] = 'student_interns_completion_details';

    return response()->json($data);
}

public function getPerticularCompletionByStudId($id)
{
    // Join necessary tables and select the required columns
    $student_info = StudentInternshipCompletionDetails::leftJoin('student_personal_info', 'student_interns_completion_details.stude_id', '=', 'student_personal_info.id')
        ->leftJoin('student_info', 'student_interns_completion_details.stude_id', '=', 'student_info.stude_id')
        ->leftJoin('student_internship_details', 'student_personal_info.id', '=', 'student_internship_details.stude_id')
        ->where('student_interns_completion_details.stude_id', $id)
        ->where('student_interns_completion_details.is_deleted', '0')
        ->select(
            'student_interns_completion_details.id',
            'student_personal_info.id as personal_id',
            'student_personal_info.fname',
            'student_personal_info.mname',
            'student_personal_info.fathername',
            'student_personal_info.lname',
            'student_personal_info.gender',
            'student_info.training_mode',
            'student_personal_info.email',
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
            'feedback_video',
            'student_personal_info.blood'
        )
        ->groupBy('student_personal_info.id')
        ->first();

    // Check if record exists
    if (!$student_info) {
        return response()->json(['message' => 'Student not found'], 404);
    }

    // Convert to array
    $data = $student_info->toArray();

    // File paths
    $googleReviewImagePath = storage_path("all_web_data/images/google_review/") . $data['google_review_img'];
    $resumePath = storage_path("all_web_data/pdf/resume/") . $data['resume_pdf'];
    $videoPath = storage_path("all_web_data/videos/feedback/") . $data['feedback_video'];

    // Encode files as Base64 with appropriate headers only if files exist
    $data['google_review_img'] = (isset($data['google_review_img']) && is_file($googleReviewImagePath))
        ? $this->fileToBase64WithPrefix($googleReviewImagePath, 'image/jpeg')
        : null;

    $data['resume_pdf'] = (isset($data['resume_pdf']) && is_file($resumePath))
        ? $this->fileToBase64WithPrefix($resumePath, 'application/pdf')
        : null;

    $data['feedback_video'] = (isset($data['feedback_video']) && is_file($videoPath))
        ? $this->fileToBase64WithPrefix($videoPath, 'video/mp4')
        : null;

    $data['table_name'] = 'student_interns_completion_details';

    return response()->json($data);
}

/**
 * Convert file to Base64 with prefix if it exists.
 *
 * @param string $filePath
 * @param string $mimeType
 * @return string|null
 */
private function fileToBase64WithPrefix($filePath, $mimeType)
{
    if (file_exists($filePath)) {
        return "data:{$mimeType};base64," . base64_encode(file_get_contents($filePath));
    }
    return null;
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
            'package_in_lpa' => 'required|required_if:placed,Yes',
            'task_links_1' => 'required|max:1000',
            'task_links_2' => 'required|max:1000',
            'task_links_3' => 'required|max:1000',
            'task_links_4' => 'required|max:1000',
            'task_links_5' => 'required|max:1000',
            'project_github' => 'required|max:255',
            'final_year_project_link' => 'required|max:255',
            'name_contact_of_first_candidate' => 'required|string|max:255',
            'name_contact_of_second_candidate' => 'required|string|max:255',
            'name_contact_of_third_candidate' => 'required|string|max:255',
            'name_contact_of_fourth_candidate' => 'required|string|max:255',
            'name_contact_of_fifth_candidate' => 'required|string|max:255',
            'blog_on_your_selected_technology' => 'required|string|max:1000',

            'review_image' => 'required', // Image must be one of the specified formats and max size 2MB
            'resume_pdf' => 'required', // PDF must be a PDF format and max size 5MB
            'feedback_video' => 'required|max:10240', // Video formats and max size 10MB
            
            
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
            'project_github.max' => 'The project GitHub may not be greater than 255 characters.',

            'final_year_project_link.required' => 'The final year project link field is required.',
            'final_year_project_link.max' => 'The final year project link may not be greater than 255 characters.',

            // Repeat similar messages for candidate names and contacts.

            'blog_on_your_selected_technology.required' => 'The blog on your selected technology field is required.',
            'blog_on_your_selected_technology.string' => 'The blog must be a valid string.',
            'blog_on_your_selected_technology.max' => 'The blog may not be greater than 1000 characters.',

            'review_image.required' => 'The review image is required.',
            // 'review_image.mimes' => 'The review image must be in jpeg, png, jpg, or gif format.',
            // 'review_image.max' => 'The review image size must not exceed 2MB.',
            'resume_pdf.required' => 'The resume PDF is required.',
            // 'resume_pdf.mimes' => 'The resume must be a valid PDF file.',
            // 'resume_pdf.max' => 'The resume PDF size must not exceed 5MB.',
            'feedback_video.required' => 'The feedback video is required.',
            // 'feedback_video.mimes' => 'The feedback video must be in mp4, avi, mov, or wmv format.',
            'feedback_video.max' => 'The feedback video size must not exceed 10MB.',
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
                    // dd($ImageName);
                    if ($ImageName) {
                        $studentDetail->google_review_img = $ImageName;
                    }
                }
                // dd($request->resume_pdf);

                
                // Handle the resume PDF (base64)
                if ($request->resume_pdf) {
                    $PDFName = $this->saveBase64File($request->resume_pdf, '/all_web_data/pdf/resume', $last_insert_id, 'pdf');
                    // dd($PDFName);
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
                // $studentDetail->save();
                if($studentDetail->save()){        
                            return response()->json(['status' => 'Success', 'message' => 'Internship Completion Details Added Successfully', 'Statuscode' => '200']);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'Intern Details not added', 'error' => $e->getMessage()],500);
                    
                }
                      
                
                    }

                    catch (exception $e) {
                        return response()->json(['status' => 'error', 'message' => 'Intern Details not added', 'error' => $e->getMessage()],500);
                    }
            }
    }    

    
    public function update(Request $request, $id)
    {
        dd($_REQUEST);
        $validator = Validator::make($request->all(), [
            // StudentInfo fields
            // 'name' => 'required|string|max:255',
            // 'technology' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date_of_joining' => 'required|date',
            'current_working' => 'required|string|max:255',
            'selected_mode' => 'required|string|max:50',
            'project_title' => 'required|string|max:255',
            'describe_project' => 'required|string|max:1000',
            'placed' => 'required|string|max:255',
            'employer_name' => 'required|required_if:placed,Yes|string|max:255',
            'designation_in_current_company' => 'required|required_if:placed,Yes|string|max:255',
            'package_in_lpa' => 'required|required_if:placed,Yes',
            'task_links_1' => 'required|max:1000',
            'task_links_2' => 'required|max:1000',
            'task_links_3' => 'required|max:1000',
            'task_links_4' => 'required|max:1000',
            'task_links_5' => 'required|max:1000',
            'project_github' => 'required|max:255',
            'final_year_project_link' => 'required|max:255',
            'name_contact_of_first_candidate' => 'required|string|max:255',
            'name_contact_of_second_candidate' => 'required|string|max:255',
            'name_contact_of_third_candidate' => 'required|string|max:255',
            'name_contact_of_fourth_candidate' => 'required|string|max:255',
            'name_contact_of_fifth_candidate' => 'required|string|max:255',
            'blog_on_your_selected_technology' => 'required|string|max:1000',

            'review_image' => 'required', // Image must be one of the specified formats and max size 2MB
            'resume_pdf' => 'required', // PDF must be a PDF format and max size 5MB
            'feedback_video' => 'required', // Video formats and max size 10MB
        ], [
            // 'name.required' => 'The name field is required.',
            // 'name.string' => 'The name must be a valid string.',
            // 'name.max' => 'The name may not be greater than 255 characters.',

            // 'technology.required' => 'The technology field is required.',
            // 'technology.string' => 'The technology must be a valid string.',
            // 'technology.max' => 'The technology may not be greater than 255 characters.',

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
            'project_github.max' => 'The project GitHub may not be greater than 255 characters.',

            'final_year_project_link.required' => 'The final year project link field is required.',
            'final_year_project_link.max' => 'The final year project link may not be greater than 255 characters.',

            // Repeat similar messages for candidate names and contacts.

            'blog_on_your_selected_technology.required' => 'The blog on your selected technology field is required.',
            'blog_on_your_selected_technology.string' => 'The blog must be a valid string.',
            'blog_on_your_selected_technology.max' => 'The blog may not be greater than 1000 characters.',

            'review_image.required' => 'The review image is required.',

            'resume_pdf.required' => 'The resume PDF is required.',

            'feedback_video.required' => 'The feedback video is required.',
            // 'feedback_video.max' => 'The feedback video size must not exceed 10MB.'
        ]);
        
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                $studentDetail = StudentInternshipCompletionDetails::find($id);
                        
                // Assigning request data to model
                $studentDetail->name = $request->name;
                // $studentDetail->stude_id = $request->stude_id;
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

                // $update_data = $portfolio_data->studentDetail();
                $update_data = $studentDetail->update();

                 // Handle the review image (base64)
                    if ($request->review_image) {
                        // Delete the old image if it exists
                        if ($studentDetail->google_review_img && file_exists(base_path('public/all_web_data/images/google_review/' . $studentDetail->google_review_img))) {
                            unlink(public_path('/all_web_data/images/google_review/' . $studentDetail->google_review_img));
                        }

                        // Save the new image
                        $ImageName = $this->saveBase64File($request->review_image, '/all_web_data/images/google_review', $studentDetail->id, 'image');
                        if ($ImageName) {
                            $studentDetail->google_review_img = $ImageName;
                        }
                    }

                    // Handle the resume PDF (base64)
                    if ($request->resume_pdf) {
                        // Delete the old PDF if it exists
                        if ($studentDetail->resume_pdf && file_exists(base_path('public/all_web_data/pdf/resume/' . $studentDetail->resume_pdf))) {
                            unlink(public_path('/all_web_data/pdf/resume/' . $studentDetail->resume_pdf));
                        }

                        // Save the new PDF
                        $PDFName = $this->saveBase64File($request->resume_pdf, '/all_web_data/pdf/resume', $studentDetail->id, 'pdf');
                        if ($PDFName) {
                            $studentDetail->resume_pdf = $PDFName;
                        }
                    }

                    // Handle the feedback video (base64)
                    if ($request->feedback_video) {
                        // Delete the old video if it exists
                        if ($studentDetail->feedback_video && file_exists(base_path('public/all_web_data/videos/feedback/' . $studentDetail->feedback_video))) {
                            unlink(public_path('/all_web_data/videos/feedback/' . $studentDetail->feedback_video));
                        }

                        // Save the new video
                        $VideoName = $this->saveBase64File($request->feedback_video, '/all_web_data/videos/feedback', $studentDetail->id, 'video');
                        if ($VideoName) {
                            $studentDetail->feedback_video = $VideoName;
                        }
                    }


                return response()->json([
                    'status' => 'success',
                    'message' => 'Intern Completion Data Updated Successfully!',
                    'data' => $update_data,
                ], 200);
            }
    }

    public function destroy($id)
    {
        $all_data=[];
        // $portfolio = Portfolio::find($id);

        $student_data = StudentInternshipCompletionDetails::find($id);
        $data = StudentInternshipDetails::where('is_deleted', 0)->get();

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
