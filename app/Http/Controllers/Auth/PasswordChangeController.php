<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    //
    public function showChangePasswordForm()
    {
    return view('auth.password-change');
    }

    public function changePassword(Request $request)
    {
    $user = Auth::user()->roles;

    $this->validate($request, [
        'password' => 'required|confirmed|min:8',
    ]);

    $user->update([
        'password' => Hash::make($request->password),
        'must_change_password' => false,
    ]);

    return redirect()->route('home'); // Ganti dengan rute yang sesuai setelah mengubah kata sandi
    }

}
