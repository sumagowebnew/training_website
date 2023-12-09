<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Brochure;
use Validator;

class BrochureController extends Controller
{
    public function index(Request $request)
    {
        $all_data = Brochure::get()->toArray();
        return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'contact' => 'required|numeric|digits:10',
            'location' => 'required',
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                        $brochure = new Brochure();
                        $brochure->name = $request->name;
                        $brochure->email = $request->email;
                        $brochure->contact = $request->contact;
                        $brochure->location = $request->location;
                        $brochure->save();
                        // $insert_data = ContactEnquiries::insert($data);
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'contact' => 'required|numeric|digits:10',
            'location' => 'required',
            ]);
        
        if ($validator->fails())
        {
                return $validator->errors()->all();
        }else{

            $brochure = Brochure::find($id);
            $brochure->name = $request->name;
            $brochure->email = $request->email;
            $brochure->contact = $request->contact;
            $brochure->location = $request->location;

            $update_data = $brochure->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }
    }
    public function delete($id)
    {
        $all_data=[];
        $brochure = Brochure::find($id);
        $brochure->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}