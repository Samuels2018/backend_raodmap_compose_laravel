@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reserve Seat for {{ $showtime->movie->title }}</h1>
    <p>Showtime: {{ $showtime->start_time->format('l, F jS g:i A') }}</p>
    <p>Theater: {{ $showtime->theater->name }}</p>

    <div class="card">
        <div class="card-header">Available Seats</div>
        <div class="card-body">
            <form method="POST" action="{{ route('reservations.store', $showtime) }}">
                @csrf
                <div class="form-group">
                    <label for="seat_id">Select Seat</label>
                    <select class="form-control" id="seat_id" name="seat_id" required>
                        @foreach($availableSeats as $seat)
                            <option value="{{ $seat->id }}">Row {{ $seat->row }}, Seat {{ $seat->number }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Confirm Reservation</button>
            </form>
        </div>
    </div>
</div>
@endsection