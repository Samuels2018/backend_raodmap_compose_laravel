<?php

namespace App\Models\order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\user\User;
use App\Models\order\OrderItem;

class Order extends Model {
  use HasFactory;

  protected $fillable = [
    'user_id',
    'total',
    'status',
    'stripe_payment_id'
  ];

  public function user () {
    return $this->belongsTo(User::class);
  }

  public function item () {
    return $this->hasMany(OrderItem::class);
  }
}
