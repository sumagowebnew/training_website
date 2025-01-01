<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;

use App\Models\
{
StudentInfo,
StudentEdducationDetails,
StudentParentDetails,
StudentInternshipDetails,
StudentInternshipCompletionDetails,
StudentIdCardInfo
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Validator;
class StudentIdCardInformationController extends Controller
{
  
    public function index()
    {
        $student_info = StudentIdCardInfo::leftJoin('student_info', 'student_id_card_info.stude_id', '=', 'student_info.id')
            ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
            ->where('student_id_card_info.is_deleted', 0)
            ->select(
                'student_id_card_info.id',
                'student_info.fname',
                'student_info.mname',
                'student_info.fathername',
                'student_info.lname',
                'student_internship_details.technology_name',
                'date_of_joining',
                'student_id_card_info.contact_details',
                'student_id_card_info.shirt_size',
                'student_id_card_info.is_active',
                'student_id_card_info.is_deleted',
                'student_id_card_info.created_at',
                'student_id_card_info.updated_at',
            )
            ->get();
    
        $response = [];
    
        // foreach ($student_info as $item) {
        //     $data = $item->toArray();
    
        //     // Construct file paths using storage_path
        //     $googleReviewImagePath = storage_path("app/all_web_data/images/review_images/" . $data['google_review_img']);
        //     $resumePath = storage_path("app/all_web_data/documents/resumes/" . $data['resume_pdf']);
        //     $videoPath = storage_path("app/all_web_data/videos/" . $data['feedback_video']);
    
        //     // Process each file
        //     $data['google_review_img'] = $this->encodeBase64($googleReviewImagePath);
        //     $data['resume_pdf'] = $this->encodeBase64($resumePath);
        //     $data['feedback_video'] = $this->encodeBase64($videoPath);
    
        //     $response[] = $data;
        // }
    
        return response()->json($student_info);
    }
    

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // StudentInfo fields
            'name' => 'required|string|max:255',
            'technology' => 'required|string|max:255',
            'date_of_joining' => 'required|date',
            'contact_details' => 'required|string|max:15',
            'blood_group' => 'nullable|string|max:10',
            'shirt_size' => 'required',

           
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

    'contact_details.required' => 'Contact Details are required.',
    'contact_details.string' => 'Contact Details must be a string.',
    'contact_details.max' => 'Contact Details should not exceed 15 characters.',

    'blood_group.string' => 'Blood Group must be a string.',
    'blood_group.max' => 'Blood Group should not exceed 10 characters.',

    'shirt_size.required' => 'Shirt Size is required.',
        ]);
  
            if ($validator->fails())
            {
                return $validator->errors()->all();
        
            }else
            {
                
                    try{
                            $studentIdCardDetails = new StudentIdCardInfo();
                        
                            // Assigning request data to model
                            $studentIdCardDetails->name = $request->name;
                            $studentIdCardDetails->stude_id = $request->stude_id;
                            $studentIdCardDetails->technology = $request->technology;
                            $studentIdCardDetails->date_of_joining = $request->date_of_joining;
                            $studentIdCardDetails->contact_details = $request->contact_details;
                            $studentIdCardDetails->blood_group = $request->blood_group;
                            $studentIdCardDetails->shirt_size = $request->shirt_size;
                            $studentIdCardDetails->save();
                            $last_insert_id = $studentIdCardDetails->id;
                       // Handle the review image (base64)
 
                            return response()->json(['status' => 'Success', 'message' => 'Intern ID Card Details Added Successfully', 'Statuscode' => '200']); 
                    }

                    catch (exception $e) {
                        return response()->json(['status' => 'error', 'message' => 'Intern ID Card Details not added', 'error' => $e->getMessage()],500);
                    }
            }
    }    


        public function getPerticularIdCardInfo($id)
    {
         
        $student_info = StudentIdCardInfo::leftJoin('student_info', 'student_id_card_info.stude_id', '=', 'student_info.id')
            ->leftJoin('student_internship_details', 'student_info.id', '=', 'student_internship_details.stude_id')
            ->where('student_id_card_info.id', $id)
            ->where('student_id_card_info.is_deleted', 0)
            ->select(
                'student_id_card_info.id',
                'student_info.fname',
                'student_info.mname',
                'student_info.fathername',
                'student_info.lname',
                'student_internship_details.technology_name',
                'date_of_joining',
                'student_id_card_info.contact_details',
                'student_id_card_info.shirt_size',
                'student_id_card_info.is_active',
                'student_id_card_info.is_deleted',
                'student_id_card_info.created_at',
                'student_id_card_info.updated_at',
            )
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