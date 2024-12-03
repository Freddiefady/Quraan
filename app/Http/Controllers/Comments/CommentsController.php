<?php
namespace App\Http\Controllers\Comments;


use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:comments');
    }
    public function index(Request $request)
    {
        $comment = Comment::active()->get();
        return responseApi(200, 'Response comments successfully', $comment);
    }
    public function storeComment(Request $request)
    {
        $request->validate([
            'user_id'=>['required', 'exists:users,id'],
            'rating_id'=>['required', 'numeric', 'exists:ratings,id'],
            'comment'=>['required', 'string', 'max:200'],
        ]);

        $comment = Comment::create([
            'user_id' => $request->user_id,
            'rating_id' => $request->rating_id,
            'comment' => $request->comment,
        ]);
        $comment->load(['user']);
        if(!$comment) {
            return responseApi(403,'Failed to save comment');
        }
        return responseApi(201,'Comment saved successfully');
    }
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if(!$comment) {
            return responseApi(404,'Comment not found');
        }
        $comment->delete();
        return responseApi(200,'Comment deleted successfully');
    }
}
