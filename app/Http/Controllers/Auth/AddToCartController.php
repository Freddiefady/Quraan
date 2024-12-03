<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Course;
use Illuminate\Http\Request;

class AddToCartController extends Controller
{
    public function store(Request $request)
    {
        $user_id  = auth()->user()->id;

        if (auth()->check()) {
            $cousre = Course::where('id', $request->id)->exists();
            if ($cousre) {
                Cart::create([
                    'user_id' => $user_id,
                    'course_id' => $request->id,
                ]);
                return responseApi(200, 'Course added to cart');
            } else {
                return responseApi(404, 'Course not found');
            }
        } else {
            return responseApi(401, 'Unauthorized');
        }
    }
}
