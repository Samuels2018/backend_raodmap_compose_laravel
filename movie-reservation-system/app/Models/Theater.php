<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Showtime;
use App\Models\Seat;

class Theater extends Model {
  use HasFactory;
  protected $fileable = [
    'name', 'city'
  ];

  public function showtimes () {
    return $this->hasMany(Showtime::class);
  }

  public function seats () {
    return $this->hasMany(Seat::class);
  }
}
