<?php

namespace App\Http\Controllers;

use App\Models\HandsonProjectCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class HandonProjectControllerController extends Controller
{
    public function addCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $contactDetails = new HandsonProjectCategories();
            $contactDetails->title = $request->title;
            $contactDetails->save();
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function updateCategory(Request $request, $id)
    {
        
            $contact_details = HandsonProjectCategories::find($id);
            $contact_details->title = $request->title;
            $update_data = $contact_details->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);

    }

    public function getCategory()
    {
        // Get all data from the database
        $hands_on_pro = HandsonProjectCategories::get();

        $response = [];

        foreach ($hands_on_pro as $item) {
            $data = $item->toArray();
            $response[] = $data;
        }

        return response()->json($response);
    }

    public function deleteCategory($id)
    {
        $handson_pro_delete = HandsonProjectCategories::find($id);
        $handson_pro_delete->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);

    }


}
