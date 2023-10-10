<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function loginPage()
    {
        if (Auth::check())
            return redirect(route('dashboard'));
        return view("pages.login");
    }

    public function login(Request $request)
    {
        $admin = $request->validate([
            "email" => ['required'],
            "password" => ['required']
        ]);
        if (Auth::attempt($admin)) {
            return redirect(route('dashboard'));
        }
        return back()->withInput($request->input())->with('danger', "Incorrect password or login");
    }

    public function changePasswordPage()
    {
        return view("pages.change-password");
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            "current_password" => "required",
            "new_password" => "required",
            "confirm_new_password" => "required|same:new_password",
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            throw ValidationException::withMessages(["new_password" => "Your current password is incorrect."]);
        }

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect(route('dashboard'))->with('success', 'Password changed successfully');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('loginPage'));
    }
}
