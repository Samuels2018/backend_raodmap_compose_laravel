<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller {
  public function __construct () {
    $this->middleware('auth');
  }

  public function index() {
    $reservations = Auth::user()->reservations()
      ->with(['showtime.movie', 'seat.theater'])
      ->upcoming()
      ->orderBy('created_at', 'desc')
      ->paginate(10);

    return view('reservations.index', compact('reservations'));
  }

  public function create(Showtime $showtime) {
    $avaliableSeats = $showtime->availableSeats();
    return view('reservations.create', compact('showtime', 'avaliableSeats'));
  }

  public function store(Request $request, Showtime $showtime) {
    $validated = $request->validate([
      'seat_id' => 'required|exists:seats,id',
    ]);

    // Check if seat is available
    $isSeatAvailable = !$showtime->reservations()
      ->where('seat_id', $validated['seat_id'])
      ->exists();

    if (!$isSeatAvailable) {
      return back()->withErrors(['seat_id' => 'The selected seat is no longer available.'])->withInput();
    }

    $seat = Seat::find($validated['seat_id']);
    $price = 10.00; // Base price, could be dynamic based on seat or showtime

    $reservation = Reservation::create([
      'user_id' => Auth::id(),
      'showtime_id' => $showtime->id,
      'seat_id' => $validated['seat_id'],
      'reservation_code' => Str::upper(Str::random(8)),
      'price' => $price,
      'status' => 'confirmed',
    ]);

    return redirect()->route('reservations.show', $reservation)
      ->with('success', 'Reservation created successfully.');
  }


  public function show(Reservation $reservation) { // string $id
    $this->authorize('view', $reservation);
    $reservation->load(['showtime.movie', 'seat.theater']);
    return view('reservations.show', compact('reservation'));
    
  }

  public function destroy(Reservation $reservation) { // string $id
    $this->authorize('delete', $reservation);

    if ($reservation->showtime->start_time < now()) {
      return back()->with('error', 'Cannot cancel past reservations.');
    }

    $reservation->update(['status' => 'canceled']);
    return redirect()->route('reservations.index')
      ->with('success', 'Reservation canceled successfully.');
  }
}
