<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Models\Subcourses;
use App\Models\Alumini;
use App\Models\HandsonProjects;
use App\Models\Mentor;
use App\Models\ExpertReview;
use App\Models\Moudetails;
use App\Models\Topranked;

use Validator;
class DashboardController extends Controller
{
    public function get_dashboard_count(Request $request)
    {
        $courses = CourseCategory::count();
        $subcourses = Subcourses::count();
        $alumini = Alumini::count();
        $handsonproject = HandsonProjects::count();
        $mentor = Mentor::count();
        $expertreview = ExpertReview::count();
        $mous = Moudetails::count();
        $topranked = Topranked::count();
        // return $this->responseApi($contactEnq,'All data get','success',200);
        return response()->json(['courses' => $courses,
        'subcourses' => $subcourses,
        'alumini' => $alumini,
        'handsonproject' => $handsonproject,
        'mentor' => $mentor,
        'expertreview' => $expertreview,
        'mous' => $mous,
        'topranked' => $topranked,
        'message' => 'All data fetched successfully','StatusCode'=>'200']);

    }

}
 