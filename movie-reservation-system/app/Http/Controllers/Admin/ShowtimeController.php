<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Theater;
use Carbon\Carbon;

class ShowtimeController extends Controller {
  
  public function __construct() {
    $this->middleware('auth');
    $this->middleware('admin');
  }

  public function index() {
    $showtimes = Showtime::with(['movie', 'theater'])->latest()->paginate(10);
    return view('admin.showtimes.index', compact('showtimes'));
  }

  public function create() {
    $movies = Movie::all();
    $theaters = Theater::all();
    return view('admin.showtimes.create', compact('movies', 'theaters'));
  }

  public function store(Request $request) {
    $validated = $request->validate([
      'movie_id' => 'required|exists:movies,id',
      'theater_id' => 'required|exists:theaters,id',
      'start_time' => 'required|date|after:now',
    ]);

    $movie = Movie::find($validated['movie_id']);
    $startTime = Carbon::parse($validated['start_time']);
    $endTime = $startTime->copy()->addMinutes($movie->duration_minutes);

    // Check for theater availability
    $conflictingShowtime = Showtime::where('theater_id', $validated['theater_id'])
      ->where(function($query) use ($startTime, $endTime) {
        $query->whereBetween('start_time', [$startTime, $endTime])
          ->orWhereBetween('end_time', [$startTime, $endTime])
          ->orWhere(function($query) use ($startTime, $endTime) {
            $query->where('start_time', '<', $startTime)
              ->where('end_time', '>', $endTime);
          });
      })
      ->exists();

    if ($conflictingShowtime) {
      return back()->withErrors(['theater_id' => 'The theater is already booked during this time.'])->withInput();
    }

    Showtime::create([
      'movie_id' => $validated['movie_id'],
      'theater_id' => $validated['theater_id'],
      'start_time' => $startTime,
      'end_time' => $endTime,
    ]);

    return redirect()->route('admin.showtimes.index')->with('success', 'Showtime created successfully.');
  }

  public function edit(Showtime $showtime) { //string $id
    $movies = Movie::all();
    $theaters = Theater::all();
    return view('admin.showtimes.edit', compact('showtime', 'movies', 'theaters'));
  }

  public function update(Request $request, Showtime $showtime) { //string $id
    $validated = $request->validate([
      'movie_id' => 'required|exists:movies,id',
      'theater_id' => 'required|exists:theaters,id',
      'start_time' => 'required|date|after:now',
    ]);

    $movie = Movie::find($validated['movie_id']);
    $startTime = Carbon::parse($validated['start_time']);
    $endTime = $startTime->copy()->addMinutes($movie->duration_minutes);

    // Check for theater availability excluding current showtime
    $conflictingShowtime = Showtime::where('theater_id', $validated['theater_id'])
      ->where('id', '!=', $showtime->id)
      ->where(function($query) use ($startTime, $endTime) {
        $query->whereBetween('start_time', [$startTime, $endTime])
          ->orWhereBetween('end_time', [$startTime, $endTime])
          ->orWhere(function($query) use ($startTime, $endTime) {
            $query->where('start_time', '<', $startTime)
              ->where('end_time', '>', $endTime);
          });
      })
      ->exists();

    if ($conflictingShowtime) {
      return back()->withErrors(['theater_id' => 'The theater is already booked during this time.'])->withInput();
    }

    $showtime->update([
      'movie_id' => $validated['movie_id'],
      'theater_id' => $validated['theater_id'],
      'start_time' => $startTime,
      'end_time' => $endTime,
    ]);

    return redirect()->route('admin.showtimes.index')->with('success', 'Showtime updated successfully.');
  }

  public function destroy( Showtime $showtime) { //string $id
    $showtime->delete();
    return redirect()->route('admin.showtimes.index')->with('success', 'Showtime deleted successfully.');
  }
}
