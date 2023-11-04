<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Module;
use Validator;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Module::get();
        $response = [];

        foreach ($all_data as $item) {
            $data = $item->toArray();
            $data['table_name'] = 'module';
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
                    $news = new Module();
                    
                    // Check if there are any existing records
                    $existingRecord = Module::first();
                    
                    $news->title = $request->title;
                    $news->save();
            
                    return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully','statusCode'=>'200']);
                } 
                catch (Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
        ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
        $count = Module::find($id);
        $count->title = $request->title;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
            }
    }
    public function delete($id)
    {
        $all_data=[];
        $certificate = Module::find($id);
        $certificate->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}