@extends('layouts.app')

@section('title', $movie->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ Storage::url($movie->poster_image) }}" alt="{{ $movie->title }}" class="img-fluid rounded">
        </div>
        <div class="col-md-8">
            <h1>{{ $movie->title }}</h1>
            <p class="lead">{{ $movie->description }}</p>
            <p><strong>Duration:</strong> {{ $movie->duration_minutes }} minutes</p>
            <p><strong>Genres:</strong> 
                @foreach($movie->genres as $genre)
                    <span class="badge bg-primary">{{ $genre->name }}</span>
                @endforeach
            </p>
        </div>
    </div>

    <div class="mt-5">
        <h2>Showtimes</h2>
        @if($showtimes->isEmpty())
            <div class="alert alert-info">No showtimes available for this movie.</div>
        @else
            @foreach($showtimes as $date => $times)
                <h3 class="mt-4">{{ \Carbon\Carbon::parse($date)->format('l, F jS') }}</h3>
                <div class="row mb-4">
                    @foreach($times as $showtime)
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $showtime->start_time->format('g:i A') }}</h5>
                                    <p class="card-text">
                                        <strong>Theater:</strong> {{ $showtime->theater->name }}<br>
                                        <strong>Available seats:</strong> {{ $showtime->availableSeats()->count() }}
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    @auth
                                        <a href="{{ route('reservations.create', $showtime) }}" class="btn btn-primary w-100">
                                            Book Now
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                                            Login to Book
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection