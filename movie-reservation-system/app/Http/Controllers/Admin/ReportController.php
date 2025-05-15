<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {
  public function __construct() {
    $this->middleware('auth');
    $this->middleware('admin');
  }


  public function index() {
    $reports = [];

    // Daily revenue report
    $reports['daily_revenue'] = Reservation::select(
      DB::raw('DATE(created_at) as date'),
      DB::raw('SUM(price) as total_revenue'),
      DB::raw('COUNT(*) as total_reservations')
    )
      ->where('status', 'confirmed')
      ->groupBy('date')
      ->orderBy('date', 'desc')
      ->get();

    // Movie popularity report
    $reports['movie_popularity'] = Reservation::with('showtime.movie')
      ->select(
        'showtimes.movie_id',
        DB::raw('COUNT(reservations.id) as total_reservations'),
        DB::raw('SUM(reservations.price) as total_revenue')
      )
      ->join('showtimes', 'showtimes.id', '=', 'reservations.showtime_id')
      ->where('reservations.status', 'confirmed')
      ->groupBy('showtimes.movie_id')
      ->orderBy('total_reservations', 'desc')
      ->get();

    // Theater capacity utilization
    $reports['theater_utilization'] = DB::table('theaters')
      ->leftJoin('showtimes', 'showtimes.theater_id', '=', 'theaters.id')
      ->leftJoin('reservations', function($join) {
          $join->on('reservations.showtime_id', '=', 'showtimes.id')
          ->where('reservations.status', 'confirmed');
      })
      ->select(
        'theaters.id',
        'theaters.name',
        'theaters.capacity',
        DB::raw('COUNT(DISTINCT showtimes.id) as total_showtimes'),
        DB::raw('COUNT(reservations.id) as total_reservations'),
        DB::raw('ROUND(COUNT(reservations.id) * 100.0 / (COUNT(DISTINCT showtimes.id) * theaters.capacity), 2) as utilization_percentage')
      )
      ->groupBy('theaters.id', 'theaters.name', 'theaters.capacity')
      ->get();

    return view('admin.reports.index', compact('reports'));
  }

}
