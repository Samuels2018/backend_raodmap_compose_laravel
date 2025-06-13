<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Workout;

class WorkoutLog extends Model {
  use HasFactory;

  protected $fillable = [
    'user_id',
    'workout_id',
    'completed_at',
    'notes',
    'duration_minutes'
  ];

  protected $casts = [
    'completed_at' => 'datetime',
  ];

  public function user () {
    return $this->belongsTo(User::class);
  }

  public function workout () {
    return $this->belongsTo(Workout::class);
  }
}
