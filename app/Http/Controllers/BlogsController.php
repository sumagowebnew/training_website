<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blogs;
use Validator;
use Illuminate\Support\Facades\Storage;

class BlogsController extends Controller
{
    public function index()
    {
        $blog = Blogs::get();
        $response = [];
        foreach ($blog as $item) {
            $data = $item->toArray();

            $logo = $data["images"];

            $imagePath = str_replace("\\", "/", storage_path())."/all_web_data/images/blogImages/".$logo;

            $base64 ="data:image/png;base64,".base64_encode(file_get_contents($imagePath));

            $data["images"] = $base64;
            $data["table_name"] = "blogs";

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function view(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
        ]);

        if ($validator->fails())
        {
                return response()->json([
                        'status' => 'error',
                        'message' => 'Validation failed',
                        'errors' => $validator->errors(),
                        'statusCode' => 422
                    ], 422);
    
        } else {

            $banner = Blogs::Where("id", $request->id)->get();
            $response = [];
            foreach ($banner as $item) {
                $data = $item->toArray();
                $logo = $data["images"];
                $imagePath = str_replace("\\", "/", base_path())."/uploads/blogImages/".$logo;
                $base64 =  "data:image/png;base64," .base64_encode(file_get_contents($imagePath));
                $data["images"] = $base64;
                $response[] = $data;
            }
        }

        return response()->json($response);
    }
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "description" => "required",
            "images" => "required",
        ]);

        if ($validator->fails())
        {
                return response()->json([
                        'status' => 'error',
                        'message' => 'Validation failed',
                        'errors' => $validator->errors(),
                        'statusCode' => 422
                    ], 422);
    
        } else {
            $blogImages = new Blogs();

            $existingRecord = Blogs::orderBy("id", "DESC")->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

            $i = 0;

            $image = $request->images;
            createDirecrotory("/all_web_data/images/blogImages/");
            $folderPath = str_replace("\\", "/", storage_path())."/all_web_data/images/blogImages/";

            $base64Image = explode(";base64,", $image);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);

            $file = $recordId . "." . $imageType;
            $file_dir = $folderPath . $file;

            file_put_contents($file_dir, $image_base64);

            $image = new Blogs();
            $image->images = $file;
            $image->title = $request->input("title");
            $image->description = $request->input("description");
            $image->save();
            return response()->json([
                "status" => "Success",
                "message" => "Added successfully",
                "StatusCode" => "200",
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [

            "id" => "required",
            "title" => "required",
            "description" => "required",
            "images" => "required",
        ]);

        if ($validator->fails())
        {
                return response()->json([
                        'status' => 'error',
                        'message' => 'Validation failed',
                        'errors' => $validator->errors(),
                        'statusCode' => 422
                    ], 422);
    
        }else {
            $image = $request->images;

            $imageDelete = Blogs::where ('id',$request->id)->first();

            createDirecrotory("/all_web_data/images/blogImages/");
            $folderPath = str_replace("\\", "/", storage_path()) . "/all_web_data/images/blogImages/";

            $fileToDelete = $folderPath . $imageDelete->images; // replace with your file name

            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }

            if (strpos($image, ";base64,") === false) {
                info("Invalid image data");
            }

            list($meta, $data) = explode(";base64,", $image);
            $imageType = explode("image/", $meta)[1] ?? 'png';

            $image_base64 = base64_decode(str_replace(' ', '+', $data));

            if ($image_base64 === false) {
                info("Base64 decode failed");
            }

            $uniqueId = date("YmdHis") . rand(1000, 9999);
            $file = "{$uniqueId}_updated.{$imageType}";
            $file_dir = $folderPath . $file;

            file_put_contents($file_dir, $image_base64);




            $image = Blogs::where ('id',$request->id)->first();
            $image->images = $file;
            $image->title = $request->input("title");
            $image->description = $request->input("description");
            $image->save();
            return response()->json([
                "status" => "Success",
                "message" => "Updated successfully",
                "StatusCode" => "200",
            ]);
        }
    }

    public function delete(Request $request)
    {
         $validator = Validator::make($request->all(), [
            "id" => "required",
        ]);

        if ($validator->fails())
        {
                return response()->json([
                        'status' => 'error',
                        'message' => 'Validation failed',
                        'errors' => $validator->errors(),
                        'statusCode' => 422
                    ], 422);
    
        } else {


            $all_data = [];
            $blog = Blogs::where ('id',$request->id)->first();

            $folderPath = str_replace("\\", "/", storage_path()) . "/all_web_data/images/blogImages/";

            $fileToDelete = $folderPath . $blog->images;

            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }

            $blog->delete();
            return response()->json([
                "status" => "Success",
                "message" => "Deleted successfully",
                "StatusCode" => "200",
            ]);
        }
    }
}
