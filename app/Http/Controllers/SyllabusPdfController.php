<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\SyllabusPdf;
use Validator;

class SyllabusPdfController extends Controller
{
    public function index(Request $request)
    {
        $certificate = SyllabusPdf::where('subcourse_id',$request->id)->get();
        $response = [];
        foreach ($certificate as $item) {
            $data = $item->toArray();
            $logo = $data['image'];
            $imagePath =str_replace('\\', '/', base_path())."/uploads/certificate/" . $logo;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64;
            $response[] = $data;
        }
        return response()->json($response);
    }

    public function all_certificate(Request $request)
    {
        $certificate = SyllabusPdf::get();
        $response = [];
        foreach ($certificate as $item) {
            $data = $item->toArray();
            $logo = $data['image'];
            $imagePath =str_replace('\\', '/', base_path())."/uploads/certificate/" . $logo;
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
        
            'subcourse_id'=>'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $news = new SyllabusPdf();
                    
                    $existingRecord = Logo::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            
                    $file = $request->file;
                    createDirecrotory('/all_web_data/images/syllabus_files/');
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/syllabus_files/";
            
                    $file = $recordId . '.pdf';
                    $file_dir = $folderPath.$file;
            
                    file_put_contents($file_dir, $image_base64);
                    $news->file = $request->file;
                    $news->description = $request->description;
                    $news->subcourse_id = $request->subcourse_id;
                    $news->save();
            
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
            'subcourse_id'=>'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $news = SyllabusPdf::find($id);
                    
                    // Check if there are any existing records
                    $existingRecord = SyllabusPdf::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $title = $request->title;
                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', base_path()) ."/uploads/certificate/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                    $news->image = $file;
                    $news->title = $request->title;
                    $news->description = $request->description;
                    $news->subcourse_id = $request->subcourse_id;
                    $news->update();
            
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
        $certificate = SyllabusPdf::find($id);
        $certificate->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}