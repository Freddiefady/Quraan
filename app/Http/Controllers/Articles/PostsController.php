<?php

namespace App\Http\Controllers\Articles;

use App\Models\Articles;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticlesCollection;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:posts');
    }
    public function index()
    {
        // Retrieve all posts
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return responseApi(404, 'No users found.');
        }

        $posts = $user->posts()->active()->activeUser()->get();
        if ($posts->count() > 0) {
            return responseApi(200, 'Response posts data successfully', new ArticlesCollection($posts));
        }
        return responseApi(404, 'No posts found.');
    }
    public function store(ArticleRequest $request)
    {
        // return $request;
        $request->validated();
        try{
            DB::beginTransaction();
            $post = auth()->user()->posts()->create($request->except('images'));
            if (!$post) {
                return responseApi(500, 'Failed to create post.');
            }
            ImageManager::UploadImages($request,null,$post);
            DB::commit();
            return responseApi(201, 'Post created successfully');
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store post'. $e->getMessage());
            return responseApi(500, 'Failed to create post.');
        }
    }
    public function update(ArticleRequest $request, $post_id)
    {
        $request->validated();
        try{
            DB::beginTransaction();
            $post = auth()->user()->posts()->whereId($post_id)->first();
            if (!$post) {
                return responseApi(404, 'Post not found.');
            }
            $post->update($request->except(['_method', 'images']));
            //check if old post has image or no
            if ($request->hasFile('images'))
            {
                ImageManager::deleteImages($post);
                ImageManager::UploadImages($request, null, $post);
            }
            DB::commit();
            return responseApi(200, 'Post updated successfully');
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update post'. $e->getMessage());
            return responseApi(500, 'Failed to update post.');
        }
    }
    public function destroy($post_id)
    {
        $post = auth()->user()->posts()->whereId($post_id)->first();
        if (!$post) {
            return responseApi(404, 'Post not found.');
        }
        ImageManager::deleteImages($post);
        $post->delete();
        return responseApi(204, 'Post deleted successfully');
    }
    public function toggleStatus($id)
    {
        $post = Articles::findOrFail($id);
        if($post->status == 1)
        {
            $post->update([
                'status' => 0,
            ]);
            // Session::flash('success', 'post status changed to inactive');
        }else{
            $post->update([
                'status' => 1,
            ]);
            // Session::flash('success', 'post status changed to active');
        }
        return responseApi(200, 'updated successfully');
    }
}
