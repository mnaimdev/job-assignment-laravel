<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::orderBy('id', 'DESC')->get();
            return view('admin.permission.index', [
                'permissions'      => $permissions,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create()
    {
        try {
            return view('admin.permission.create');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|unique:permissions,name',
            'group_name'        => 'required',

        ]);

        try {
            Permission::create($data);

            return back()->with('success', 'Created Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit(Permission $permission)
    {
        try {
            return view('admin.permission.edit', [
                'permission'            => $permission,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name'              => 'required|unique:permissions,name,' . $permission->id,
            'group_name'        => 'required',
        ]);

        try {
            $permission->update($data);

            return redirect()->route('admin.permission.index')->with('success', 'Updated Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
