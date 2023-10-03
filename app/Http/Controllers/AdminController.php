<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view("admin.pages.dashboard");
    }

    public function orders(){
        return view("admin.pages.orders");
    }
}
