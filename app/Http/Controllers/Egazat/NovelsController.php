<?php

namespace App\Http\Controllers\Egazat;

use App\Http\Controllers\Controller;
use App\Http\Resources\NovelResource;
use App\Models\Novel;
use Illuminate\Http\Request;

class NovelsController extends Controller
{
    public function index()
    {
        $novels = Novel::all();
        return responseApi(200, 'All novels', NovelResource::collection($novels));
    }
    public function show($name)
    {
        $novel = Novel::whereName($name)->first();
        if (!$novel) {
            return responseApi(404, 'Not Found');
    }
    return responseApi(200, 'Novel ' . $name,  NovelResource::make($novel));
    }
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:novels,name',
        'description' => 'required|max:200', 'read_id' => 'required|exists:novels,id']);

        $novel = Novel::create($request->only(['name', 'description', 'read_id']));
        if (!$novel) {
            return responseApi(404, 'Not Found');
        }
        return responseApi(201, 'New novel created successfully');
    }
    public function update(Request $request, $id)
    {
        $novel = Novel::find($id);
        if (!$novel) {
            return responseApi(404, 'Not Found');
        }

        $novel->update($request->all());
        return responseApi(200, 'novel updated successfully');
    }
    public function destroy($id)
    {
        $novel = Novel::find($id);
        if (!$novel) {
            return responseApi(404, 'Not Found');
        }
        $novel->delete();
        return responseApi(200, 'novel deleted successfully');
    }
}
