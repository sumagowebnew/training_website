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
            $logo = $data['file'];
            $file = str_replace('\\', '/', storage_path()) ."/all_web_data/images/syllabus_pdf/".$data['file'];
            $data['file'] = $file;
            $response[] = $data;
        }
        return response()->json($response);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file'=>'required',
            'subcourse_id'=>'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $pdf = new SyllabusPdf();
                     if(isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"]))
                        {
                            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                            $charactersLength = strlen($characters);
                            $randomString = '';
                            for ($i = 0; $i < 18; $i++) {
                                $randomString .= $characters[rand(0, $charactersLength - 1)];
                            }
                            createDirecrotory('/all_web_data/images/syllabus_pdf/');
                            $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/syllabus_pdf/";
                            $file_name                         = $_FILES["file"]["name"];
                            $file_tmp                          = $_FILES["file"]["tmp_name"];
                            $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                            $random_file_name                  = $randomString.'.'.$ext;
                            $latest_image                      = $folderPath.$random_file_name;
                            if(move_uploaded_file($file_tmp,$latest_image))
                            {
                               $pdf->file      = $random_file_name;
                            }
                        }
                                
                    $pdf->subcourse_id = $request->subcourse_id;
                    $pdf->save();
            
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
            'file'=>'required',
            'subcourse_id'=>'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $pdf = SyllabusPdf::find($id);
                    
                    if(isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"]))
                    {
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < 18; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                        createDirecrotory('/all_web_data/images/syllabus_pdf/');
                        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/syllabus_pdf/";
                        $file_name                         = $_FILES["file"]["name"];
                        $file_tmp                          = $_FILES["file"]["tmp_name"];
                        $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                        $random_file_name                  = $randomString.'.'.$ext;
                        $latest_image                      = $folderPath.$random_file_name;
                        if(move_uploaded_file($file_tmp,$latest_image))
                        {
                           $pdf->file      = $random_file_name;
                        }
                    }
                    $pdf->subcourse_id = $request->subcourse_id;
                    $pdf->update();
            
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
        $syllabus = SyllabusPdf::find($id);
        $syllabus->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}