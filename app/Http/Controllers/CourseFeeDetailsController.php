<?php

namespace App\Http\Controllers;

use App\Models\CourseFeeDetails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class CourseFeeDetailsController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pro_max_id' => 'required',
            'course_id' => 'required',
            'sub_course_id' => 'required',

            'sub_course_fee' => 'required',
            'sub_course_duration' => 'required',

            'job_assistance' => 'required',
            'live_class_subscription' => 'required',
            'lms_subscription' => 'required',
            'job_referrals' => 'required',
            'industry_projects' => 'required',
            'capstone_projects' => 'required',
            'domain_training' => 'required',
            'project_certification_from_companies' => 'required',
            'adv_ai_dsa' => 'required',
            'microsoft_certification' => 'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $contactDetails = new CourseFeeDetails();
            $contactDetails->pro_max_id = $request->pro_max_id;
            $contactDetails->course_id = $request->course_id;
            $contactDetails->sub_course_id = $request->sub_course_id;
            $contactDetails->sub_course_fee = $request->sub_course_fee;
            $contactDetails->sub_course_duration = $request->sub_course_duration;
            $contactDetails->job_assistance =  $request->job_assistance;
            $contactDetails->live_class_subscription =  $request->live_class_subscription;
            $contactDetails->lms_subscription =  $request->lms_subscription;
            $contactDetails->job_referrals =  $request->job_referrals;
            $contactDetails->industry_projects =  $request->industry_projects;
            $contactDetails->capstone_projects =  $request->capstone_projects;
            $contactDetails->domain_training =  $request->domain_training;
            $contactDetails->project_certification_from_companies =  $request->project_certification_from_companies;
            $contactDetails->adv_ai_dsa =  $request->adv_ai_dsa;
            $contactDetails->microsoft_certification =  $request->microsoft_certification;
            $contactDetails->save();
            return response()->json(['status' => 'Success', 'message' => 'Added successfully','StatusCode'=>'200']);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pro_max_id' => 'required',
            'course_id' => 'required',
            'sub_course_fee' => 'required',
            'sub_course_duration' => 'required',
            'sub_course_id' => 'required',
            'job_assistance' => 'required',
            'live_class_subscription' => 'required',
            'lms_subscription' => 'required',
            'job_referrals' => 'required',
            'industry_projects' => 'required',
            'capstone_projects' => 'required',
            'domain_training' => 'required',
            'project_certification_from_companies' => 'required',
            'adv_ai_dsa' => 'required',
            'microsoft_certification' => 'required',
            ]);
        
        if ($validator->fails())
        {
            return $validator->errors()->all();
    
        }else
        {
            $contactDetails = CourseFeeDetails::find($id);
            $contactDetails->pro_max_id = $request->pro_max_id;
            $contactDetails->course_id = $request->course_id;
            $contactDetails->sub_course_id = $request->sub_course_id;
            $contactDetails->sub_course_fee = $request->sub_course_fee;
            $contactDetails->sub_course_duration = $request->sub_course_duration;
            $contactDetails->job_assistance =  $request->job_assistance;
            $contactDetails->live_class_subscription =  $request->live_class_subscription;
            $contactDetails->lms_subscription =  $request->lms_subscription;
            $contactDetails->job_referrals =  $request->job_referrals;
            $contactDetails->industry_projects =  $request->industry_projects;
            $contactDetails->capstone_projects =  $request->capstone_projects;
            $contactDetails->domain_training =  $request->domain_training;
            $contactDetails->project_certification_from_companies =  $request->project_certification_from_companies;
            $contactDetails->adv_ai_dsa =  $request->adv_ai_dsa;
            $contactDetails->microsoft_certification =  $request->microsoft_certification;
            $update_data = $contactDetails->update();
            return response()->json(['status' => 'Success', 'message' => 'Updated successfully','StatusCode'=>'200']);
        }
    }


    public function getCourseFeeDetailsList()
    {
        $hands_on_pro = CourseFeeDetails::leftJoin('subcourses', function($join) {
            $join->on('course_fee_details.sub_course_id', '=', 'subcourses.id');
          })
          ->leftJoin('coursecategory', function($join) {
            $join->on('course_fee_details.course_id', '=', 'coursecategory.id');
          })
          ->leftJoin('feecategory', function($join) {
            $join->on('course_fee_details.pro_max_id', '=', 'feecategory.id');
          })
          ->select(
            'course_fee_details.id as fee_details_id',
            'feecategory.title as pro_max_name',
            'coursecategory.name as course_name',
            'subcourses.name as sub_course_name',
            'course_fee_details.sub_course_fee',
            'course_fee_details.sub_course_duration',
            'course_fee_details.job_assistance',
            'course_fee_details.live_class_subscription',
            'course_fee_details.lms_subscription',
            'course_fee_details.job_referrals',
            'course_fee_details.industry_projects',
            'course_fee_details.capstone_projects',
            'course_fee_details.domain_training',
            'course_fee_details.project_certification_from_companies',
            'course_fee_details.adv_ai_dsa',
            'course_fee_details.microsoft_certification',
            'coursecategory.name as course_name',
            'subcourses.name as sub_course_name',
          )
          ->get();
        $response = [];
        foreach ($hands_on_pro as $item) {
            $data = $item->toArray();
            $response[] = $data;
        }
        return response()->json($response);
    }

    public function delete($id)
    {
        $handson_pro_delete = CourseFeeDetails::find($id);
        $handson_pro_delete->delete();
        return response()->json(['status' => 'Success', 'message' => 'Deleted successfully','StatusCode'=>'200']);

    }


    public function getByCourseId($id)
    {
        $hands_on_pro = CourseFeeDetails::where('sub_course_id','=',$id)->get();
        return response()->json($hands_on_pro);
    }
}
