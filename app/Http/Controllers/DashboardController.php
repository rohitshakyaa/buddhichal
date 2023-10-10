<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardPage()
    {
        return view("errors.dev");
        return view("pages.dashboard");
    }
}
