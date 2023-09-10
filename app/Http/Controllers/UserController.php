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
        $request->validate([
            "email" => ['required'],
            "password" => ['required']
        ]);
        if ($request->get('email') == 'admin@gmail.com' && $request->get('password') == 'admin@123') {
            Auth::login();
            return redirect("/admin");
        }
        return redirect("/register")->with('danger', "Incorrect password or login");
    }
}
