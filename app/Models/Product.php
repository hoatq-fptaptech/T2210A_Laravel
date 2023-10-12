<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;// trait

    protected $table = "products";

    protected $fillable = [
        "name",
        "slug",
        "price",
        "thumbnail",
        "description",
        "qty",
        "category_id"
    ];

    public function Category(){ // model relationship
        return $this->belongsTo(Category::class);
    }

    public function Orders(){
        return $this->belongsToMany(Order::class,"order_products");
    }

    public function scopeSearch($query,$request){
        if($request->has("search")&& $request->get("search") != ""){
            $search = $request->get("search");
            $query->where("name","like","%$search%")
                ->orWhere("description","like","%$search%");
        }
        return $query;
    }

    public function scopeFilterCategory($query,$request){
        if($request->has("category_id")&& $request->get("category_id") != 0){
            $category_id = $request->get("category_id");
            $query->where("category_id",$category_id);
        }
        return $query;
    }

    public function scopeFromPrice($query,$request){
        if($request->has("price_from")&& $request->get("price_from") != 0){
            $price_from= $request->get("price_from");
            $query->where("price",">=",$price_from);
        }
        return $query;
    }
    public function scopeToPrice($query,$request){
        if($request->has("price_to")&& $request->get("price_to") != 0){
            $price_to= $request->get("price_to");
            $query->where("price","<=",$price_to);
        }
        return $query;
    }
}
