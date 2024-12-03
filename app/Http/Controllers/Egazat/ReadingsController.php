<?php

namespace App\Http\Controllers\Egazat;

use App\Models\Reads;
use App\Http\Controllers\Controller;
use App\Http\Resources\NovelResource;
use Illuminate\Http\Request;

class ReadingsController extends Controller
{
    public function reads()
    {
        $reads = Reads::all();
        if ($reads->isEmpty()) {
            return responseApi(404, 'Not Found readings');
        }
        return responseApi(200, 'Response post data successfully', $reads);
    }
    public function readNovels()
    {
        $reads = Reads::all();
        if ($reads->isEmpty()) {
            return responseApi(404, 'Not Found readings');
        }

        // Prepare an array to hold the novels for each Reads instance
        $novelsCollection = [];
        foreach ($reads as $read) {
            $novels = $read->novels; // Get novels for each Reads instance
            if ($novels->isEmpty()) {
                continue; // Skip if no novels for this Reads instance
            }
            $novelsCollection[] = [
                'novels' => NovelResource::collection($novels) // Use your resource to format the novels
            ];
        }

        // If you have novels for at least one Reads instance, return them
        if (empty($novelsCollection)) {
            return responseApi(404, 'No novels found for any readings');
        }

        return responseApi(200, 'Response post data successfully', $novelsCollection);
    }
    // Other methods for CRUD operations on Reads
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        $read = Reads::create($request->only('name'));
        if (!$read) {
            return responseApi(404, 'Not Found');
        }
        return responseApi(201, 'New reading created successfully');
    }
    public function update(Request $request, $id)
    {
        $read = Reads::find($id);
        if (!$read) {
            return responseApi(404, 'Not Found');
        }

        $read->update($request->except('_method'));
        return responseApi(200, 'Reading updated successfully');
    }
    public function destroy($id)
    {
        $read = Reads::find($id);
        if (!$read) {
            return responseApi(404, 'Not Found');
        }
        $read->delete();
        return responseApi(200, 'Reading deleted successfully');
    }
}
