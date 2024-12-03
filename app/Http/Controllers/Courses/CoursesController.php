<?php

namespace App\Http\Controllers\Courses;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoursesRequest;
use App\Models\Course;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:courses');
    }
    public function index()
    {
        $courses = Course::get();
        return responseApi(200, 'Recieved Courses successfully', $courses);
    }
    public function show($title)
    {
        $course = Course::whereTitle($title)->first();
        if (!$course) {
            return responseApi(404, 'course not found');
        }
        return responseApi(200, 'course retrieved successfully',$course);
    }
}
