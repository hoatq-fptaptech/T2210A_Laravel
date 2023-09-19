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
      "status",
      "user_id",
      "full_name",
      "tel",
      "address",
      "shipping_method",
      "payment_method",
      "is_paid",
    ];
}
