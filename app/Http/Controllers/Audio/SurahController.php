<?php

namespace App\Http\Controllers\Audio;

use App\Models\Audio;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurahResource;

class SurahController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:audio');
    }
    public function index()
    {
        $surahs = Audio::where('name', 'LIKE', '%'.request()->keyword.'%')->paginate();
        return responseApi(200, 'Recieved surahs', SurahResource::collection($surahs));
    }
    public function store(Request $request)
    {
        $request->validate(['name.*' => 'required|string', 'path' => 'required']);
        try {
            DB::beginTransaction();
            $surah = Audio::create($request->all());
                if (!$surah) {
                    return responseApi(404, 'Surah not found');
                }
            ImageManager::UploadAudio($request,$surah);
            DB::commit();
            return responseApi(201, 'Surah created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return responseApi(500, 'An error occurred while creating the surah.');
        }
    }
    public function show($name)
    {
        $surah = Audio::whereName($name)->first();
        if (!$surah) {
            return responseApi(404, 'Surah not found');
        }
        return responseApi(200, 'Surah retrieved successfully',SurahResource::make($surah));
    }
    public function destroy(Request $request,$id)
    {
        $surah = Audio::find($id);
        if (!$surah) {
            return responseApi(404, 'Surah not found');
        }
        if (File::exists(public_path( $surah->path ))) {
            File::delete(public_path( $surah->path ));
        }
        $surah->delete();
        return responseApi(200, 'Surah deleted successfully');
    }
}
