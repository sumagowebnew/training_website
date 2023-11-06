<?php

namespace App\Http\Controllers;

use App\Models\OurOffice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class OurOfficeController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'description'=>'required',
            'link' => 'required',
            'mobile_no' => 'required',
            'email' => 'required',
            'image' => 'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $existingRecord = OurOffice::orderBy('id','DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
    
            $image = $request->image;
            createDirecrotory('/all_web_data/images/ourOffice/');
            $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/ourOffice/";
            
            $base64Image = explode(";base64,", $image);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);
    
            $file = $recordId . '.' . $imageType;
            $file_dir = $folderPath.$file;
    
            file_put_contents($file_dir, $image_base64);
            $contactDetails = new OurOffice();
            $contactDetails->image = $file;
            $contactDetails->title = $request->title;
            $contactDetails->description = $request->description;
            $contactDetails->link = $request->link;
            $contactDetails->mobile_no = $request->mobile_no;
            $contactDetails->email = $request->email;
            $contactDetails->save();
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'description'=>'required',
            'link' => 'required',
            'mobile_no' => 'required',
            'email' => 'required',
            'image' => 'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
        $image = $request->image;
        createDirecrotory('/all_web_data/images/ourOffice/');
        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/ourOffice/";
        
        $base64Image = explode(";base64,", $image);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $id.'_updated' . '.' . $imageType;
        $file_dir = $folderPath.$file;

        file_put_contents($file_dir, $image_base64);
            $contact_details = OurOffice::find($id);
            $contact_details->title = $request->title;
            $contact_details->description = $request->description;
            $contact_details->link = $request->link;
            $contact_details->mobile_no = $request->mobile_no;
            $contact_details->email = $request->email;
            $update_data = $contact_details->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }

    }

    public function index()
    {
        // Get all data from the database
        $award = OurOffice::get();

        $response = [];

        foreach ($award as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/ourOffice/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;
            $data['table_name'] = 'our_office';

            
            $response[] = $data;
        }

        return response()->json($response);
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_delete = OurOffice::find($id);
        $Contact_delete->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);

    }


}
