<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Recognitiondetails;
use Validator;

class RecognitiondetailsController extends Controller
{
    public function index(Request $request)
    {
        // $recognitiondetails = Recognitiondetails::where('course_id',$request->id)->get();
        // $recognitiondetails = Recognitiondetails::get();
        $recognitiondetails = Recognitiondetails::join('recognitioncategory', 'recognitioncategory.id', '=', 'recognitiondetails.recognitioncategoryid')
        ->get(['recognitiondetails.*', 'recognitioncategory.title AS category_name']);

        $response = [];

        foreach ($recognitiondetails as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/recognitiondetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $data['table_name'] = 'recognitiondetails';


            $response[] = $data;
        }

        return response()->json($response);
    }

    public function get_recognitiondetails(Request $request,$id)
    {
        // $recognitiondetails = Recognitiondetails::where('recognitioncategoryid',$id)->get();
        $recognitiondetails = Recognitiondetails::join('recognitioncategory', 'recognitioncategory.id', '=', 'recognitiondetails.recognitioncategoryid')
        ->where('recognitiondetails.recognitioncategoryid',$id)->orderBy('recognitiondetails.id', 'desc')->get(['recognitiondetails.*', 'recognitioncategory.title AS category_name']);


     
        $response = [];

        foreach ($recognitiondetails as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/recognitiondetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;
            $data['table_name'] = 'recognitiondetails';

            

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'=>'required',
            'title'=>'required',
            'description'=>'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $recognitiondetails = new Recognitiondetails();
                    
                    // Check if there are any existing records
                    $existingRecord = Recognitiondetails::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $title = $request->title;
                    $img_path = $request->image;
                    createDirecrotory('/all_web_data/images/recognitiondetails/');
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/recognitiondetails/";
                    
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                    $recognitiondetails->image = $file;
                    $recognitiondetails->recognitioncategoryid = $request->recognitioncategoryid;
                    $recognitiondetails->title = $request->title;
                    $recognitiondetails->description = $request->description;
                    // $recognitiondetails->course_id = 001;
                    $recognitiondetails->save();
            
                    return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
    }

    public function Update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'image'=>'required',
            'title'=>'required',
            'description'=>'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $funatwork = Recognitiondetails::find($id);
                    
                    // Check if there are any existing records
                    $existingRecord = Recognitiondetails::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $title = $request->title;
                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/recognitiondetails/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                    $funatwork->image = $file;
                    $funatwork->recognitioncategoryid = $request->recognitioncategoryid;
                    $funatwork->title = $request->title;
                    $funatwork->description = $request->description;
                    // $funatwork->course_id = 001;
                    $funatwork->update();
            
                    return response()->json(['status' => 'Success', 'message' => 'Updated successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
    }
    public function delete($id)
    {
        $all_data=[];
        $recognitiondetails = Recognitiondetails::find($id);
        $recognitiondetails->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}