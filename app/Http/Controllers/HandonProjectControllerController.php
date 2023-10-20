<?php

namespace App\Http\Controllers;

use App\Models\HandsonProjectCategories;
use App\Models\HandsonProjects;

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
            $data['table_name'] = 'handson_project_cateories';
            $response[] = $data;
        }
        // return $response;
        return response()->json(['data'=>$response, 'status' => 'Success', 'message' => 'Data get successfully','StatusCode'=>'200']);
    }

    public function deleteCategory($id)
    {
        $handson_pro_delete = HandsonProjectCategories::find($id);
        $handson_pro_delete->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);

    }


    public function addProjectDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'handson_category_id'=>'required',
            'sub_course_id'=>'required',
            'title'=>'required',
            'desc'=>'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $contactDetails = new HandsonProjects();
            $contactDetails->handson_category_id = $request->handson_category_id;
            $contactDetails->sub_course_id = json_encode($request->sub_course_id);
            $contactDetails->title = $request->title;
            $contactDetails->desc = $request->desc;
            $contactDetails->save();
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }

    public function updateProjectDetails(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'handson_category_id'=>'required',
            'sub_course_id'=>'required',
            'title'=>'required',
            'desc'=>'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $contact_details = HandsonProjects::find($id);
            $contact_details->handson_category_id = $request->handson_category_id;
            $contact_details->sub_course_id = json_encode($request->sub_course_id);
            $contact_details->title = $request->title;
            $contact_details->desc = $request->desc;
            $update_data = $contact_details->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);

        }
    }


    public function deleteProjectDetails($id)
    {
        $handson_pro_delete = HandsonProjects::find($id);
        $handson_pro_delete->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);

    }

    public function getProjectDetails()
    {
        // Get all data from the database
        // $hands_on_pro = HandsonProjects::get();

        $hands_on_pro = HandsonProjects::leftJoin('handson_project_cateories', function($join) {
            $join->on('handson_projects.handson_category_id', '=', 'handson_project_cateories.id');
          })
        //  ->where('handson_projects.handson_project_cateories',$request->id)
         ->select('handson_projects.*',
         'handson_project_cateories.title AS category_name'
         )->groupBy('handson_projects.id')
         ->get();

        $response = [];
        foreach ($hands_on_pro as $item) {
            $temp = [];

            $data = $item->toArray();
            $course_id = $data['sub_course_id'];
            // foreach (json_decode($course_id) as $key => $value){ 
            //     array_push($no,$value);
            // }
            $data['sub_course_id'] = json_decode($course_id);
                foreach(json_decode($course_id) as $course){
                    $arr = [];
                    $subcourse = \DB::table('subcourses')->where('id', $course)->first(); 
                    $arr['subcoursename'] = $subcourse->name;
                    $arr['sub_course_id'] = $subcourse->id;
                    array_push($temp,$arr);                
                }
            $data['subcourse_details'] = $temp;
            $response[] = $data;
        }

        return response()->json($response);
    }

    public function getCategoryByCouseId(Request $request)
    {
        $id = $request->input('id');
        // Get all data from the database
        // $hands_on_pro = HandsonProjects::join('handson_project_cateories', function($join) {
        //     $join->on('handson_projects.handson_category_id', '=', 'handson_project_cateories.id');
        //   })
        //   ->where('handson_projects.sub_course_id','=',$id)
        //   ->select([
        //       'handson_projects.id as handson_projects',
        //       'handson_projects.title as  projects_title',
        //       'handson_project_cateories.id as handson_project_cateories_id',
        //       'handson_project_cateories.title as handson_project_cateories_title',
        //       'handson_projects.desc',
             
        //   ])->get();

        // $response = [];

        // foreach ($hands_on_pro as $item) {
        //     $data = $item->toArray();
        //     $response[] = $data;
        // }

        // return response()->json($hands_on_pro);


        // Get all data from the database
        $hands_on_pro = HandsonProjectCategories::join('handson_projects', function($join) {
            $join->on('handson_project_cateories.id', '=', 'handson_projects.handson_category_id');
            })
            
            ->whereJsonContains('handson_projects.sub_course_id',$id)
            ->select([
                'handson_project_cateories.id as handson_project_cateories_id',
                'handson_project_cateories.title as handson_project_cateories_title',
                
            ])
            ->groupBy('handson_category_id')
            ->get();

        return response()->json(['data'=>$hands_on_pro, 'status' => 'Success', 'message' => 'Data Fetched Successfully','StatusCode'=>'200']);
    }

    public function getHandsonByHandsonCategoryId(Request $request)
    {

        $id = $request->input('id');
        $sub_course_id = $request->input('sub_course_id');
        // Get all data from the database
        $hands_on_pro = HandsonProjects::join('handson_project_cateories', function($join) {
            $join->on('handson_projects.handson_category_id', '=', 'handson_project_cateories.id');
          })
          ->where('handson_projects.handson_category_id',$id)
          ->whereJsonContains('handson_projects.sub_course_id',$sub_course_id)
          ->select([
              'handson_projects.id as handson_projects_id',
              'handson_projects.title as  projects_title',
              'handson_project_cateories.id as handson_project_cateories_id',
              'handson_project_cateories.title as handson_project_cateories_title',
              'handson_projects.desc',
             
          ])->get();

        $response = [];

        foreach ($hands_on_pro as $item) {
            $response[] = $item->toArray();
        }

        // return response()->json($hands_on_pro);
        return response()->json(['data'=>$hands_on_pro, 'status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);
    }


    


}
