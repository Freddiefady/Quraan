<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use App\Http\Requests\DemoRequest;
use App\Http\Resources\UserDemoResource;
use App\Models\DemoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDemoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:userDemo');
    }
    public function index()
    {
        $users = DemoModel::paginate();
        return responseApi(200, 'Users retrieved successfully',
        (UserDemoResource::collection($users))->response()->getData(true));
    }
    public function store(DemoRequest $request)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $userDemo = DemoModel::create($request->all());
            if (!$userDemo) {
                return responseApi(404, 'User not found');
            }
            DB::commit();
            return responseApi(201, 'User created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return responseApi(500, 'Internal Server Error');
        }
    }
    public function destroy($id)
    {
        $userDemo = DemoModel::find($id);
        if (!$userDemo) {
            return responseApi(404, 'User not found');
        }
        try {
            DB::beginTransaction();
            $userDemo->delete();
            DB::commit();
            return responseApi(200, 'User deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return responseApi(500, 'Internal Server Error');
        }
    }
}
