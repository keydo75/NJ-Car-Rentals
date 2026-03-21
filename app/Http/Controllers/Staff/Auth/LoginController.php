<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:staff')->except('logout');
    }

    public function showLoginForm()
    {
        return view('staff.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('staff')->attempt(
            ['username' => $request->username, 'password' => $request->password],
            $request->remember
        )) {
            return redirect()->intended(route('staff.dashboard'));
        }

        return redirect()->back()->withInput($request->only('username', 'remember'))
            ->withErrors(['username' => 'These credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        return redirect()->route('staff.login');
    }
}