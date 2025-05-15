@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ Storage::url($movie->poster_image) }}" alt="{{ $movie->title }}" class="img-fluid">
        </div>
        <div class="col-md-8">
            <h1>{{ $movie->title }}</h1>
            <p>{{ $movie->description }}</p>
            <p><strong>Duration:</strong> {{ $movie->duration_minutes }} minutes</p>
            <p><strong>Genres:</strong> {{ $movie->genres->pluck('name')->implode(', ') }}</p>
        </div>
    </div>

    <div class="mt-5">
        <h2>Showtimes</h2>
        @foreach($showtimes as $date => $times)
            <h3>{{ \Carbon\Carbon::parse($date)->format('l, F jS') }}</h3>
            <div class="row mb-4">
                @foreach($times as $showtime)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $showtime->start_time->format('g:i A') }}</h5>
                                <p class="card-text">
                                    Theater: {{ $showtime->theater->name }}<br>
                                    Available seats: {{ $showtime->availableSeats()->count() }}
                                </p>
                                <a href="{{ route('reservations.create', $showtime) }}" class="btn btn-primary">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection