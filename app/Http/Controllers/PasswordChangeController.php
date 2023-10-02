<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    //
    public function edit()
    {
    return view('auth.password_change');
    }

public function update(Request $request)
{
    $user = Auth::user();
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user->where('id',$user->id)->update([
            'password' => Hash::make($request->password),
            'password_changed' => true
    ]);

    return redirect('/home')->with('success', 'Password successfully changed.');
}

}
