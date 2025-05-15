<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;

class MovieController extends Controller {
  public function index () {
    $movies = Movie::with('genres')->latest()->paginate(10);
    return view('movies.index', compact('movies'));
  }


  public function show (Movie $movie) { //string $id
    $showtimes = Showtime::where('movie_id', $modie->id)
      ->where('start_time', '>', Carbon::now())
      ->orderBy('start_time')
      ->get()
      ->groupBy(function($date) {
        return Carbon::parse($date->start_time)->format('Y-m-d');
      });
    
    return view('movies.show', compact('movie', 'showtimes'));
  }


  public function showtimes (Request $request) {
    $data = $request->input('data', now()->format('Y-m-d'));
    $showtimes = Showtime::with(['movie', 'theater'])
      ->whereDate('start_time', $data)
      ->where('start_time' , '>', Carbon::now())
      ->orderBy('start_time')
      ->get();
    
    return view('movies.showtimes', compact('showtimes', 'data'));
  }
}
