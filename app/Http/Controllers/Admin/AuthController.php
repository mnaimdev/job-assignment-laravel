<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SendingResponse;
use App\Http\Controllers\Controller;
use App\Mail\PasswordResetEmail;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required',
            'email'     => 'required|unique:users,email',
            'password'      => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/'
            ]

        ], [
            'password.regex'  => 'Password must contain one capital letter, one small letter, one number, one special character and minimum 8 characters long'
        ]);

        try {
            $data['password']   = Hash::make($request->password);
            $user = User::create($data);
            $token = $user->createToken('mytoken')->plainTextToken;

            return SendingResponse::response('success', 'Registered Successfully', $user, $token, 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'         => 'required',
            'password'      => 'required',
        ]);

        try {
            if (Auth::attempt($data)) {
                $user = Auth::user();
                $token = $user->createToken('mytoken')->plainTextToken;

                return SendingResponse::response('success', 'Logged In Successfully', $user, $token, 200);
            } else {
                return SendingResponse::handleException('error', 'Invalid Email Or Password');
            }
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();

        return SendingResponse::response('success', 'Logout Successfully', '', '', 200);
    }
}
