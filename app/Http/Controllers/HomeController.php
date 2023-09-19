<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
//        $products = Product::where("qty",">",30)
//                        ->where("price",">",500)
//                        ->where("name","like","%Olson%")
//                        ->orderBy("created_at","desc")
//                        ->limit(12)
//                        ->get();
        $products = Product::orderBy("created_at","desc")->paginate(12);
        return view("pages.home",compact("products"));
    }
    public function aboutUs(){
        return view("pages.aboutus");
    }

    public function category(Category $category){
        // dựa vào id tìm category
        // nếu ko tồn tại -> 404
//        $category = Category::find($id);
//        if($category == null){
//            return abort(404);
//        }

//        $category = Category::findOrFail($id);

        $products = Product::where("category_id",$category->id)
            ->orderBy("created_at","desc")->paginate(12);
        return view("pages.category",compact("products"));
    }
}
