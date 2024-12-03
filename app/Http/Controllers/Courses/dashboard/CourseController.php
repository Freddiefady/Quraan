<?php

namespace App\Http\Controllers\Courses\dashboard;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CoursesRequest;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:videos');
    }
    public function index()
    {
        $coursess = Course::get();
        return responseApi(200, 'Created course successfully', $coursess);

    }
    public function store(CoursesRequest $request)
    {
        $request->validated();
        try{
            DB::beginTransaction();
            $course = auth()->user()->courses()->create($request->except(['video']));
            ImageManager::UploadVideo($request, $course);
            DB::commit();
            return responseApi(200, 'Created course successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return responseApi(500,'An error occurred while creating the course.');
        }
    }
    public function show($slug)
    {
        $courses = Course::with('videos')->whereSlug($slug)->first();
        if (!$courses) {
            return responseApi(404, 'Course not found');
        }
        return responseApi(200, 'Course retrieved successfully', $courses);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $request->validated();
        try{
            DB::beginTransaction();
            $course = Course::whereSlug($slug)->first();
            $course->update($request->except( 'video'));
            //check if old course has image or no
            if ($request->hasFile('video'))
            {
                if (File::exists(public_path( $course->path ))) {
                    File::delete(public_path( $course->path ));
                }
                ImageManager::UploadVideo($request, $course);
            }
            DB::commit();
            return responseApi(200, 'success');
        }catch(\Exception $e){
            DB::rollBack();
            return responseApi(500, 'fail'. $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return responseApi(404, 'Course not found');
        }
        if (File::exists(public_path( $course->path )))
        {
            File::delete(public_path( $course->path ));
        }
        $course->delete();
        return responseApi(204, 'Course deleted successfully');
    }
}
