<?php

namespace App\Http\Controllers\Admin;

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
            $roles = Role::all();

            return view('admin.permission_under_role.index', [
                'roles'         => $roles,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create()
    {
        try {
            $roles = Role::all();
            $groupNames = User::getPermisionGroups();

            return view('admin.permission_under_role.create', [
                'roles'             => $roles,
                'groupNames'        => $groupNames,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
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

            return back()->with('success', 'Permission assigned into role');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($roleId)
    {
        try {
            $groupNames = Admin::getPermisionGroups();
            $roles = Role::all();
            $roleHasPermissions = DB::table('role_has_permissions')->where('role_id', $roleId)->get();

            return view('admin.permission_under_role.edit', [
                'groupNames'            => $groupNames,
                'roleId'                => $roleId,
                'roles'                 => $roles,
                'roleHasPermissions'    => $roleHasPermissions,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
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

            return back()->with('success', 'Permission updated into role');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($roleId)
    {
        try {
            DB::table('role_has_permissions')->where('role_id', $roleId)->delete();

            return back()->with('success', 'Permission removed from role');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
