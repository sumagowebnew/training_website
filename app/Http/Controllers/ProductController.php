<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class ProductController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'link' => 'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $existingRecord = Product::orderBy('id','DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
    
           
            $contactDetails = new Product();
            $contactDetails->title = $request->title;
            $contactDetails->link = $request->link;
            $contactDetails->save();
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function update(Request $request, $id)
    {
        
            $contact_details = Product::find($id);
            $contact_details->title = $request->title;
            $contact_details->link = $request->link;
            $update_data = $contact_details->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);

    }

    public function index()
    {
        // Get all data from the database
        $award = Product::get();

        $response = [];

        foreach ($award as $item) {
            $data = $item->toArray();
            $response[] = $data;
        }

        return response()->json($response);
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_delete = Product::find($id);
        $Contact_delete->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);

    }


}
