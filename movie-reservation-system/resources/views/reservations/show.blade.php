@extends('layouts.app')

@section('title', 'Reservation Details')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Reservation Details</h2>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <img src="{{ Storage::url($reservation->showtime->movie->poster_image) }}" 
                         alt="{{ $reservation->showtime->movie->title }}" 
                         class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                    <h3>{{ $reservation->showtime->movie->title }}</h3>
                    <p class="lead">{{ $reservation->showtime->movie->description }}</p>
                    <p><strong>Duration:</strong> {{ $reservation->showtime->movie->duration_minutes }} minutes</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="mb-0">Showtime Information</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Date & Time:</strong> {{ $reservation->showtime->start_time->format('l, F jS g:i A') }}</p>
                            <p><strong>Theater:</strong> {{ $reservation->seat->theater->name }}</p>
                            <p><strong>Seat:</strong> Row {{ $reservation->seat->row }}, Seat {{ $reservation->seat->number }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="mb-0">Reservation Details</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Reservation Code:</strong> {{ $reservation->reservation_code }}</p>
                            <p><strong>Booking Date:</strong> {{ $reservation->created_at->format('M j, Y g:i A') }}</p>
                            <p><strong>Total Price:</strong> ${{ number_format($reservation->price, 2) }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $reservation->status === 'confirmed' ? 'success' : 'danger' }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($reservation->status === 'confirmed' && $reservation->showtime->start_time > now())
                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Cancel Reservation</button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Back to List</a>
                </form>
            @else
                <a href="{{ route('reservations.index') }}" class="btn btn-secondary mt-3">Back to List</a>
            @endif
        </div>
    </div>
</div>
@endsection