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
            'permission_id' => 'required',
        ]);

        try {
            $data = array();
            $permissions = $request->permission_id;

            foreach ($permissions as $permission) {
                $data['role_id']            = $request->role_id;
                $data['permission_id']      = $permission;

                DB::table('role_has_permissions')->insert($data);
            }

            $result = DB::table('role_has_permissions')->where('role_id', $request->role_id)->get();

            return SendingResponse::response('success', 'Permission Added Into Role Successfully', $result, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function edit($roleId)
    {
        try {
            $roleHasPermissions = DB::table('role_has_permissions')->where('role_id', $roleId)->get();

            return SendingResponse::response('success', 'Permission Under Role',  $roleHasPermissions, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function update(Request $request, $roleId)
    {
        $request->validate([
            'permission_id' => 'required',
        ]);

        try {
            $data = array();
            $permissions = $request->permission_id;

            // delete previous permissions and roles
            DB::table('role_has_permissions')->where('role_id', $roleId)->delete();

            foreach ($permissions as $permission) {
                $data['role_id']            = $roleId;
                $data['permission_id']      = $permission;

                DB::table('role_has_permissions')->insert($data);
            }

            $result = DB::table('role_has_permissions')->where('role_id', $roleId)->get();

            return SendingResponse::response('success', 'Updated Successfully', $result, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function delete($roleId)
    {
        try {
            DB::table('role_has_permissions')->where('role_id', $roleId)->delete();

            return SendingResponse::response('success', 'Permission Under Role Deleted Successfully', '', '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
