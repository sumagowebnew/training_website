<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\NewsLetter;
use Validator;

class NewsLetterController extends Controller
{
    public function index(Request $request)
    {
        $certificate = NewsLetter::get();
        $response = [];
        foreach ($certificate as $item) {
            $data = $item->toArray();
            $logo = $data['file'];
            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/newsletterpdf/" . $logo;

            $base64 = "data:application/pdf;base64," . base64_encode(file_get_contents($imagePath));

            $data['file'] = $base64;
           
            $response[] = $data;
        }
        return response()->json($response);
    }


    public function getAllDataList(Request $request)
    {
        $certificate = NewsLetter::get();
        $response = [];
        foreach ($certificate as $item) {
            $data = $item->toArray();
            $logo = $data['file'];
            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/newsletterpdf/" . $logo;

            $base64 = "data:application/pdf;base64," . base64_encode(file_get_contents($imagePath));

            // $data['file'] = $base64;
           
            $response[] = $data;
        }
        return response()->json(['data'=>$response, 'status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
        
    }

    public function Add(Request $request)
{
    $validator = Validator::make($request->all(), [
        'file' => 'required',
    ]);

    if ($validator->fails()) {
        return $validator->errors()->all();
    } else {
        try {
            $file = $request->file;
            $pdf = new NewsLetter();

            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            createDirecrotory('/all_web_data/images/newsletterpdf/');
            $folderPath = str_replace('\\', '/', storage_path()) . "/all_web_data/images/newsletterpdf/";

            $base64Image = explode(";base64,", $file);
            $explodeImage = explode("application/", $base64Image[0]);
            $fileType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);

            $file = $randomString . '.' . $fileType;
            $file_dir = $folderPath . $file;

            file_put_contents($file_dir, $image_base64);
            $pdf->file = $file;

            $pdf->save();

            return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully', 'statusCode' => '200']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}




    public function Update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            // 'file' => 'required|file|mimes:pdf|max:20480|min:1',
            'file' => 'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $pdf = NewsLetter::find($id);
                    $file = $request->file;
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < 18; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                        createDirecrotory('/all_web_data/images/newsletterpdf/');
                        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/newsletterpdf/";

                            
                        $base64Image = explode(";base64,", $file);
                        $explodeImage = explode("file/", $base64Image[0]);
                        $fileType = $explodeImage[1];
                        $image_base64 = base64_decode($base64Image[1]);
                
                        $file = $randomString . '.' . $fileType;
                        $file_dir = $folderPath.$file;
                
                        file_put_contents($file_dir, $image_base64);
                           $pdf->file      = $file;
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
        $syllabus = NewsLetter::find($id);
        $syllabus->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}