<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Moudetails;
use Validator;

class MoudetailsController extends Controller
{
    public function index(Request $request)
    {
        // $moudetails = Moudetails::where('course_id',$request->id)->get();
        // $moudetails = Moudetails::get();
        $moudetails = Moudetails::join('moucategory', 'moucategory.id', '=', 'moudetails.moucategoryid')
        ->get(['moudetails.*', 'moucategory.title AS category_name']);

        $response = [];

        foreach ($moudetails as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/moudetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;
            $data['table_name'] = 'moudetails';

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function get_moudetails(Request $request)
    {
        // \DB::enableQueryLog();

        $moudetailshh = Moudetails::join('moucategory', 'moucategory.id', '=', 'moudetails.moucategoryid')
        ->get(['moudetails.*', 'moucategory.title AS category_name']);
        // dd(\DB::getQueryLog());
        $response = [];

        foreach ($moudetailshh as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/moudetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;
            $data['table_name'] = 'moudetails';

            

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
                    $moudetails = new Moudetails();
                    
                    // Check if there are any existing records
                    $existingRecord = Moudetails::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $title = $request->title;
                    $img_path = $request->image;
                    createDirecrotory('/all_web_data/images/moudetails/');
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/moudetails/";
                    
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                    $moudetails->image = $file;
                    $moudetails->moucategoryid = $request->moucategoryid;
                    $moudetails->title = $request->title;
                    $moudetails->description = $request->description;
                    // $moudetails->course_id = 001;
                    $moudetails->save();
            
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
                    $funatwork = Moudetails::find($id);
                    
                    // Check if there are any existing records
                    $existingRecord = Moudetails::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $title = $request->title;
                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/moudetails/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                    $funatwork->image = $file;
                    $funatwork->moucategoryid = $request->moucategoryid;
                    $funatwork->title = $request->title;
                    $funatwork->description = $request->description;
                    // $funatwork->course_id = 001;
                    $funatwork->update();
            
                    return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
    }
    public function delete($id)
    {
        $all_data=[];
        $moudetails = Moudetails::find($id);
        $moudetails->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}