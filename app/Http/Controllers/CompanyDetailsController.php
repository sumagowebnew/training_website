<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class CompanyDetailsController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no'=>'required',
            'email_id'=>'required',
            'address' => 'required',
            'image'=>'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $existingRecord = CompanyDetails::orderBy('id','DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
    
            $image = $request->image;
            createDirecrotory('/all_web_data/images/companyDetails/');
            $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/companyDetails/";
            
            $base64Image = explode(";base64,", $image);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);
    
            $file = $recordId . '.' . $imageType;
            $file_dir = $folderPath.$file;
    
            file_put_contents($file_dir, $image_base64);
            $contactDetails = new CompanyDetails();
            $contactDetails->image = $file;
            $contactDetails->mobile_no = $request->mobile_no;
            $contactDetails->email_id = $request->email_id;
            $contactDetails->address = $request->address;
            $contactDetails->save();
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no'=>'required',
            'email_id'=>'required',
            'address' => 'required',
            'image'=>'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
        $image = $request->image;
        createDirecrotory('/all_web_data/images/companyDetails/');
        $folderPath = str_replace('\\', '/', storage_path()) ."/all_web_data/images/companyDetails/";
        
        $base64Image = explode(";base64,", $image);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $id.'_updated' . '.' . $imageType;
        $file_dir = $folderPath.$file;

        file_put_contents($file_dir, $image_base64);
            $contact_details = CompanyDetails::find($id);
            $contact_details->mobile_no = $request->mobile_no;
            $contact_details->email_id = $request->email_id;
            $contact_details->address = $request->address;
            $update_data = $contact_details->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }

    }

    public function index()
    {
        // Get all data from the database
        $award = CompanyDetails::get();

        $response = [];

        foreach ($award as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/companyDetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_delete = CompanyDetails::find($id);
        $Contact_delete->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);

    }


}
