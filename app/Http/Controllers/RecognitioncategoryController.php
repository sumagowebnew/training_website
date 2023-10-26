<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Recognitioncategory;
use Validator;

class RecognitioncategoryController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Recognitioncategory::get();
        $response = [];
        foreach ($all_data as $item) {
            $data = $item->toArray();
            $image = $item['image'];
            $imagePath =str_replace('\\', '/', base_path())."/storage/all_web_data/images/recognisationcategory/" . $image;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64; 
            $data['table_name'] = 'recognitioncategory';
            $response[] = $data;
        }
            
        return response()->json(['data'=>$response,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }


    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
        
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $news = new Recognitioncategory();
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < 18; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
            
                    $img_path = $request->image;

                    createDirecrotory('/all_web_data/images/recognisationcategory/');
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/recognisationcategory/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
                    $file = $randomString . '.' . $imageType;
                    $file_dir = $folderPath.$file;
                    file_put_contents($file_dir, $image_base64);

                    $news->image = $file;
                    $news->title = $request->title;
              
                    $news->save();
            
                    return response()->json(['status' => 'Success', 'message' => 'Added successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
    }
    public function update(Request $request, $id)
    {
        $count = Recognitioncategory::find($id);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $img_path = $request->image;

        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/recognisationcategory/";
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);
        $file = $randomString . '.' . $imageType;
        $file_dir = $folderPath.$file;
        file_put_contents($file_dir, $image_base64);

        $count->image = $file;
        $count->title = $request->title;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }
    public function delete($id)
    {
        $all_data=[];
        $certificate = Recognitioncategory::find($id);
        $certificate->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}