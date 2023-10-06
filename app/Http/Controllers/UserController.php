<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($request->get('email') == 'admin@gmail.com' && $request->get('password') == 'admin@123') {
            Auth::attempt($admin);
            return redirect("/admin");
        }
        return back()->withInput($request->input())->with('danger', "Incorrect password or login");
    }
}
