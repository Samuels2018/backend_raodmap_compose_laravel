<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\WorkoutExercise;
use Illuminate\Support\Facades\Validator;

class WorkoutController extends Controller {

  private function validateWorkout ($data) {
    return Validator::make($data, [
      'title' => 'required|string|max:255',
      'description' => 'nullable|string',
      'scheduled_at' => 'required|date',
      'exercises' => 'required|array',
      'exercises.*.exercise_id' => 'required|exists:exercises,id',
      'exercises.*.sets' => 'required|integer|min:1',
      'exercises.*.repetitions' => 'required|integer|min:1',
      'exercises.*.weight' => 'nullable|numeric|min:0',
      'exercises.*.notes' => 'nullable|string',
    ]);
  }

  private function validateUpdateWorkout ($data) {
    return Validator::make($data, [
      'title' => 'sometimes|string|max:255',
      'description' => 'nullable|string',
      'scheduled_at' => 'sometimes|date',
      'completed' => 'sometimes|boolean',
      'comments' => 'nullable|string',
      'exercises' => 'sometimes|array',
      'exercises.*.id' => 'sometimes|exists:workout_exercises,id',
      'exercises.*.exercise_id' => 'sometimes|exists:exercises,id',
      'exercises.*.sets' => 'sometimes|integer|min:1',
      'exercises.*.repetitions' => 'sometimes|integer|min:1',
      'exercises.*.weight' => 'nullable|numeric|min:0',
      'exercises.*.notes' => 'nullable|string',
    ]);
  }
  
  public function __construct () {
    $this->middleware('auth:api');
  }

  public function index() {
    $user = auth()->user();
    $workouts = $user->workouts()->with('exercises')->orderBy('scheduled_at')->get();
    return response()->json($workouts);
  }

  public function store(Request $request) {
    $validator = $this->validateWorkout($request->all());


    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $user = auth()->user();
    $workout = $user->workouts()->create($request->only([
      'title', 'description', 'scheduled_at'
    ]));

    foreach ($request->exercises as $exercise) {
      $workout->exercises()->attach($exercise['exercise_id'], [
        'sets' => $exercise['sets'],
        'repetitions' => $exercise['repetitions'],
        'weight' => $exercise['weight'] ?? null,
        'notes' => $exercise['notes'] ?? null,
      ]);
    }

    return response()->json($workout->load('exercises'), 201);
  }

  public function show(string $id) {
    $user = auth()->user();
    $workout = user->workouts()->with('exercises')->findOrFail($id);
    return response()->json($workout);
  }

  public function update(Request $request, string $id) {
    $validator = $this->validateUpdateWorkout($request->all());

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $user = auth()->user();
    $workout = $user->workouts()->findOrFail($id);

    $workout->update($request->only([
      'title', 'description', 'scheduled_at', 'completed', 'comments'
    ]));

    if ($request->has('exercises')) {
      foreach ($request->exercises as $exerciseData) {
        if (isset($exerciseData['id'])) {
          // Update existing exercise
          WorkoutExercise::where('id', $exerciseData['id'])
            ->where('workout_id', $workout->id)
            ->update([
              'sets' => $exerciseData['sets'],
              'repetitions' => $exerciseData['repetitions'],
              'weight' => $exerciseData['weight'] ?? null,
              'notes' => $exerciseData['notes'] ?? null,
            ]);
        } else {
          // Add new exercise
          $workout->exercises()->attach($exerciseData['exercise_id'], [
            'sets' => $exerciseData['sets'],
            'repetitions' => $exerciseData['repetitions'],
            'weight' => $exerciseData['weight'] ?? null,
            'notes' => $exerciseData['notes'] ?? null,
          ]);
        }
      }
    }

    return response()->json($workout->fresh()->load('exercises'));
  }


  public function destroy(string $id) {
    $user = auth()->user();
    $workout = $user->workouts()->findOrFail($id);
    $workout->delete();
    return response()->json(['message' => 'Workout deleted successfully']);
  }


  public function upcoming() {
    $user = auth()->user();
    $workouts = $user->workouts()
      ->where('completed', false)
      ->where('scheduled_at', '>=', now())
      ->with('exercises')
      ->orderBy('scheduled_at')
      ->get();
        
    return response()->json($workouts);
  }

  public function past(){
    $user = auth()->user();
    $workouts = $user->workouts()
      ->where('completed', true)
      ->orWhere('scheduled_at', '<', now())
      ->with('exercises')
      ->orderBy('scheduled_at', 'desc')
      ->get();
        
    return response()->json($workouts);
  }

}
