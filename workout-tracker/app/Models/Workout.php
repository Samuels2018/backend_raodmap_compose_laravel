<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Exercise;
use App\Models\WorkoutLog;

class Workout extends Model {
  use HasFactory;

  protected $fileable = [
    'user_id',
    'title',
    'description',
    'scheduled_at',
    'completed',
    'comments'
  ];

  protected $casts = [
    'scheduled_at' => 'datetime',
    'completed' => 'boolean',
  ];

  public function user () {
    return $this->belongsTo(User::class);
  }

  public function exercises () {
    return $this->belongsToMany(Exercise::class, 'workout_exercises')
      ->withPivot('sets', 'repetitions', 'weight', 'notes')
      ->withTimestamps();
  }

  public function workoutLogs () {
    return $this->hasMany(WorkoutLog::class);
  }
}
