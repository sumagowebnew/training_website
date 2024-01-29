<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\NewsLetter;
use Validator;

class NewsLetterController extends Controller
{
    // public function index(Request $request)
    // {
    //     $certificate = NewsLetter::get();
    //     $response = [];
    //     foreach ($certificate as $item) {
    //         $data = $item->toArray();
    //         $logo = $data['file'];
    //         $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/newsletterpdf/" . $logo;
    //         $imagePath1 =str_replace('\\', '/', storage_path())."/all_web_data/images/newsletter/" . $logo;
    //         $base64 = "data:application/pdf;base64," . base64_encode(file_get_contents($imagePath, $imagePath1));

    //         $data['file'] = $base64;
           
    //         $response[] = $data;
    //     }
    //     return response()->json($response);
    // }

    public function index(Request $request)
    {
        $certificates = NewsLetter::get();
        $response = [];
        $fileViewPath = env('FILE_VIEW');
        foreach ($certificates as $certificate) {
            $data = $certificate->toArray();
            $logo = $data['file'];
            $logo1 = $data['image'];
            
            // $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/newsletterpdf/" . $logo;
                   $imagePath = str_replace('\\', '/', $fileViewPath."/all_web_data/images/newsletterpdf/" . $logo);
                   $imagePath1 =str_replace('\\', '/', storage_path())."/all_web_data/images/newsletter/" . $logo1;
        
            if (file_exists($imagePath1)) {
                // $base64Pdf = "data:application/pdf;base64," . base64_encode(file_get_contents($imagePath));
    
                $base64Image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath1));
    
    
                $data['file'] = $imagePath;
                $data['image'] = $base64Image;
    
                $response[] = $data;
            } else {
                // Handle the case when the file does not exist
                // You may want to log an error or take appropriate action
            }
        }
    
        return response()->json($response);
    }



  public function getAllDataList(Request $request)
{
    $certificates = NewsLetter::get();
    $response = [];

    foreach ($certificates as $certificate) {
        $data = $certificate->toArray();
        $logo = $data['file'];
        $logo1 = $data['image'];
        $imagePath = str_replace('\\', '/', storage_path("all_web_data/images/newsletterpdf/{$logo}"));

        $imagePath1 =str_replace('\\', '/', storage_path())."/all_web_data/images/newsletter/" . $logo1;

       

        if (file_exists($imagePath) && file_exists($imagePath1)) {
            $base64Pdf = "data:application/pdf;base64," . base64_encode(file_get_contents($imagePath));

            $base64Image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath1));


            $data['file'] = $base64Pdf;
            $data['image'] = $base64Image;

            $response[] = $data;
        } else {
            // Handle the case when the file does not exist
            // You may want to log an error or take appropriate action
        }
    }

    return response()->json(['data'=>$response, 'status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
}


//     public function Add(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'file' => 'required',
//     ]);

//     if ($validator->fails()) {
//         return $validator->errors()->all();
//     } else {
//         try {
//             $file = $request->file;
//             $pdf = new NewsLetter();

//             $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
//             $charactersLength = strlen($characters);
//             $randomString = '';
//             for ($i = 0; $i < 18; $i++) {
//                 $randomString .= $characters[rand(0, $charactersLength - 1)];
//             }
//             createDirecrotory('/all_web_data/images/newsletterpdf/');
//             $folderPath = str_replace('\\', '/', storage_path()) . "/all_web_data/images/newsletterpdf/";

//             $base64Image = explode(";base64,", $file);
//             $explodeImage = explode("application/", $base64Image[0]);
//             $fileType = $explodeImage[1];
//             $image_base64 = base64_decode($base64Image[1]);

//             $file = $randomString . '.' . $fileType;
//             $file_dir = $folderPath . $file;

//             file_put_contents($file_dir, $image_base64);
//             $pdf->file = $file;

//             $pdf->save();

//             return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully', 'statusCode' => '200']);
//         } catch (Exception $e) {
//             return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
//         }
//     }
// }

public function add(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'image' => 'required',
            'newsletter_month' => 'required',
            'newsletter_year' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validator->errors()->all()], 400);
        }

        $file = $request->file;
        $newsletter_month = $request->newsletter_month;
        $newsletter_year = $request->newsletter_year;

        $news = new NewsLetter();
        $news->newsletter_month = $newsletter_month; 
        $news->newsletter_year = $newsletter_year; 

        // Image handling
        $existingRecord = NewsLetter::orderBy('id', 'DESC')->first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image;
        $folderPathImage = str_replace('\\', '/', storage_path()) . "/all_web_data/images/newsletter/";
        $base64Image = explode(";base64,", $img_path);

        if (count($base64Image) < 2) {
            throw new \Exception('Invalid image format');
        }

        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPathImage . $file;

        file_put_contents($file_dir, $image_base64);
        $news->image = $file;

        // PDF handling
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        createDirecrotory('/all_web_data/images/newsletterpdf/');
        $folderPathPdf = str_replace('\\', '/', storage_path()) ."/all_web_data/images/newsletterpdf/";

        $base64File = explode(";base64,", $request->file);

        if (count($base64File) < 2) {
            throw new \Exception('Invalid file format');
        }

        $explodeFile = explode("application/", $base64File[0]);
        $fileType = $explodeFile[1];
        $file_base64 = base64_decode($base64File[1]);

        $file = $randomString . '.' . $fileType;
        $file_dir = $folderPathPdf . $file;

        file_put_contents($file_dir, $file_base64);
        $news->file = $file;

        $news->save();

        return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully', 'statusCode' => 200]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}

public function update(Request $request,$id)
{
    $fileViewPath = env('FILE_VIEW');
    $validator = Validator::make($request->all(), [
        'image'=>'required',
        ]);
    
        if ($validator->fails())
        {
                return $validator->errors()->all();
    
        }else{
            try {
                $funatwork = NewsLetter::find($id);
                
                // Check if there are any existing records
                $existingRecord = NewsLetter::orderBy('id','DESC')->first();
                $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                $title = $request->title;
                $img_path = $request->image;
                $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/newsletter/";
                // $imagePath = str_replace('\\', '/', $fileViewPath."/all_web_data/images/newsletterpdf/" . $img_path);
                // print_r($imagePath);
                // die();
                $base64Image = explode(";base64,", $img_path);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);
        
                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath . $file;
        
                file_put_contents($file_dir, $image_base64);
                $funatwork->image = $file;                 
                // $funatwork->course_id = 001;
                $funatwork->update();
        
                return response()->json(['status' => 'Success', 'message' => 'Updated successfully','statusCode'=>'200']);
            } 
            catch (Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
}
// public function update(Request $request)
// {
//     try {
//         $validator = Validator::make($request->all(), [
//             'file' => 'required',
//             'image' => 'required',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['status' => 'Error', 'message' => $validator->errors()->all()], 400);
//         }

//         $file = $request->file;
//         $news = new find($id);

//         // Image handling
//         $existingRecord = NewsLetter::orderBy('id', 'DESC')->first();
//         $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

//         $img_path = $request->image;
//         $folderPathImage = str_replace('\\', '/', storage_path()) . "/all_web_data/images/newsletter/";
//         $base64Image = explode(";base64,", $img_path);

//         if (count($base64Image) < 2) {
//             throw new \Exception('Invalid image format');
//         }

//         $explodeImage = explode("image/", $base64Image[0]);
//         $imageType = $explodeImage[1];
//         $image_base64 = base64_decode($base64Image[1]);

//         $file = $recordId . '.' . $imageType;
//         $file_dir = $folderPathImage . $file;

//         file_put_contents($file_dir, $image_base64);
//         $news->image = $file;

//         // PDF handling
//         $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
//         $charactersLength = strlen($characters);
//         $randomString = '';

//         for ($i = 0; $i < 18; $i++) {
//             $randomString .= $characters[rand(0, $charactersLength - 1)];
//         }
//         createDirecrotory('/all_web_data/images/newsletterpdf/');
//         $folderPathPdf = str_replace('\\', '/', storage_path()) ."/all_web_data/images/newsletterpdf/";

//         $base64File = explode(";base64,", $request->file);

//         if (count($base64File) < 2) {
//             throw new \Exception('Invalid file format');
//         }

//         $explodeFile = explode("application/", $base64File[0]);
//         $fileType = $explodeFile[1];
//         $file_base64 = base64_decode($base64File[1]);

//         $file = $randomString . '.' . $fileType;
//         $file_dir = $folderPathPdf . $file;

//         file_put_contents($file_dir, $file_base64);
//         $news->file = $file;

//         $news->save();

//         return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully', 'statusCode' => 200]);
//     } catch (\Exception $e) {
//         return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
//     }
// }
    // public function Update(Request $request,$id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         // 'file' => 'required|file|mimes:pdf|max:20480|min:1',
    //         // 'file' => 'required',
    //         ]);
        
    //         if ($validator->fails())
    //         {
    //                 return $validator->errors()->all();
        
    //         }else{
    //             try {
    //                 $pdf = NewsLetter::find($id);
    //                 $file = $request->file;
    //                 $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    //                     $charactersLength = strlen($characters);
    //                     $randomString = '';
    //                     for ($i = 0; $i < 18; $i++) {
    //                         $randomString .= $characters[rand(0, $charactersLength - 1)];
    //                     }
    //                     createDirecrotory('/all_web_data/images/newsletterpdf/');
    //                     $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/newsletterpdf/";

                            
    //                     $base64Image = explode(";base64,", $file);
    //                     $explodeImage = explode("file/", $base64Image[0]);
    //                     $fileType = $explodeImage[1];
    //                     $image_base64 = base64_decode($base64Image[1]);
                
    //                     $file = $randomString . '.' . $fileType;
    //                     $file_dir = $folderPath.$file;
                
    //                     file_put_contents($file_dir, $image_base64);
    //                        $pdf->file      = $file;
    //                 $pdf->update();
            
    //                 return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
    //             } 
    //             catch (Exception $e) {
    //                 return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    //             }
    //         }
    // }
    public function delete($id)
    {
        $all_data=[];
        $syllabus = NewsLetter::find($id);
        $syllabus->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}