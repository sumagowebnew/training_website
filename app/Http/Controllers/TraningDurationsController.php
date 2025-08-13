<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\TraningDurations;
use Validator;


class TraningDurationsController extends Controller
{
    public function addDurationDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'duration'=>'required',
            ]);
            
            if ($validator->fails())
            {
                    return response()->json([
                            'status' => 'error',
                            'message' => 'Validation failed',
                            'errors' => $validator->errors(),
                            'statusCode' => 422
                        ], 422);
        
            }else{
                    date_default_timezone_set('Asia/Kolkata');

                    $new_certificate = new TraningDurations();
                    $new_certificate->duration = $request->get('duration');
                    $new_certificate->save();
            
                    return response()->json(['status' => 'Success', 'message' => 'Duration Saved successfully','statusCode'=>'200']);
                } 
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function getDurationList(Request $request)
    { 
        try {
             $duration = TraningDurations::get();
            return response()->json(['data'=>$duration,'status' => 'Success', 'message' => 'Data Fetched Successfully','StatusCode'=>'200']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
       
    }
    
    public function getDurationSingleDetails(Request $request)
    { 
        try {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            
            if ($validator->fails())
            {
                    return response()->json([
                                    'status' => 'error',
                                    'message' => 'Validation failed',
                                    'errors' => $validator->errors(),
                                    'statusCode' => 422
                                ], 422);
        
            }else{

             $duration = TraningDurations::where('id',$request->get('id') )->first();
            return response()->json(['data'=>$duration,'status' => 'Success', 'message' => 'Data Fetched Successfully','StatusCode'=>'200']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
       
    }

    public function updateDurationDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
                'duration'=>'required',
            ]);
            
            if ($validator->fails())
            {
                    return response()->json([
                                'status' => 'error',
                                'message' => 'Validation failed',
                                'errors' => $validator->errors(),
                                'statusCode' => 422
                            ], 422);
        
            }else{

                TraningDurations::where('id',$request->id )->update([
                                                            'duration'=>$request->duration,
                                                        ]);

                return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);

            } 
        }  catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


   
}