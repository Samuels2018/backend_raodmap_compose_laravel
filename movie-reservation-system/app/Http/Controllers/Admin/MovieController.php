<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller {
  
  public function __construct() {
    $this->middleware('auth');
    $this->middleware('admin');
  }

  public function index() {
    $movies = Movie::with('genres')->latest()->paginate(10);
    return view('admin.movies.index', compact('movies'));
  }

  public function create() {
    $genres = Genre::all();
    return view('admin.movies.create', compact('genres'));
  }

  
  public function store(Request $request) {
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'duration_minutes' => 'required|integer|min:1',
      'poster_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      'genres' => 'required|array',
      'genres.*' => 'exists:genres,id',
    ]);

    $path = $request->file('poster_image')->store('posters', 'public');

    $movie = Movie::create([
      'title' => $validated['title'],
      'description' => $validated['description'],
      'duration_minutes' => $validated['duration_minutes'],
      'poster_image' => $path,
    ]);

    $movie->genres()->sync($validated['genres']);

    return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully.');
  }

  public function edit(Movie $movie) { //string $id
    $genres = Genre::all();
    return view('admin.movies.edit', compact('movie' ,'genres'));
  }

  public function update(Request $request, Movie $movie) { //string $id
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'duration_minutes' => 'required|integer|min:1',
      'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'genres' => 'required|array',
      'genres.*' => 'exists:genres,id',
    ]);

    if ($request->hasFile('poster_image')) {
      Storage::disk('public')->delete($movie->poster_image);
      $path = $request->file('poster_image')->store('posters', 'public');
      $movie->poster_image = $path;
    }

    $movie->title = $validated['title'];
    $movie->description = $validated['description'];
    $movie->duration_minutes = $validated['duration_minutes'];
    $movie->save();

    $movie->genres()->sync($validated['genres']);

    return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully.');
  }

  public function destroy(Movie $movie) { //string $id
    $storage::disk('public')->delete($movie->poster_image);
    $movie->delete();
    return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully.');
  }
}
