<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::orderBy('id', 'DESC')->get();

            return SendingResponse::response('success', 'Permission Lists', $permissions, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|unique:permissions,name',
        ]);

        try {
            $permission = Permission::create($data);

            return SendingResponse::response('success', 'Created Successfully', $permission, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function edit(Permission $permission)
    {
        try {
            return SendingResponse::response('success', 'Permission', $permission, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name'              => 'required|unique:permissions,name,' . $permission->id,
        ]);

        try {
            $permission->update($data);

            return SendingResponse::response('success', 'Updated Successfully', $permission, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function delete(Permission $permission)
    {
        try {
            $permission->delete();

            return SendingResponse::response('success', 'Deleted Successfully', '', '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function permissionUser()
    {
        try {
            // Get the authenticated user
            $user = Auth::guard('sanctum')->user();
            $permissions = $user->getAllPermissions()->pluck('name');

            return SendingResponse::response('success', 'User Permissions', $permissions, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
