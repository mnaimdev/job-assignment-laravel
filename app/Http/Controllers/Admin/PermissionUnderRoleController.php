<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionUnderRoleController extends Controller
{
    // permission under role
    public function index()
    {
        try {
            $roles = Role::with('permissions')->get();

            return SendingResponse::response('success', 'Permission Under Role', $roles, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id'       => 'required',
            'permission_id' => 'required|array',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $role = Role::findOrFail($request->role_id);

                // Sync permissions with the role
                $role->syncPermissions($request->permission_id);
            });

            $result = DB::table('role_has_permissions')->where('role_id', $request->role_id)->get();

            return SendingResponse::response('success', 'Permissions Assigned to Role Successfully', $result, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function edit($roleId)
    {
        try {
            // Find the role by ID and load its associated permissions
            // $role = Role::findOrFail($roleId);
            // $permissions = $role->permissions()->get();

            $permissions = DB::table('role_has_permissions')->where('role_id', $roleId)->get();


            return SendingResponse::response('success', 'Permissions Under Role', $permissions, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }


    public function update(Request $request, $roleId)
    {
        $request->validate([
            'permission_id' => 'required|array',
        ]);

        try {
            DB::transaction(function () use ($request, $roleId) {
                $role = Role::findOrFail($roleId);

                // Sync permissions with the role, replacing the previous ones
                $role->syncPermissions($request->permission_id);
            });

            $result = DB::table('role_has_permissions')->where('role_id', $roleId)->get();

            return SendingResponse::response('success', 'Updated Successfully', $result, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }


    public function delete($roleId)
    {
        try {
            DB::transaction(function () use ($roleId) {
                $role = Role::findOrFail($roleId);

                // Remove all permissions from the role
                $role->syncPermissions([]);
            });

            return SendingResponse::response('success', 'Permissions Under Role Deleted Successfully', '', '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
