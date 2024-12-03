<?php

namespace App\Http\Controllers\Authorization;

use App\Models\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizationRequest;

class AuthorizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:authorizations');
    }
    public function index()
    {
        $authorizations = Roles::paginate(5);
        return responseApi(200, 'Requested authorization information', $authorizations);
    }    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorizationRequest $request)
    {
        $authorization = new Roles();
        $this->role($request, $authorization);
        return responseApi(201, 'Authorization created successfully');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $authorization = Roles::findOrFail($id);
        $this->role($request, $authorization);
        return responseApi(200, 'Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Roles::findOrFail($id);
        if($role->admins->count() > 0)
        {
            return responseApi(403, 'Please delete Related admin first');
        }
        $roles = $role->delete();
        if(!$roles)
        {
            return responseApi(404, 'Role not found');
        }
        return responseApi(200, 'Deleted successfully');
    }
    /**
     * Summary of role
     * @param mixed $request
     * @param mixed $authorization
     * @return void
     */
    private function role($request, $authorization)
    {
        $authorization->role = $request->role;
        $authorization->permissions = json_encode($request->permissions);
        $authorization->save();
    }
}
