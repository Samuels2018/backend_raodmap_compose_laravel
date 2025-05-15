<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder {

  public function run(): void {
    $exercises = [
      // Cardio
      [
        'name' => 'Running',
        'description' => 'Outdoor or treadmill running',
        'category' => 'cardio',
        'muscle_group' => 'legs'
      ],
      [
        'name' => 'Cycling',
        'description' => 'Stationary or outdoor cycling',
        'category' => 'cardio',
        'muscle_group' => 'legs'
      ],
      [
        'name' => 'Swimming',
        'description' => 'Freestyle swimming',
        'category' => 'cardio',
        'muscle_group' => 'full body'
      ],
      
      // Strength - Chest
      [
        'name' => 'Bench Press',
        'description' => 'Barbell bench press',
        'category' => 'strength',
        'muscle_group' => 'chest'
      ],
      [
        'name' => 'Push-ups',
        'description' => 'Bodyweight push-ups',
        'category' => 'strength',
        'muscle_group' => 'chest'
      ],
      
      // Strength - Back
      [
        'name' => 'Pull-ups',
        'description' => 'Bodyweight pull-ups',
        'category' => 'strength',
        'muscle_group' => 'back'
      ],
      [
        'name' => 'Deadlift',
        'description' => 'Barbell deadlift',
        'category' => 'strength',
        'muscle_group' => 'back'
      ],
      
      // Strength - Legs
      [
        'name' => 'Squats',
        'description' => 'Barbell squats',
        'category' => 'strength',
        'muscle_group' => 'legs'
      ],
      [
        'name' => 'Lunges',
        'description' => 'Bodyweight or weighted lunges',
        'category' => 'strength',
        'muscle_group' => 'legs'
      ],
      
      // Flexibility
      [
        'name' => 'Yoga',
        'description' => 'General yoga practice',
        'category' => 'flexibility',
        'muscle_group' => 'full body'
      ],
      [
        'name' => 'Stretching',
        'description' => 'General stretching routine',
        'category' => 'flexibility',
        'muscle_group' => 'full body'
      ],
    ];

    foreach ($exercises as $exercise) {
        Exercise::create($exercise);
    }
  }
}
