<?php

namespace App\Models\order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\order\Order;
use App\Models\product\Product;

class OrderItem extends Model {
  use HasFactory;

  protected $fillable = [
    'order_id',
    'product_id',
    'quantity',
    'price',
  ];

  public function order () {
    return $this->belongsTo(Order::class);
  }

  public function product () {
    return $this->belongsTo(Product::class);
  }
}
