<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Genre;
use App\Models\Showtime;

class Movie extends Model {
  use HasFactory;

  protected $fileable = [
    'title', 
    'description', 
    'poster_image', 
    'duration_minutes'
  ];


  public function genres () {
    return $this->belongsToMAny(Genre::class);
  }


  public function showtimes () {
    return $this->hasMany(Showtime::class);
  }
}
