<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Movie;

class Genre extends Model {
  use HasFactory;

  protected $filleable = [
    'name',
  ];

  public function movies () {
    return $this->hasMany(Movie::class);
  }
}
