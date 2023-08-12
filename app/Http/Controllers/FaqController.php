<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Faq;
use Validator;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Faq::where('course_id',$request->id)->get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }

    public function all_faq(Request $request)
    {
        $all_data = Faq::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id'=>'required',
            'question'=>'required',
            'answer'=>'required',
            ]);
        
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                try {
                    $news = new Faq();
                    
                    // Check if there are any existing records
                    $existingRecord = Faq::first();
                    $news->course_id = $request->course_id;
                    $news->question = $request->question;
                    $news->answer = $request->answer;
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
        $count = Faq::find($id);
        $count->question = $request->question;
        $count->answer = $request->answer;
        $count->course_id = $request->course_id;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }
    public function delete($id)
    {
        $all_data=[];
        $certificate = Faq::find($id);
        $certificate->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}