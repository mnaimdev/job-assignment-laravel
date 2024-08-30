<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SendingResponse;
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
            $users = User::all();

            $userWithRoles = $users->map(function ($user) {
                return [
                    'id'            => $user->id,
                    'name'          => $user->name,
                    'roles'         => $user->getRoleNames(),
                ];
            });

            return SendingResponse::response('success', 'Assigned User', $userWithRoles, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'role_id'           => 'required',
            'user_id'           => 'required',
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            $role = Role::findOrFail($request->role_id);

            // Delete previous roles and assign new role
            $user->syncRoles([$role]);

            return SendingResponse::response('success', 'Role Assigned to User', $data, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function edit($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $roleName = $user->getRoleNames()->first(); // Get the first role name
            $roleId = \Spatie\Permission\Models\Role::findByName($roleName)->id;

            $data  = ['user_id' => $userId, 'role_id' => $roleId];

            return SendingResponse::response('success', 'Assigned Role', $data, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function update(Request $request, $userId)
    {
        $request->validate([
            'role_id'           => 'required',
        ]);

        try {
            $user = User::findOrFail($userId);
            $role = Role::findOrFail($request->role_id);

            // delete previous roles
            $user->syncRoles([$role]);

            $data = ['user_id'  => $user->id, 'role_id' => $role->id];

            return SendingResponse::response('success', 'Role Assigned to User', $data, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function delete($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->syncRoles([]);

            return SendingResponse::response('success', 'Role Removed from User', '', '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
