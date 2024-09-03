<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
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
            // Eager load roles with the users
            $users = User::with('roles')->get();

            // Map the users to include roles
            $userWithRoles = $users->map(function ($user) {
                return [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'roles' => $user->getRoleNames(),
                ];
            });

            return SendingResponse::response('success', 'Assigned Users', $userWithRoles, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'role_id' => 'required',
            'user_id' => 'required',
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            $role = Role::findOrFail($request->role_id);

            // Delete previous roles and assign the new role
            $user->syncRoles([$role]);

            // Return the user with updated roles
            $userWithRoles = [
                'id'    => $user->id,
                'name'  => $user->name,
                'roles' => $user->getRoleNames(),
            ];

            return SendingResponse::response('success', 'Role Assigned to User', $userWithRoles, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function edit($userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Get the first role name, if any
            $roleName = $user->getRoleNames()->first();

            if (!$roleName) {
                return SendingResponse::response('error', 'No role assigned to this user', null, '', 404);
            }

            $roleId = Role::findByName($roleName)->id;

            $data = [
                'user_id' => $userId,
                'role_id' => $roleId,
            ];

            return SendingResponse::response('success', 'Assigned Role', $data, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function update(Request $request, $userId)
    {
        $request->validate([
            'role_id' => 'required',
        ]);

        try {
            $user = User::findOrFail($userId);
            $role = Role::findOrFail($request->role_id);

            // Sync the user's roles, assigning only the specified role
            $user->syncRoles([$role]);

            $data = ['user_id' => $user->id, 'role_id' => $role->id];

            return SendingResponse::response('success', 'Role Assigned to User', $data, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function delete($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->syncRoles([]); // Clear all roles from the user

            return SendingResponse::response('success', 'All roles removed from user successfully', '', '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
