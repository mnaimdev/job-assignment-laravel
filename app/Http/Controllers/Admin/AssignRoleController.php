<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AssignRoleController extends Controller
{
    // assign role
    public function index()
    {
        try {
            $users = Admin::all();

            return view('admin.assign_role.index', [
                'users'         => $users,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create()
    {
        try {
            $roles = Role::all();
            $users = Admin::all();

            return view('admin.assign_role.create', [
                'roles'             => $roles,
                'users'             => $users,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id'           => 'required',
            'user_id'           => 'required',
        ]);

        try {
            $user = Admin::findOrFail($request->user_id);
            $role = Role::findOrFail($request->role_id);

            // delete previous roles
            $user->syncRoles([]);
            $user->assignRole($role);

            return back()->with('success', 'Role assigned into user');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($userId)
    {
        try {
            $roles = Role::all();
            $users = Admin::all();

            // get role id
            $user = Admin::findOrFail($userId);
            $roleName = $user->getRoleNames()->first(); // Get the first role name
            $roleId = \Spatie\Permission\Models\Role::findByName($roleName)->id;

            return view('admin.assign_role.edit', [
                'userId'         => $userId,
                'roleId'         => $roleId,
                'users'          => $users,
                'roles'          => $roles,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $userId)
    {
        $request->validate([
            'role_id'           => 'required',
        ]);

        try {
            $user = Admin::findOrFail($userId);
            $role = Role::findOrFail($request->role_id);

            // delete previous roles
            $user->syncRoles([]);
            $user->assignRole($role);

            return redirect()->route('admin.assign_role.index')->with('success', 'Role assigned into user');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($userId)
    {
        try {
            $user = Admin::findOrFail($userId);
            $user->syncRoles([]);

            return back()->with('success', 'Role removed from user');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
