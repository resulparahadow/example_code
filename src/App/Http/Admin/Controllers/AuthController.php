<?php

namespace App\Http\Admin\Controllers;

use App\Http\BaseController;
use Illuminate\Http\Request;
use Domain\Staffs\Models\Staff;
use Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function showLoginPage()
    {
        return view('admin.auth.login');
    }

    public function login(Request $r)
    {
        $r->validate([
            'email'    => 'required|email|exists:staffs',
            'password' => 'required|string'
        ]);

        $user = Staff::where('email', $r->email)
        ->where('role', 'admin')
        ->first();

        if (!Hash::check($r->password, $user->password)) {
            return back()
                    ->withInput()
                    ->withErrors(['password' => 'invalid password']);
        }

        Auth::guard('admin')->login($user, (bool)$r->remember);

        return redirect()
                ->route('admin.dashboard');
    }

    public function logout(Request $r)
    {
        Auth::guard('admin')->logout();

        return redirect()
                ->route('admin.login.page');
    }

    public function changePassword(
        Request $r
    ) {
        $r->validate([
            'old_password'          => 'required|string',
            'password'              => 'required|string|confirmed',
            'password_confirmation' => 'required|string'
        ]);

        $user = $r->user('admin');


        if (!Hash::check($r->password, $user->password)) {
            return back()
                    ->withErrors(['old_password' => 'invalid password']);
        }

        Staff::where('email', $user->email)->update([
            'password' => Hash::make($r->password)
        ]);

        return redirect()
                ->back()
                ->with('success', 'Password successfully changed');
    }
}
