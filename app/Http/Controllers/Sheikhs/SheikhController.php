<?php

namespace App\Http\Controllers\Sheikhs;

use App\Models\Sheikhs;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SheikhRequest;
use Illuminate\Support\Facades\File;
use App\Http\Resources\SheikhResoucre;

class SheikhController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:sheikhs');
    }
    public function index()
    {
        $users = Sheikhs::get();
        return responseApi(200, 'Sheikhs retrieved successfully', $users);
    }
    public function store(SheikhRequest $request)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $sheikhs = Sheikhs::create($request->all());
                if (!$sheikhs) {
                    return responseApi(404, 'User not found');
                }
            ImageManager::UploadImages($request, $sheikhs);
            ImageManager::UploadFile($request, $sheikhs);
            DB::commit();
            return responseApi(201, 'Sheikh created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return responseApi(500, 'An error occurred while creating the sheikh');
        }
    }
    public function show($name)
    {
        $sheikh = Sheikhs::whereName($name)->first();
        if (!$sheikh) {
            return responseApi(404, 'Sheikh not found');
        }
        return responseApi(200, 'Sheikh retrieved successfully',  SheikhResoucre::make($sheikh));
    }
    public function destroy(Request $request,$id)
    {
        $sheikhs = Sheikhs::find($id);
        if (!$sheikhs) {
            return responseApi(404, 'Sheikh not found');
        }
        if (File::exists(public_path( $sheikhs->cv ))) {
            File::delete(public_path( $sheikhs->cv ));
        }
        if (File::exists(public_path( $sheikhs->image ))) {
            File::delete(public_path( $sheikhs->image ));
        }
        $sheikhs->delete();
        return responseApi(200, 'Sheikh deleted successfully');
    }
}
