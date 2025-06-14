@extends('layouts.app')

@section('title', 'Reserve Seat')

@section('content')
<div class="container">
    <h1>Reserve Seat for {{ $showtime->movie->title }}</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Showtime Details</h5>
            <p class="card-text">
                <strong>Date & Time:</strong> {{ $showtime->start_time->format('l, F jS g:i A') }}<br>
                <strong>Theater:</strong> {{ $showtime->theater->name }}<br>
                <strong>Available seats:</strong> {{ $availableSeats->count() }} / {{ $showtime->theater->capacity }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            Select Your Seat
        </div>
        <div class="card-body">
            @if($availableSeats->isEmpty())
                <div class="alert alert-danger">No available seats for this showtime.</div>
            @else
                <form method="POST" action="{{ route('reservations.store', $showtime) }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="seat_id" class="form-label">Choose a seat:</label>
                        <select class="form-select" id="seat_id" name="seat_id" required>
                            @foreach($availableSeats as $seat)
                                <option value="{{ $seat->id }}">Row {{ $seat->row }}, Seat {{ $seat->number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Confirm Reservation ($10.00)</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection