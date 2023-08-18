<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Alumini;
use Validator;
use Config;

class AluminiController extends Controller
{

    public function getAllAlumini(Request $request)
    {
        $all_data = Alumini::get();

        $response = [];

        foreach ($all_data as $item) {

            $logo = $item['image'];

            $imagePath =str_replace('\\', '/', base_path())."/storage/all_web_data/images/alumini/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64; 
            $data['designation'] = $item['designation'];
            $data['company'] = $item['company'];
            $data['name'] = $item['name'];
            $data['id'] = $item['id'];

            $response[] = $data;
        }


        return response()->json(['data'=>$response,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }


    public function index(Request $request, $id)
    {
        $all_data = Alumini::where('course_id',$request->id)->get();
        $response = [];

        foreach ($all_data as $item) {

            $logo = $item['image'];

            $imagePath =str_replace('\\', '/', base_path())."/storage/all_web_data/images/alumini/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64; 
            $data['designation'] = $item['designation'];
            $data['company'] = $item['company'];
            $data['name'] = $item['name'];
            $data['id'] = $item['id'];

            $response[] = $data;
        }


        return response()->json(['data'=>$response,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);   
    }
    
    public function all_alumini(Request $request)
    {
        $all_data = Alumini::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'designation'=>'required',
            'company'=>'required',
            'image'=>'required',
            'course_id'=>'required'

            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                    $alumini = new Alumini();
                    $existingRecord = Alumini::orderBy('id','DESC')->first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
            
                    $img_path = $request->image;
                    createDirecrotory('/all_web_data/images/alumini/');
                    $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/alumini/";
                    
                    $base64Image = explode(";base64,", $img_path);
                    $explodeImage = explode("image/", $base64Image[0]);
                    $imageType = $explodeImage[1];
                    $image_base64 = base64_decode($base64Image[1]);
            
                    $file = $recordId . '.' . $imageType;
                    $file_dir = $folderPath.$file;
            
                    file_put_contents($file_dir, $image_base64);
                    $alumini->name = $request->name;
                    $alumini->image = $file;
                    $alumini->designation = $request->designation;
                    $alumini->company = $request->company;
                    $alumini->course_id = $request->course_id;
                    $alumini->save();
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
            'image'=>'required',
            'course_id'=>'required'

            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                $alumini = Alumini::find($id);
                $existingRecord = Alumini::orderBy('id','DESC')->first();

                $img_path = $request->image;
            
                $folderPath = str_replace('\\', '/', base_path()) ."/uploads/alumini/";
                
                $base64Image = explode(";base64,", $img_path);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);

                $file = $id . '.' . $imageType;
                $file_dir = $folderPath.$file;

                file_put_contents($file_dir, $image_base64);
                $alumini->name = $request->name;
                $alumini->image = $file;
                $alumini->designation = $request->designation;
                $alumini->company = $request->company;
                $alumini->course_id = $request->course_id;
                $update_data = $alumini->update();
                return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
            }
            }

    public function delete($id)
    {
        $all_data=[];
        $Contact_enquiries = Alumini::find($id);
        $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}