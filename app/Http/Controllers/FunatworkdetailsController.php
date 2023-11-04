<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Funatworkdetails;
use Validator;

class FunatworkdetailsController extends Controller
{
    public function index(Request $request)
    {
        // $funatworkdetails = Funatworkdetails::where('course_id',$request->id)->get();
        $funatworkdetails = Funatworkdetails::join('funatworkcategory', 'funatworkcategory.id', '=', 'funatworkdetails.funatworkcategoryid')
        ->get(['funatworkdetails.*', 'funatworkcategory.title AS category_name']);
        $response = [];

        foreach ($funatworkdetails as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/funatworkdetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;


            $data['table_name'] = 'funatworkdetails';

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function get_funatworkdetails(Request $request,$id)
    {
        // $funatworkdetails = Funatworkdetails::where('funatworkcategoryid',$id)->get();
        $funatworkdetails = Funatworkdetails::join('funatworkcategory', 'funatworkcategory.id', '=', 'funatworkdetails.funatworkcategoryid')
        ->where('funatworkdetails.funatworkcategoryid',$id)->get(['funatworkdetails.*', 'funatworkcategory.title AS category_name']);

        $response = [];

        foreach ($funatworkdetails as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/funatworkdetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;
            $data['table_name'] = 'funatworkdetails';

            

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
                    $funatworkdetails = new Funatworkdetails();
                    
                    // Check if there are any existing records
                    $existingRecord = Funatworkdetails::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $title = $request->title;
                    $img_path = $request->image;
                    createDirecrotory('/all_web_data/images/funatworkdetails/');
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/funatworkdetails/";
                    
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                    $funatworkdetails->image = $file;
                    $funatworkdetails->funatworkcategoryid = $request->funatworkcategoryid;
                    $funatworkdetails->title = $request->title;
                    $funatworkdetails->description = $request->description;
                    // $funatworkdetails->course_id = 001;
                    $funatworkdetails->save();
            
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
                    $funatwork = Funatworkdetails::find($id);
                    
                    // Check if there are any existing records
                    $existingRecord = Funatworkdetails::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $title = $request->title;
                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/funatworkdetails/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                    $funatwork->image = $file;
                    $funatwork->funatworkcategoryid = $request->funatworkcategoryid;
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
        $funatworkdetails = Funatworkdetails::find($id);
        $funatworkdetails->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}