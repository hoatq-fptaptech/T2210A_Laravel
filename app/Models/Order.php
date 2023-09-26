<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
      "grand_total",
        "email",
      "status",
      "user_id",
      "full_name",
      "tel",
      "address",
      "shipping_method",
      "payment_method",
      "is_paid",
    ];

    public function Products(){
        return $this->belongsToMany(Product::class,"order_products")->withPivot(["qty","price"]);
    }
}
