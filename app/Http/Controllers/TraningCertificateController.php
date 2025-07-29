<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\TraningCertificate;
use Validator;


class TraningCertificateController extends Controller
{
    public function getCertificateList(Request $request)
    {
        try {
            $all_data = TraningCertificate::get();
            return response()->json(['data'=>$all_data,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
        } catch (Exception $e) {
            info ($e->getMessage());
        }

    }

    public function getCertificateValidOrNot(Request $request)
    { 
            
          try {
            $validator = Validator::make($request->all(), [
                'certificate_no'=>'required',
            ]);
            
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                $certficate_data = TraningCertificate::where('certificate_no','=',$request->certificate_no)->get();
                return response()->json(['data'=>$certficate_data,'status' => 'Success', 'message' => 'Fetched Cert All Data Successfully','StatusCode'=>'200']);
            }
        } catch (Exception $e) {
            info ($e->getMessage());
        }

    }

    public function addCertificateDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email_address'=>'required',
                'first_name'=>'required',
                'mother_name'=>'required',
                'father_name'=>'required',
                'surname'=>'required',
                'mobile_no'=>'required',
                'technology_name'=>'required',
                'college_name'=>'required',
                'batch_no'=>'required',
                'training_mode'=>'required',
                'training_location'=>'required',
            ]);
            
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{
                    $new_certificate = new TraningCertificate();

                    $new_certificate->timestamp = date("d/m/Y h:i:sa");
                    $new_certificate->email_address = $request->get('email_address');
                    $new_certificate->first_name = $request->get('first_name');
                    $new_certificate->mother_name = $request->get('mother_name');
                    $new_certificate->father_name = $request->get('father_name');
                    $new_certificate->surname = $request->get('surname');
                    $new_certificate->mobile_no = $request->get('mobile_no');
                    $new_certificate->technology_name = $request->get('technology_name');
                    $new_certificate->college_name = $request->get('college_name');
                    $new_certificate->batch_no = $request->get('batch_no');
                    $new_certificate->training_mode = $request->get('training_mode');
                    $new_certificate->training_location = $request->get('training_location');
                    $new_certificate->certificate_no = date("dmYHis");
                    
                    $new_certificate->save();
            
                    return response()->json(['status' => 'Success', 'message' => 'Data SavedUploaded successfully','statusCode'=>'200']);
                } 
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    
    public function getCertificateDetails(Request $request)
    { 
        try {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{

             $certificate = TraningCertificate::where('id',$request->get('id') )->first();
            return response()->json(['data'=>$certificate,'status' => 'Success', 'message' => 'Certifcate Data Fetched Successfully','StatusCode'=>'200']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
       
    }

    public function updateCertificateDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
                'email_address'=>'required',
                'first_name'=>'required',
                'mother_name'=>'required',
                'father_name'=>'required',
                'surname'=>'required',
                'mobile_no'=>'required',
                'technology_name'=>'required',
                'college_name'=>'required',
                'batch_no'=>'required',
                'training_mode'=>'required',
                'training_location'=>'required',
            ]);
            
            if ($validator->fails())
            {
                    return $validator->errors()->all();
        
            }else{

                $update_certificate = TraningCertificate::where('id',$request->id );
                $update_certificate->email_address = $request->get('email_address');
                $update_certificate->first_name = $request->get('first_name');
                $update_certificate->mother_name = $request->get('mother_name');
                $update_certificate->father_name = $request->get('father_name');
                $update_certificate->surname = $request->get('surname');
                $update_certificate->mobile_no = $request->get('mobile_no');
                $update_certificate->technology_name = $request->get('technology_name');
                $update_certificate->college_name = $request->get('college_name');
                $update_certificate->batch_no = $request->get('batch_no');
                $update_certificate->training_mode = $request->get('training_mode');
                $update_certificate->training_location = $request->get('training_location');
                $update_certificate->save();

                return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);

            } 
        }  catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


   
}