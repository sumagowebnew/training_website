<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Applynow;
use Illuminate\Support\Facades\File;

class ApplynowController extends Controller
{
    public function index()
    {
        // Retrieve all applicants from the database
        $applicants = Applynow::all();
    
        // Process the applicants data
        $processedApplicants = [];
    
        foreach ($applicants as $applicant) {
            // Generate URLs for downloading the files
            $cvDownloadUrl = url('/applyNow/' . $applicant->id . '/download/cv');
            $coverLetterDownloadUrl = url('/applyNow/' . $applicant->id . '/download/cover_letter');
    
            // Append the processed applicant data
            $processedApplicants[] = [
                'id' => $applicant->id,
                'name' => $applicant->name,
                'email' => $applicant->email,
                'contact' => $applicant->contact,
                'technology' => $applicant->technology,
                'cv' => [
                    'file_name' => $applicant->cv,
                    'download_url' => $cvDownloadUrl,
                ],
                'cover_letter' => [
                    'file_name' => $applicant->cover_letter,
                    'download_url' => $coverLetterDownloadUrl,
                ],
                'duration' => $applicant->duration,
            ];
        }
    
        // Return the processed applicants data
        return response()->json([
            'applicants' => $processedApplicants,
        ]);
    }
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'contact' => 'required|numeric|digits:10|min:8',
            'email'=>'required|email',
            'technology'=>'required',
            // 'cv'=>'required|file|size:2048',
            // 'cover_letter'=>'required|file|size:2048',
            'duration'=>'required'
            ]);

        if ($validator->fails()) {
            return $validator->errors()->all();

        }else{
            $existingRecord = Applynow::orderBy('id', 'DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

            // Extract the CV and cover letter files from the base64 encoded data
            $cvFileData = base64_decode($request->input('cv'));
            $base64cv = explode(";base64,", $request->input('cv'));
            $cvFileData =$base64cv[0];

            // dd($cvFileData);
            $explodecv = explode("/", $base64cv[0]);
            $cvfileType = $explodecv[1];
            // Generate unique file names for the CV and cover letter files
            $cvFileName = 'cv_'.$recordId.'.pdf';

            $coverLetterFileData = base64_decode($request->input('cover_letter'));
            $base64cl = explode(";base64,", $request->input('cover_letter'));
            $explodecl = explode("/", $base64cl[0]);
            $coverLetterFileData =$base64cv[0];
            $clfileType = $explodecl[1];
            
            $coverLetterFileName = 'cover_letter_'.$recordId.'.'.$clfileType;

            //  $folderPath = "uploads/cv_files/";
            $folderPath = str_replace('\\', '/', base_path())."/uploads/cv_files/";
            

            $folderPath1 = str_replace('\\', '/', base_path())."/uploads/cover_letter_files/";
            
            // $file = $recordId . '.' .$imageType;
            $file_dir = $folderPath . $cvFileName;
            // dd($file_dir);
            $file_dir1 = $folderPath1 . $coverLetterFileName;

            file_put_contents($file_dir, $cvFileData);

            file_put_contents($file_dir1, $coverLetterFileData);
            // Store the CV and cover letter files in the storage path
            // Storage::put('uploads/cv_files/' . $cvFileName, $cvFileData);
            // Storage::put('uploads/cover_letter_files/' . $coverLetterFileName, $coverLetterFileData);

            // Create a new applicant record
            $applicant = new Applynow();
            $applicant->name = $request->input('name');
            $applicant->email = $request->input('email');
            $applicant->contact = $request->input('contact');
            $applicant->technology = $request->input('technology');
            $applicant->cv = $cvFileName;
            $applicant->cover_letter = $coverLetterFileName;
            $applicant->duration = $request->input('duration');
            $applicant->save();

            // Return a response indicating success
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }
    public function delete($id)
    {
        $all_data=[];
        $applynow = Applynow::find($id);
        $destination = 'uploads/cv_files/'.$applynow->cv;
        $cover_letter_files = 'uploads/cover_letter_files/'.$applynow->cover_letter;
           if(File::exists($destination))
           {
             File::delete($destination);
           }
           if(File::exists($cover_letter_files))
           {
             File::delete($cover_letter_files);
           }
        $applynow->delete();
        // return response()->json("Deleted Successfully!");
        return response()->json(['status' => 'Success', 'message' => 'Details Deleted successfully','StatusCode'=>'200']);
    }

    public function downloadCV($id)
    {
        return $this->downloadFile($id, 'cv');
    }
    
    public function downloadCoverLetter($id)
    {
        return $this->downloadFile($id, 'cover_letter');
    }
    
    private function downloadFile($id, $file)
    {
        // Find the applicant by ID
        $applicant = Applynow::findOrFail($id);
    
        // Retrieve the base64-encoded file
        $fileData = '';
    
        if ($file === 'cv') {
            $fileData = $applicant->cv;
        } elseif ($file === 'cover_letter') {
            $fileData = $applicant->cover_letter;
        }
    
        // Decode the base64-encoded file
        $decodedFileData = base64_decode($fileData);
        
        // Generate the file name
        $fileName = $file === 'cv' ? 'cv_' . $applicant->id . '.pdf' : 'cover_letter_' . $applicant->id . '.pdf';
        
    
        // Set the appropriate Content-Type header
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        //dd($headers);
    
        // Return the file download response
        return response($decodedFileData, 200, $headers);
    }
    
    


   
}