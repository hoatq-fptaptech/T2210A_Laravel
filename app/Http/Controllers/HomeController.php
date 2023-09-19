<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $products = Product::where("qty",">",30)
                        ->where("price",">",500)
                        ->orderBy("created_at","desc")
                        ->limit(12)
                        ->get();
        return view("pages.home",compact("products"));
    }
    public function aboutUs(){
        return view("pages.aboutus");
    }
}
