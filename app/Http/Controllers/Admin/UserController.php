<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();

            return SendingResponse::response('success', 'User Lists', $users, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required',
            'role'      => 'required',
            'email'     => 'required|unique:users,email,',
            'password'  => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'
            ]
        ], [
            'password.regex'  => 'Password must contain one capital letter, one small letter, one number, one special character'
        ]);

        try {
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);

            return SendingResponse::response('success', 'Created Successfully', $user, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        try {
            return SendingResponse::response('success', 'User', $user, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'          => 'required',
            'role'          => 'required',
            'email'         => 'required|unique:users,email,' . $user->id,
            'password'      => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'
            ]
        ], [
            'password.regex'  => 'Password must contain one uppercase, one lowercase, one number, one special character'
        ]);

        try {
            $user->update($data);

            return SendingResponse::response('success', 'Updated Successfully', $user, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function delete(User $user)
    {
        try {
            if (!empty($user->image)) {
                ImageHelper::removeImage($user->image, '/uploads/user/');
            }
            $user->delete();

            return SendingResponse::response('success', 'Deleted Successfully', '', '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
