<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\ExpertReview;
use Validator;

class ExpertReviewController extends Controller
{
    public function index(Request $request)
    {
        $expertReview = ExpertReview::get();

        $response = [];

        foreach ($expertReview as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/expert_review/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'=>'required',
            'review'=>'required',
            'name'=>'required',
            'company_position'=>'required',

            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $news = new ExpertReview();
                    
                    // Check if there are any existing records
                    $existingRecord = ExpertReview::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $title = $request->title;
                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', base_path()) ."/uploads/expert_review/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                    $news->image = $file;
                    $news->review = $request->review;
                    $news->name = $request->name;
                    $news->company_position = $request->company_position;
                    $news->save();
            
                    return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
    }

    public function update(Request $request, $id)
    {
        $existingRecord = ExpertReview::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image;
        $folderPath = str_replace('\\', '/', base_path()) ."/uploads/expert_review/";
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;
        $courses = ExpertReview::find($id);
        $courses->image = $file;
        $courses->name = $request->name;
        $courses->review = $request->review;
        $courses->company_position = $request->company_position;

        $update_data = $courses->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = ExpertReview::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}