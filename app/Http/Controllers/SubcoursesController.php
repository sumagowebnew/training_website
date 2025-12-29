<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subcourses;

use App\Models\CourseFeeDetails;
use Validator;
use DB;

class SubcoursesController extends Controller
{
    public function index(Request $request, $id)
    {
        //added groupby
        $all_data = Subcourses::leftJoin('course_fee_details', function ($join) {
            $join->on('subcourses.id', '=', 'course_fee_details.sub_course_id');
        })
            ->where('subcourses.course_id', $id)->groupBy('course_fee_details.sub_course_id')
            ->select([
                'subcourses.url',
                'subcourses.course_id as course_id',
                'subcourses.id as subcourses_id',
                'subcourses.image as subcourses_image',
                'subcourses.name as subcourses_name',
                'course_fee_details.sub_course_duration as sub_course_duration',
                CourseFeeDetails::raw('MIN(sub_course_fee) as sub_course_fee')
            ])->get();

        $response = [];
        foreach ($all_data as $item) {
            $data = $item->toArray();
            $logo = $data['subcourses_image'];
            if (!empty($logo)) {
                $imagePath = str_replace('\\', '/', storage_path()) . "/all_web_data/images/subcourse/" . $logo;
                $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
                $data['image'] = $base64;
            }
            $response[] = $data;
        }
        return response()->json(['data' => $response, 'status' => 'Success', 'message' => 'Fetched All Data Successfully', 'StatusCode' => '200']);
    }
    // public function all_course(Request $request)
    // {
    //     $all_data = Subcourses::leftJoin('course_fee_details', function($join) {
    //         $join->on('subcourses.id', '=', 'course_fee_details.sub_course_id');
    //       })
    //       ->select([
    //           'subcourses.course_id as course_id', 
    //           'subcourses.id as subcourses_id', 
    //           'subcourses.image as subcourses_image', 
    //           'subcourses.name as subcourses_name', 
    //           'course_fee_details.sub_course_fee',
    //           'course_fee_details.sub_course_duration as sub_course_duration'             
    //       ])->get();

    //       $response = [];
    //       foreach ($all_data as $item) {
    //           $data = $item->toArray();
    //           $logo = $data['subcourses_image'];
    //           $imagePath =str_replace('\\', '/', storage_path())."/all_web_data/images/subcourse/" . $logo;
    //           $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
    //           $data['image'] = $base64;
    //           $response[] = $data;
    //       }
    //     return response()->json(['data'=>$response,'status' => 'Success', 'message' => 'Fetched All Data Successfully','StatusCode'=>'200']);
    // }

    public function all_course(Request $request)
    {
        // $all_data = Subcourses::LeftJoin('course_fee_details', function($join) {
        //     $join->on('subcourses.id', '=', 'course_fee_details.sub_course_id');
        //   })->groupBy('course_fee_details.sub_course_id')
        //   ->select([
        //       'subcourses.course_id as course_id', 
        //       'subcourses.id as subcourses_id', 
        //       'subcourses.image as subcourses_image', 
        //       'subcourses.name as subcourses_name', 
        //       'course_fee_details.sub_course_fee',
        //       'course_fee_details.sub_course_duration as sub_course_duration'             
        //   ])->get();


        //       $all_data = Subcourses::select([
        //         'subcourses.course_id as course_id', 
        //         'subcourses.id as subcourses_id', 
        //         'subcourses.image as subcourses_image', 
        //         'subcourses.name as subcourses_name', 
        //         'course_fee_details.sub_course_fee',
        //         'course_fee_details.sub_course_duration as sub_course_duration',
        //         'coursecategory.name AS coursename'           
        //     ])
        // ->LeftJoin('course_fee_details', 'subcourses.id', '=', 'course_fee_details.sub_course_id')
        // ->LeftJoin('coursecategory', 'subcourses.course_id', '=', 'coursecategory.id')
        // // ->groupBy('course_fee_details.sub_course_id')
        // ->where('subcourses.is_active', 1)
        //   ->groupBy(
        //     'subcourses.course_id',
        //     'subcourses.id',
        //     'subcourses.image',
        //     'subcourses.name',
        //     'course_fee_details.sub_course_fee',
        //     'course_fee_details.sub_course_duration',
        //     'coursecategory.name'
        // )
        // ->get();


        $all_data = Subcourses::select([
            DB::raw('MIN(subcourses.course_id) as course_id'),
            DB::raw('MIN(subcourses.id) as subcourses_id'),
            DB::raw('MIN(subcourses.image) as subcourses_image'),
            'subcourses.name as subcourses_name',
            DB::raw('MAX(course_fee_details.sub_course_fee) as sub_course_fee'),
            DB::raw('MAX(course_fee_details.sub_course_duration) as sub_course_duration'),
            DB::raw('MIN(coursecategory.name) as coursename')
        ])
            ->leftJoin('course_fee_details', 'subcourses.id', '=', 'course_fee_details.sub_course_id')
            ->leftJoin('coursecategory', 'subcourses.course_id', '=', 'coursecategory.id')
            ->where('subcourses.is_active', 1)
            ->groupBy('subcourses.name')
            ->get();

        $response = [];
        foreach ($all_data as $item) {
            $data = $item->toArray();
            $logo = $data['subcourses_image'];
            $imagePath = str_replace('\\', '/', storage_path()) . "/all_web_data/images/subcourse/" . $logo;
            $base64 = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));
            $data['image'] = $base64;
            $response[] = $data;
        }
        return response()->json(['data' => $response, 'status' => 'Success', 'message' => 'Fetched All Data Successfully', 'StatusCode' => '200']);
    }
    public function Add(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            $existingRecord = Subcourses::orderBy('id', 'DESC')->first();
            $recordId = $existingRecord ? $existingRecord->id + 1 : 1;

            $image = $request->image;
            createDirecrotory('/all_web_data/images/subcourse/');
            $folderPath = str_replace('\\', '/', storage_path()) . "/all_web_data/images/subcourse/";

            $base64Image = explode(";base64,", $image);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);

            $file = $recordId . '.' . $imageType;
            $file_dir = $folderPath . $file;

            file_put_contents($file_dir, $image_base64);
            $programs = new Subcourses();
            $programs->course_id = $request->course_id;
            $programs->image = $file;
            $programs->name = $request->subcourses_name;
            $programs->save();
            return response()->json(['status' => 'Success', 'message' => 'Added successfully', 'StatusCode' => '200']);
        }
    }

    public function update(Request $request, $id)
    {
        $count = Subcourses::find($id);
        $image = $request->image;
        if ($request->image) {
            createDirecrotory('/all_web_data/images/subcourse/');
            $folderPath = str_replace('\\', '/', storage_path()) . "/all_web_data/images/subcourse/";

            $base64Image = explode(";base64,", $image);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);

            $file = $id . '_updated.' . $imageType;
            $file_dir = $folderPath . $file;

            file_put_contents($file_dir, $image_base64);
            $count->image = $request->image;
        }
        $count->name = $request->subcourses_name;
        $count->course_id = $request->course_id;
        $update_data = $count->update();
        return response()->json(['status' => 'Success', 'message' => 'Updated successfully', 'StatusCode' => '200']);
    }

    public function delete($id)
    {
        $all_data = [];
        $Contact_enquiries = Subcourses::where('id', $id)->update(['is_active' => 0]);
        // $Contact_enquiries->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully', 'StatusCode' => '200']);
    }


}