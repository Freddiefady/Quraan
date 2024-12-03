<?php

namespace App\Http\Controllers\Articles;

use App\Models\Articles;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticlesResource;
use App\Http\Resources\ArticlesCollection;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:articles');
    }
    public function index()
    {
        $all_articles =  Articles::where('title', 'LIKE', '%'.request()->keyword.'%')->active()
        ->activeUser()
        ->paginate();
        return responseApi(200, 'Response data successfully', (new ArticlesCollection($all_articles))->response()->getData(true));
    }
    public function showArticle($slug)
    {
        $post = Articles::with(['admin', 'user', 'images'])->active()->activeUser()->whereSlug($slug)->first();
        if(!$post)
        {
            return responseApi(404, 'Not found post');
        }
        return responseApi(200, 'Response posts data successfully', ArticlesResource::make($post));
    }
}
