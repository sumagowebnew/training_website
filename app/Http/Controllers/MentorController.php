<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Mentor;
use Validator;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Mentor::whereJsonContains('course_id',$request->id)->get();
        $response = [];
        foreach ($all_data as $item) {
            $temp = [];
            $image = $item['image'];
            if ($image) {   
            $imagePath =str_replace('\\', '/', base_path())."/storage/all_web_data/images/mentor_images/" . $image;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64; 
            }else{
                $data['image']='';
            }
            $course_id = $item['course_id'];
            $data['course_id'] = $course_id;
            foreach($course_id as $course){
                $subcourse = \DB::table('subcourses')->where('id', $course)->first(); 
                array_push($temp,$subcourse->name);                
            }
            $data['subcourse_details'] = $temp;
            $response[] = $data;
        }

        return response()->json(['data' => $response,'status' => 'Success', 'message' => 'Mentors get successfully','StatusCode'=>'200']);

    }   

    public function all_mentors(Request $request)
    {
        $all_data = Mentor::get();
        $response = [];
        foreach ($all_data as $item) {
            $temp = [];
            $image = $item['image'];
            if ($image) {   
            $imagePath =str_replace('\\', '/', base_path())."/storage/all_web_data/images/mentor_images/" . $image;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64; 
            }else{
                $data['image']='';
            }
            $course_id = $item['course_id'];
            $data['course_id'] = $course_id;
            foreach($course_id as $course){
                $subcourse = \DB::table('subcourses')->where('id', $course)->first(); 
                array_push($temp,$subcourse->name);                
            }
            $data['subcourse_details'] = $temp;
            $response[] = $data;
        }
        return response()->json(['data' => $response,'status' => 'Success', 'message' => 'Mentors get successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'designation'=>'required',
            'company'=>'required',
            'skills'=>'required',
            'experience'=>'required',
            // 'image'=>'required',
            'image'=>'required',

            'course_id'=>'required'

            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                        $programs = new Mentor();
                        $existingRecord = Mentor::orderBy('id','DESC')->first();
                        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                
                        $image = $request->image;
                        createDirecrotory('/all_web_data/images/mentor_images/');
                        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/mentor_images/";
                        
                        $base64Image = explode(";base64,", $image);
                        $explodeImage = explode("image/", $base64Image[0]);
                        $imageType = $explodeImage[1];
                        $image_base64 = base64_decode($base64Image[1]);
                
                        $file = $recordId . '.' . $imageType;
                        $file_dir = $folderPath.$file;
                
                        file_put_contents($file_dir, $image_base64);
                        $programs->name = $request->name;
                        $programs->image = $file;
                        $programs->designation = $request->designation;
                        $programs->company = $request->company;
                        $programs->skills = $request->skills;
                        $programs->experience = $request->experience;
                        $programs->course_id = $request->course_id;
                        $programs->save();
                        // $insert_data = programs::insert($data);
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'designation'=>'required',
            'company'=>'required',
            'skills'=>'required',
            'experience'=>'required',
            // 'image'=>'required',
            'image'=>'required',
            'course_id'=>'required'

            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                    $count = Mentor::find($id);
                    $existingRecord = Mentor::orderBy('id','DESC')->first();

                    $img_path = $request->image;
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/mentor_images/";
                    
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);

                    $file = $id . '_updated.' . $imageType;
                    $file_dir = $folderPath.$file;

                    file_put_contents($file_dir, $image_base64);
                    $count->name = $request->name;
                    $count->image = $file;
                    $count->designation = $request->designation;
                    $count->company = $request->company;
                    $count->skills = $request->skills;
                    $count->experience = $request->experience;
                    $count->course_id = $request->course_id;
                    $update_data = $count->update();
                    return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
                }
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = Mentor::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}