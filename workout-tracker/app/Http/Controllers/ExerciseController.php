<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use Illuminate\Support\Facades\Validator;

class ExerciseController extends Controller {
  private function validateExercise($data) {
    return Validator::make($data, [
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'category' => 'required|string|max:100',
      'muscle_group' => 'required|string|max:100',
    ]);
  }

  public function index() {
    $exercises = Exercise::all();
    return response()->json($exercises);
  }

  public function show(string $id) {
    $exercises = Exercise::find($id);
    return response()->json($exercises);
  }

  public function filter (Request $request) {
    $query = Exercise::query();

    if ($query->has('category')) {
      $query->where('category', $request->category);
    }

    if ($query->has('muscle_group')) {
      $query->where('muscle_group', $request->muscle_group);
    }

    $exercises = $query->get();
    return response()->json($exercises);
  }

  public function store(Request $request) {
    $validator = $this->validateExercise($request->all());

    $exercise = Exercise::create($request->all());
    return response()->json($exercise, 201);
  }
}
