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
        $certificates = NewsLetter::orderBy('created_at', 'desc')->get();
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

public function add(Request $request){
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


public function update(Request $request, $id){
    $validator = Validator::make($request->all(), [
        // 'file'=>'required', // Uncomment this line if you want to validate the file field
        'image'=>'required',
        'newsletter_month' => 'required',
        'newsletter_year' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 'Error', 'message' => $validator->errors()->all()], 400);
    }

    try {
        $alumini = NewsLetter::find($id);

        if (!$alumini) {
            return response()->json(['status' => 'Error', 'message' => 'Record not found'], 404);
        }

        // Handle Image Update
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $img_path = $request->image;
        $folderPathImage = str_replace('\\', '/', storage_path()) . "/all_web_data/images/newsletter/";
        $base64Image = explode(";base64,", $img_path);

        if (count($base64Image) < 2) {
            throw new \Exception('Invalid image format');
        }

        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        // $file = $randomString . '.' . $imageType;
        $file = $alumini->id . '.' . $imageType;
        $file_dir = $folderPathImage . $file;

        // Remove old image file
        if (file_exists($folderPathImage . $alumini->image)) {
            unlink($folderPathImage . $alumini->image);
        }

        // Save new image file
        file_put_contents($file_dir, $image_base64);
        $alumini->image = $file;

        // Handle PDF File Update (Assuming file field is named 'file' in the request)
        if ($request->has('file')) {
            $randomString = '';

            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            createDirecrotory('/all_web_data/images/newsletterpdf/');
            $folderPathPdf = str_replace('\\', '/', storage_path()) . "/all_web_data/images/newsletterpdf/";

            $base64File = explode(";base64,", $request->file);

            if (count($base64File) < 2) {
                throw new \Exception('Invalid file format');
            }

            $explodeFile = explode("application/", $base64File[0]);
            $fileType = $explodeFile[1];
            $file_base64 = base64_decode($base64File[1]);

            // $file = $randomString . '.' . $fileType;
            $file = $alumini->id . '.' . $fileType;
            $file_dir = $folderPathPdf . $file;

            // Remove old PDF file
            if (file_exists($folderPathPdf . $alumini->file)) {
                unlink($folderPathPdf . $alumini->file);
            }

            // Save new PDF file
            file_put_contents($file_dir, $file_base64);
            $alumini->file = $file;
        }

        $alumini->newsletter_month = $request->newsletter_month;
        $alumini->newsletter_year = $request->newsletter_year;
        $alumini->update();

        return response()->json(['status' => 'Success', 'message' => 'Updated successfully', 'StatusCode' => '200']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
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
   

//     public function delete(Request $request)
// {
//     try {
//         $fileViewPath = env('FILE_VIEW');

//         $id = $request->id;
//         $slider = NewsLetter::find($id);

//         if ($slider) {
            
//             $logo = $slider->file; // Replace with the actual field name for the image
//             $logo1 = $slider->image; // Replace with the actual field name for the image
//             $imagePath = $fileViewPath . "/all_web_data/images/newsletterpdf/" . $logo;
//             $imagePath1 = storage_path("all_web_data/images/newsletter/" . $logo1); // Assuming this is the correct storage path

//             // Check if the image files exist and then delete them
//             if (file_exists($imagePath)) {
//                 unlink($imagePath);
//             }

//             if (file_exists($imagePath1)) {
//                 unlink($imagePath1);
//             }

//             $delete = $slider->delete();

//             if ($delete) {
//                 $msg = 'Deleted Successfully.';
//                 $status = 'success';
//             } else {
//                 $msg = 'Not Deleted.';
//                 $status = 'error';
//             }

//             if ($status == 'success') {
//                 return redirect('list-slide')->with(compact('msg', 'status'));
//             } else {
//                 return redirect()->back()->withInput()->with(compact('msg', 'status'));
//             }
//         } else {
//             return redirect()->back()->withInput()->with(['msg' => 'Slider not found.', 'status' => 'error']);
//         }
//     } catch (\Exception $e) {
//         return $e;
//     }
// }
    
   
}