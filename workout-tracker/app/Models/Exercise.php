<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exercise extends Model {
  use HasFactory;

  protected $fileable = [
    'name',
    'description',
    'category',
    'muscle_group'
  ];

  public function workouts () {
    return $this->belongsToMany(Workout::class, 'exercise_workout')
      ->withPivot('sets', 'repetitions', 'weight', 'notes')
      ->withTimestamps();
  }
}
