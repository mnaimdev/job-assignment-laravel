<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();

            return SendingResponse::response('success', 'Role Lists', $roles, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|unique:roles,name',
        ]);

        try {
            $role = Role::create($data);

            return SendingResponse::response('success', 'Created Successfully', $role, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function edit(Role $role)
    {
        try {
            return SendingResponse::response('success', 'Role', $role, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'          => 'required|unique:roles,name,' . $role->id,
            'guard_name'    => 'web',
        ]);

        try {
            $role->update($data);

            return SendingResponse::response('success', 'Updated Successfully', $data, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
