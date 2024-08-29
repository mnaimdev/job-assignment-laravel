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
            'password'  => 'required',
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


    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email'             => 'required',
        ]);

        try {
            if (User::where('email', $request->email)->exists()) {
                $user = User::where('email', $request->email)->first();

                $otp = rand(111111, 999999);
                Otp::where('user_id', $user->id)->delete();

                Otp::create([
                    'user_id'               => $user->id,
                    'otp'                   => $otp,
                    'expired_at'            => Carbon::now()->addMinute(5),
                ]);

                Mail::to($request->email)->send(new PasswordResetEmail($user->id, $user->email, $otp));

                return SendingResponse::response('success', 'We have send you a email to reset your password', '', '', 200);
            } else {
                return SendingResponse::handleException('error', 'Incorrect Email Address');
            }
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password'      => 'required',
            'otp'           => 'required',
        ]);

        try {
            $otp = $request->otp;

            if (Otp::where('otp', $otp)->exists()) {
                $selectedOtp = Otp::where('otp', $otp)->firstOrFail();

                if (Carbon::now()->isAfter($selectedOtp->expired_at)) {
                    return SendingResponse::handleException('error', 'Otp expired!');
                }

                $user = User::findOrFail($selectedOtp->user_id);
                $user->update([
                    'password'      => Hash::make($request->password),
                ]);

                Otp::where('otp', $otp)->delete();

                return SendingResponse::response('success', 'Password Reset Successful', '', '', 200);
            } else {
                return SendingResponse::handleException('error', 'Wrong otp code!');
            }
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
        }
    }
}
