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
            $contactDetails->sub_course_id = $request->sub_course_id;
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
            $contact_details->sub_course_id = $request->sub_course_id;
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
        $hands_on_pro = HandsonProjects::get();

        $response = [];

        foreach ($hands_on_pro as $item) {
            $data = $item->toArray();
            $response[] = $data;
        }

        return response()->json($response);
    }

    public function getCategoryByCouseId(Request $request, $id)
    {
        // Get all data from the database
        $hands_on_pro = HandsonProjects::join('handson_project_cateories', function($join) {
            $join->on('handson_projects.handson_category_id', '=', 'handson_project_cateories.id');
          })
          ->where('handson_projects.sub_course_id','=',$id)
          ->select([
              'handson_projects.id as handson_projects',
              'handson_projects.title as  projects_title',
              'handson_project_cateories.id as handson_project_cateories_id',
              'handson_project_cateories.title as handson_project_cateories_title',
              'handson_projects.desc',
             
          ])->get();

        $response = [];

        foreach ($hands_on_pro as $item) {
            $data = $item->toArray();
            $response[] = $data;
        }

        return response()->json($hands_on_pro);
    }

    public function getHandsonByHandsonId(Request $request, $id)
    {
        // Get all data from the database
        $hands_on_pro = HandsonProjects::join('handson_project_cateories', function($join) {
            $join->on('handson_projects.handson_category_id', '=', 'handson_project_cateories.id');
          })
          ->where('handson_projects.handson_category_id','=',$id)
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
