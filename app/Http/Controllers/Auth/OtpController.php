<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\User;

class OtpController extends Controller
{
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $otp = $request->session()->get('otp');
        $email = $request->session()->get('email');

        if (!$otp || !$email) {
             return redirect()->route('password.request')->withErrors(['email' => 'Session expired. Please request a new OTP.']);
        }

        if ($request->otp == $otp) {
            $request->session()->forget(['otp', 'email']);

            $user = User::where('email', $email)->first();
            
            if (!$user) {
                return redirect()->route('password.request')->withErrors(['email' => 'User not found.']);
            }

            $token = Password::createToken($user);

            // OTP is correct, redirect to reset password form with email and token
            return redirect()->route('password.reset', ['token' => $token, 'email' => $email]);
        } else {
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }
    }
}
