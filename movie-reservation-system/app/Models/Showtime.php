<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Reservation;
use App\Models\Seat;

class Showtime extends Model {
  use HasFactory;

  protected $fileable = [
    'movie_id', 
    'theater_id', 
    'start_time', 
    'end_time'
  ];

  protected $dates = [
    'start_time', 
    'end_time'
  ];

  public function movie () {
    return $this->belongsTo(Movie::class);
  }

  public function theater () {
    return $this->belongsTo(Theater::class);
  }

  public function reservations () {
    return $this->hasMany(Reservation::class);
  }

  public function availableSeats () {
    $reservedSeats = $this->reservations()->pluck('seat_id');
    return Seat::where('theater_id', $this->theater_id)
      ->whereNotIn('id', $reservedSeats)
      ->get();
  }
}
