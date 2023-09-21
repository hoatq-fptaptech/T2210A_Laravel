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

    public function product(Product $product){
        $relateds = Product::where("category_id",$product->category_id)
                ->where("id","!=",$product->id)
                ->where("qty",">",0)
                ->orderBy("created_at","desc")
                ->limit(4)
                ->get();
        return view("pages.product",compact("product","relateds"));
    }

    public function addToCart(Product $product, Request $request){
        $buy_qty = $request->get("buy_qty");
        $cart = session()->has("cart")?session("cart"):[];
        foreach ($cart as $item){
            if($item->id == $product->id){
                $item->buy_qty = $item->buy_qty + $buy_qty;
                session(["cart"=>$cart]);
                return redirect()->back()->with("success","Đã thêm sản phẩm vào giỏ hàng");
            }
        }
        $product->buy_qty = $buy_qty;
        $cart[] = $product;
        session(["cart"=>$cart]);
        return redirect()->back()->with("success","Đã thêm sản phẩm vào giỏ hàng");
    }
    public function cart(){
        $cart = session()->has("cart")?session("cart"):[];
        $subtotal = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $subtotal += $item->price * $item->buy_qty;
            if($item->buy_qty > $item->qty)
                $can_checkout = false;
        }
        $total = $subtotal*1.1; // vat: 10%
        return view("pages.cart",compact("cart","subtotal","total","can_checkout"));
    }
}
