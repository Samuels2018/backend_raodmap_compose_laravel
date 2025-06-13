<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\WorkoutLog;


class WorkoutLogController extends Controller {

  private function validateWorkoutLog($data) {
    return Validator::make($data, [
      'workout_id' => 'required|exists:workouts,id',
      'completed_at' => 'required|date',
      'notes' => 'nullable|string',
      'duration_minutes' => 'nullable|integer|min:1',
    ]);
  }
  
  /*public function __construct() {
    $this->middleware('auth:api');
  }*/

  public function index() {
    $user = auth()->user();
    $logs = $user->workoutLogs()->with('workout.exercises')->orderBy('completed_at', 'desc')->get();
    return response()->json($logs);
  }

  public function store(Request $request) {
    $validator = $this->validateWorkoutLog($request->all());

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $user = auth()->user();
    
    // Verify the workout belongs to the user
    $workout = $user->workouts()->findOrFail($request->workout_id);

    $log = $user->workoutLogs()->create([
      'workout_id' => $workout->id,
      'completed_at' => $request->completed_at,
      'notes' => $request->notes,
      'duration_minutes' => $request->duration_minutes,
    ]);

    // Mark workout as completed
    $workout->update(['completed' => true]);

    return response()->json($log->load('workout.exercises'), 201);
  }

  public function show(string $id) {
    $user = auth()->user();
    $log = $user->workoutLogs()->with('workout.exercises')->findOrFail($id);
    return response()->json($log);
  }

  public function update(Request $request, string $id) {
    $validator = Validator::make($request->all(), [
      'completed_at' => 'sometimes|date',
      'notes' => 'nullable|string',
      'duration_minutes' => 'nullable|integer|min:1',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $user = auth()->user();
    $log = $user->workoutLogs()->findOrFail($id);
    $log->update($request->all());

    return response()->json($log->load('workout.exercises'));
  }


  public function destroy(string $id) {
    $user = auth()->user();
    $log = $user->workoutLogs()->findOrFail($id);
    $log->delete();
    return response()->json(['message' => 'Workout log deleted successfully']);
  }


  public function progressReport() {
    $user = auth()->user();
    
    $report = [
      'total_workouts' => $user->workoutLogs()->count(),
      'total_duration' => $user->workoutLogs()->sum('duration_minutes'),
      'workouts_by_month' => $user->workoutLogs()
        ->selectRaw('YEAR(completed_at) as year, MONTH(completed_at) as month, COUNT(*) as count')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get(),
      'recent_workouts' => $user->workoutLogs()
        ->with('workout.exercises')
        ->orderBy('completed_at', 'desc')
        ->limit(5)
        ->get(),
    ];

    return response()->json($report);
  }

}
