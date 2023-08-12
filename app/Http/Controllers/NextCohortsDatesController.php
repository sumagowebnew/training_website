<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\NextCohortsDates;
use Validator;
use Carbon\Carbon;

class NextCohortsDatesController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = Carbon::now()->format('M d');
      
        $all_data = NextCohortsDates::where('start_date', '>=', $currentDate)
                                    ->orderBy('start_date')
                                    ->get()
                                    ->toArray();
        
        return response()->json([
            'data' => $all_data,
            'status' => 'Success',
            'message' => 'Fetched Data Successfully',
            'StatusCode' => '200'
        ]);
    }
//     public function Add(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'start_time' => 'required',
//         'end_time' => 'required',
//         'batch_name' => 'required',
//     ]);

//     if ($validator->fails()) {
//         return $validator->errors()->all();
//     } else {
//         try {
//             $next_date = new NextCohortsDates();

//             // Calculate the start date as 7 days from today using Carbon
//             $startDate = Carbon::now()->addDays(7);
//             $formattedStartDate = $startDate->format('M d'); // Format the date as "Aug 12"
            
//             // Convert the month name to uppercase
//             $formattedStartDate = strtoupper(substr($formattedStartDate, 0, 3)) . substr($formattedStartDate, 3);

//             $next_date->start_date = $formattedStartDate;

//             $next_date->start_time = $request->start_time;
//             $next_date->end_time = $request->end_time;
//             $next_date->batch_name = $request->batch_name;
//             $next_date->save();

//             return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully', 'statusCode' => '200']);
//         } catch (Exception $e) {
//             return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
//         }
//     }
// }

public function Add(Request $request)
{
    $validator = Validator::make($request->all(), [
        'start_time' => 'required',
        'end_time' => 'required',
        'batch_name' => 'required',
    ]);

    if ($validator->fails()) {
        return $validator->errors()->all();
    } else {
        try {
            // Get the latest entry to determine the next start date
            $latestEntry = NextCohortsDates::latest('start_date')->first();
            $startDate = Carbon::now();

            if ($latestEntry) {
                // Increment the start date by 7 days for each subsequent entry
                $startDate = Carbon::createFromFormat('M d', $latestEntry->start_date)->addDays(7);
            }

            $formattedStartDate = $startDate->format('M d'); // Format the date as "Aug 12"
            $formattedStartDate = strtoupper(substr($formattedStartDate, 0, 3)) . substr($formattedStartDate, 3);

            $next_date = new NextCohortsDates();
            $next_date->start_date = $formattedStartDate;
            $next_date->start_time = $request->start_time;
            $next_date->end_time = $request->end_time;
            $next_date->batch_name = $request->batch_name;
            $next_date->save();

            return response()->json(['status' => 'Success', 'message' => 'Uploaded successfully', 'statusCode' => '200']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

    
    public function update(Request $request, $id)
    {
        $count = NextCohortsDates::find($id);

        // Calculate the start date as 7 days from today using Carbon
        $startDate = Carbon::now()->addDays(7);
        $formattedStartDate = $startDate->format('M d'); // Format the date as "Aug 12"
        
        // Convert the month name to uppercase
        $formattedStartDate = strtoupper(substr($formattedStartDate, 0, 3)) . substr($formattedStartDate, 3);

        $count->start_date = $formattedStartDate;
        $count->start_time = $request->start_time;
        $count->end_time = $request->end_time;
        $count->batch_name = $request->batch_name;

        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }
    public function delete($id)
    {
        $all_data=[];
        $certificate = NextCohortsDates::find($id);
        $certificate->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }
   
}