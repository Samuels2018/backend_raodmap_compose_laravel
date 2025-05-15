<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Theater;
use App\Models\Reservation;

class Seat extends Model {
  use HasFactory;

  private $fileable = [
    'theater_id', 
    'row', 
    'number'
  ];

  public function theater() {
    return $this->belongsTo(Theater::class);
  }

  public function reservations() {
    return $this->hasMany(Reservation::class);
  }
}
