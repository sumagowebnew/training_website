<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\CourseCategory;
use Validator;

class CourseCategoryController extends Controller
{
    public function index(Request $request)
    {
        $all_data = CourseCategory::get();
        $response = [];

        foreach ($all_data as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            if(isset($data['image'])){
                $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/courseImage/" . $logo;

                $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
    
                $data['image'] = $base64;

                
    
            }
            $data['table_name'] = 'coursecategory';


            $response[] = $data;
        }

        return response()->json(['data'=>$response,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'image'=>'required|mimes:jpeg,png,jpg|size:2048'
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                        $programs = new CourseCategory();
                        $existingRecord = CourseCategory::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                
                        $image = $request->image;
                        createDirecrotory('/all_web_data/images/courseImage/');
                        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/courseImage/";
                        
                        $base64Image = explode(";base64,", $image);
                        $explodeImage = explode("image/", $base64Image[0]);
                        $imageType = $explodeImage[1];
                        $image_base64 = base64_decode($base64Image[1]);
                
                        $file = $recordId . '.' . $imageType;
                        $file_dir = $folderPath.$file;
                
                        file_put_contents($file_dir, $image_base64);
                
                        $programs->name = $request->name;
                        $programs->image = $file;
                        $programs->save();
                        // $insert_data = programs::insert($data);
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'image'=>'required|mimes:jpeg,png,jpg|size:2048'
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
        }else{
        $count = CourseCategory::find($id);
        $image = $request->image;
        createDirecrotory('/all_web_data/images/courseImage/');
        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/courseImage/";
        
        $base64Image = explode(";base64,", $image);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $id . '_updated.' . $imageType;
        $file_dir = $folderPath.$file;

        file_put_contents($file_dir, $image_base64);
                
        $count->name = $request->name;
        $count->image = $file;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
            }
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = CourseCategory::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}