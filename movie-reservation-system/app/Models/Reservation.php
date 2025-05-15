<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model {
  use HasFactory;

  protected $fileable = [
    'user_id', 
    'showtime_id', 
    'seat_id', 
    'reservation_code', 
    'price', 
    'status'
  ];

  public function user () {
    return $this->belongsTo(User::class);
  }

  public function showtime () {
    return $this->belongsTo(Showtime::class);
  }

  public function seat () {
    return $this->belongsTo(Seat::class);
  }

  public function scopeUpcoming ($query) {
    return $query->whereHas('showtime', function ($query) {
      $query->where('start_time', '>', now());
    });
  }
}
