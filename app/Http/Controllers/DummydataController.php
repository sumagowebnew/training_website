<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Dummydata;
use Illuminate\Support\Facades\Storage;


use Validator;

class DummydataController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Dummydata::get();
        $response = [];
        foreach ($all_data as $item) {
            $data = $item->toArray();
            $logo = $data['image'];
            $imagePath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/dummydata/".$logo;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64;
            $data['table_name'] = 'dummydata';
            $response[] = $data;
        }

        return response()->json($response);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'image'=>'required',
        ]);
        
        if($validator->fails())
        {
                return $validator->errors()->all();
        }else{
               
                $existingRecord = Dummydata::orderBy('id','DESC')->first();
                $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                $image = $request->image;
                createDirecrotory('/all_web_data/images/dummydata/');
                $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/dummydata/";
                $base64Image = explode(";base64,", $image);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);
                $file = $recordId . '.' . $imageType;
                $file_dir = $folderPath.$file;
        
                file_put_contents($file_dir, $image_base64);
                $programs = new Dummydata();
                $programs->image = $file;
                $programs->save();
                return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function update(Request $request, $id)
    {
        $image = $request->image;
        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/dummydata/";
        
        $base64Image = explode(";base64,", $image);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $id.'_updated' . '.' . $imageType;
        $file_dir = $folderPath.$file;

        file_put_contents($file_dir, $image_base64);
            $contact_details = Dummydata::find($id);
            $contact_details->image = $file;
            $update_data = $contact_details->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);

    }
 
    public function delete($id)
    {
        $all_data=[];
        $eventimagepopup = Dummydata::find($id);
        $eventimagepopup->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

    public function change_status($table_name,$id)
    {
        $data = change_active_status($table_name,$id);
        if($data =='false'){
            return response()->json(['status' => 'Success', 'message' => 'Record activated successfully','StatusCode'=>'200']);

        }else{
            return response()->json(['status' => 'Success', 'message' => 'Record dectivated successfully','StatusCode'=>'200']);

        }
    }

   
}