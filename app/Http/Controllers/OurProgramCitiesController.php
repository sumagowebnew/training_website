<?php

namespace App\Http\Controllers;

use App\Models\OurProgramCities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class OurProgramCitiesController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $existingRecord = OurProgramCities::orderBy('id','DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
    
           
            $contactDetails = new OurProgramCities();
            $contactDetails->name = $request->name;
            $contactDetails->save();
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function update(Request $request, $id)
    {
        
            $contact_details = OurProgramCities::find($id);
            $contact_details->name = $request->name;
            $update_data = $contact_details->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);

    }

    public function index()
    {
        // Get all data from the database
        $award = OurProgramCities::get();

        $response = [];

        foreach ($award as $item) {
            $data = $item->toArray();
            $data['table_name'] = 'our_program_cities';
            
            $response[] = $data;
        }

        return response()->json($response);
    }

    public function delete($id)
    {
        $all_data=[];
        $Contact_delete = OurProgramCities::find($id);
        $Contact_delete->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);

    }


}
