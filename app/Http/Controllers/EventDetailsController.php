<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\EventDetails;
use  App\Models\EventDetailsImages;
use Illuminate\Support\Facades\Storage;


use Validator;

class EventDetailsController extends Controller
{
    public function index()
    {
        // Get all data from the database
        $eventDetails = EventDetails::get();

        $response = [];

        foreach ($eventDetails as $item) {
            $data = $item->toArray();

            $logo = $data['image'];

            $imagePath =str_replace('\\', '/', base_path())."/uploads/eventDetails/" . $logo;

            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));

            $data['image'] = $base64;

            $response[] = $data;
        }

        return response()->json($response);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id'=>'required',
            'name'=>'required',
            'images'=>'required',
            ]);
        
            if ($validator->fails()) {
                    return $validator->errors()->all();
        
                }else{
                    $events = new EventDetails();
                    $eventDetails = new EventDetails();
            
            // Check if there are any existing records
                    $existingRecord = EventDetails::first();
                    $recordId = $existingRecord ? $existingRecord->id + 1 : 1;
                    $imageDataArray = $request->input('images');
                  
                    // foreach ($imageDataArray as $imageData) {
                    //     // Decode the base64 image data
                    //     $decodedImage = base64_decode($imageData);
            
                    //     // Generate a unique file name for the image
                    //     $fileName = uniqid() . '.jpg';
            
                    //     // Store the image in a directory (e.g., public/storage/images)
                    //     Storage::disk('public')->put('uploads/events/' . $fileName, $decodedImage);
            
                    //     // Create a new image record in the database
                    //     $image = new EventDetails();
                    //     $image->images = $fileName;
                    //     $image->event_id = $request->event_id;
                    //     $image->name = $request->name;
                    //     $image->save();
                    // }/

                            $i=0;
                            foreach($imageDataArray as $name)
                            {

                                list($type, $name) = explode(';', $name);
                                list(, $name)      = explode(',', $name);
                                $data = base64_decode($name);
                                $i +=1;

                                $imagename= 'Image'.$i.'.jpeg';
                                // $destinationPath = public_path('images');
                                $path = str_replace('\\', '/', base_path()) ."/uploads/events/".$imagename;
                                $res = file_put_contents($path, $data);

                                /*$saveInlistingimages = DB::insert('INSERT INTO listingimages (Listing, Image) values (?, ?)', [$lastId, $path]);*/

                            }
                        return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
                }
    }

    public function update(Request $request, $id)
    {
        $existingRecord = EventDetails::first();
        $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

        $img_path = $request->image;
        $folderPath = str_replace('\\', '/', base_path()) ."/uploads/eventDetails/";
        $base64Image = explode(";base64,", $img_path);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $file = $recordId . '.' . $imageType;
        $file_dir = $folderPath . $file;

        file_put_contents($file_dir, $image_base64);
        $courses = EventDetails::find($id);
        $courses->image = $file;
        $courses->program_id = $request->program_id;
        $courses->introduction = $request->introduction;
        $courses->course_overview = $request->course_overview;
        $courses->learning_outcome = $request->learning_outcome;
        $courses->prerequisite = $request->prerequisite;
        $courses->duration = $request->duration;
        $courses->training_period = $request->training_period;
        $courses->batch = $request->batch;
        $courses->project = $request->project;
        $courses->average_salary = $request->average_salary;

        $update_data = $courses->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
    }

    public function delete($id)
    {
        $all_data=[];
        $courses = EventDetails::find($id);
        $courses->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
        // return response()->json("Contact Enquiry Deleted Successfully!");
    }

   
}