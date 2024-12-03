<?php

namespace App\Http\Controllers\General;

use App\Http\Resources\GeneralCollection;
use App\Models\Articles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticlesCollection;
use App\Models\Course;
use App\Models\Sheikhs;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:home');
    }
    public function index()
    {
        $articles = Articles::get();
        $sheikh = Sheikhs::get();
        $users = User::get();
        $courses = Course::get();
        $data = [
            'articles_count'=>$articles,
            'sheikhs_count'=>$sheikh,
            'users'=>$users,
            'courses_count'=>$courses
        ];
        return GeneralCollection::collection( collect($data));
    }
}
