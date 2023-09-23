<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function checkout(){
        $cart = session()->has("cart")?session("cart"):[];
        $subtotal = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $subtotal += $item->price * $item->buy_qty;
            if($item->buy_qty > $item->qty)
                $can_checkout = false;
        }
        $total = $subtotal*1.1; // vat: 10%
        if(count($cart)==0 || !$can_checkout){
            return redirect()->to("cart");
        }
        return view("pages.checkout",compact("cart","subtotal","total"));
    }

    public function placeOrder(Request $request){
         $request->validate([
             "full_name"=>"required|min:6",
             "address"=>"required",
             "tel"=> "required|min:9|max:11",
             "email"=>"required",
             "shipping_method"=>"required",
             "payment_method"=>"required"
         ],[
             "required"=>"Vui lòng nhập thông tin."
         ]);
         // calculate
        $cart = session()->has("cart")?session("cart"):[];
        $subtotal = 0;
        foreach ($cart as $item){
            $subtotal += $item->price * $item->buy_qty;
        }
        $total = $subtotal*1.1; // vat: 10%
        $order = Order::create([
             "grand_total"=>$total,
             "full_name"=>$request->get("full_name"),
             "email"=>$request->get("email"),
             "tel"=>$request->get("tel"),
             "address"=>$request->get("address"),
             "shipping_method"=>$request->get("shipping_method"),
             "payment_method"=>$request->get("payment_method")
         ]);
        foreach ($cart as $item){
            DB::table("order_products")->insert([
                "order_id"=>$order->id,
                "product_id"=>$item->id,
                "qty"=>$item->buy_qty,
                "price"=>$item->price
            ]);
            $product = Product::find($item->id);
            $product->update(["qty"=>$product->qty- $item->buy_qty]);
        }
        // clear cart
        session()->forget("cart");
        return redirect()->to("thank-you")->with("order",$order);
    }
}
