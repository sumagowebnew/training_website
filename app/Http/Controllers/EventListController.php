<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\EventList;
use Validator;

class EventListController extends Controller
{
    public function index(Request $request)
    {
        $all_data = EventList::get();
        $response = [];

        foreach ($all_data as $item) {
            $data = $item->toArray();
            $data['table_name'] = 'event_list';

            $response[] = $data;
        }
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
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
                    $news = new EventList();
                    
                    // Check if there are any existing records
                    $existingRecord = EventList::first();
                    
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
        $count = EventList::find($id);
        $count->title = $request->title;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }
    public function delete($id)
    {
        $all_data=[];
        $certificate = EventList::find($id);
        $certificate->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}