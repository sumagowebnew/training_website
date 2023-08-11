<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\PopularCourses;
use Validator;

class PopularCoursesController extends Controller
{
    public function index(Request $request)
    {
        $popularCourses = PopularCourses::get();

        $response = [];

        foreach ($popularCourses as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/popularcourses/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                    $existingRecord = PopularCourses::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            
                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', base_path()) ."/uploads/popularcourses/";
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath . $file;
            
                    file_put_contents($file_dir, $image_base64);
                        $courses = new PopularCourses();
                        $courses->image = $file;
                        $courses->name = $request->name;
                        $courses->price = $request->price;
                        $courses->enrolled_students = $request->enrolled_students;
                        $courses->info = $request->info;


                        $courses->save();
                        // $insert_data = courses::insert($data);
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $existingRecord = PopularCourses::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image;
        $folderPath = str_replace('\\', '/', base_path()) ."/uploads/popularcourses/";
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;
        $courses = PopularCourses::find($id);
        $courses->image = $file;
        $courses->name = $request->name;
        $courses->price = $request->price;
        $courses->enrolled_students = $request->enrolled_students;
        $courses->info = $request->info;

        $update_data = $courses->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $courses = PopularCourses::find($id);
        $courses->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}