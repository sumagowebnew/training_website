<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\BannerImages;
use Illuminate\Support\Facades\Storage;


use Validator;

class BannerImagesController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $banner = BannerImages::get();

        $response = [];

        foreach ($banner as $item) {
            $data = $item->toArray();

            $logo = $data['images'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/bannerImages/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['images'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function view($id)
    {
        // Get all data from the database
        $banner = BannerImages::Where('event_id', $id)->get();

        $response = [];

        foreach ($banner as $item) {
            $data = $item->toArray();

            $logo = $data['images'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/bannerImages/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['images'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images'=>'required',
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                    $BannerImages = new BannerImages();
            
            // Check if there are any existing records
                    $existingRecord = BannerImages::first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $imageDataArray = $request->input('images');
                   
                    // foreach ($imageDataArray as $imageData) {
                    //     // Decode the base64 image data
                    //     $decodedImage = base64_decode($imageData);
            
                    //     // Generate a unique file name for the image
                    //     $fileName = uniqid() . '.jpg';
            
                    //     // Store the image in a directory (e.g., public/storage/images)
                    //     Storage::disk('public')->put('uploads/events/' . $fileName, $decodedImage);
            
                    //     // Create a new image record in the database
                    //     $image = new EventDetails();
                    //     $image->images = $fileName;
                    //     $image->event_id = $request->event_id;
                    //     $image->name = $request->name;
                    //     $image->save();
                    // }/

                            $i=0;
                            foreach($imageDataArray as $name)
                            {

                                list($type, $name) = explode(';', $name);
                                list(, $name)      = explode(',', $name);
                                $data = base64_decode($name);
                                $i +=1;

                                $imagename= 'Image'.$i.'.jpeg';
                                // $destinationPath = public_path('images');
                                $path = str_replace('\\', '/', base_path()) ."/uploads/bannerImages/".$imagename;
                                $res = file_put_contents($path, $data);

                                // Create a new image record in the database
                                    $image = new BannerImages();
                                    $image->images = $imagename;
                                    $image->save();

                            }
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $existingRecord = BannerImages::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image;
        $folderPath = str_replace('\\', '/', base_path()) ."/uploads/bannerImages/";
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $courses = BannerImages::find($id);
        $courses->images = $file;
      
        $update_data = $courses->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $courses = BannerImages::find($id);
        $courses->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}