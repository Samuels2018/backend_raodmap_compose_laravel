<?php

namespace App\Models\cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\user\User;
use App\Models\product\Product;
use App\Models\cart\CartItem;

class Cart extends Model {
  use HasFactory;

  protected $fillable = ['user_id'];

  public function user () {
    return $this->belongsTo(User::class);
  }

  public function item () {
    return $this->hasMany(CartItem::class);
  }

  public function products () {
    return $this->belongsToMany(Product::class, 'cart_items')
      ->withPivot('quantity')
      ->withTimestamps();
  }
}
