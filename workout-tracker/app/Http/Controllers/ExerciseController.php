<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;

class ExerciseController extends Controller {
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
}
