<?php

namespace App\Http\Controllers\Favorite;

use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:favorite');
    }
    public function store(Request $request,$audioId, $articleId = null, $sheikhsId = null)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'audio_id' => 'required|exists:audio,id',
            'sheikhs_id' => 'required|exists:sheikhs,id',
            'article_id' => 'required|exists:articles,id',
        ]);
         // Check if the user is authenticated
    if (!Auth::check()) {
        return responseApi(401, 'User  not authenticated.');
    }

        // Create a new favorite entry
        Favorite::create([
            'user_id' => Auth::id(),
            'audio_id' => $audioId,
            'sheikhs_id' => $sheikhsId,
            'article_id' => $articleId
        ]);

        return responseApi(201, 'Audio saved to favorites!');
    }
}
