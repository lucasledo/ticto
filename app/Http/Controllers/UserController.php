<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function editPassword()
    {
        return view('user.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {

            if($request->ajax() || $request->wantsJson()){
                return response()->json(['error' => 'A senha atual não confere.'], 422);
            }

            return back()->withErrors(['current_password' => 'A senha atual não confere.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        if($request->ajax() || $request->wantsJson()){
            return response()->json(['success' => 'Senha alterada com sucesso!']);
        }

        return back()->with('success', 'Senha alterada com sucesso!');
    }
}
