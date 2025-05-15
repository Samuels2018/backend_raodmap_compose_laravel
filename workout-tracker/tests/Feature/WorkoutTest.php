<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Exercise;
use App\Models\User;

class WorkoutTest extends TestCase {
  use RefreshDatabase;
  protected $user;
  protected $token;


  protected function setUp(): void {
    parent::setUp();

    $this->user = User::factory()->create();
    $this->token = auth()->login($this->user);
    Exercise::factory()->count(5)->create();
  }

  public function test_create_workout() {
    $exercises = Exercise::limit(2)->get();

    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $this->token,
    ])->postJson('/api/workouts', [
      'title' => 'Test Workout',
      'description' => 'Test description',
      'scheduled_at' => now()->addDay()->toDateTimeString(),
      'exercises' => [
        [
          'exercise_id' => $exercises[0]->id,
          'sets' => 3,
          'repetitions' => 10,
          'weight' => 50,
        ],
        [
          'exercise_id' => $exercises[1]->id,
          'sets' => 4,
          'repetitions' => 12,
          'weight' => 30,
        ],
      ]
    ]);

    $response->assertStatus(201)
      ->assertJsonStructure([
        'id', 'title', 'description', 'exercises'
      ]);
  }

  public function test_get_workouts() {
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $this->token,
    ])->getJson('/api/workouts');

    $response->assertStatus(200);
  }
}
