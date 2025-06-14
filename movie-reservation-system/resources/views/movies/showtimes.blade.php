<!-- resources/views/movies/showtimes.blade.php -->
@extends('layouts.app')

@section('title', 'Showtimes')

@section('content')
<div class="container">
    <h1 class="mb-4">Showtimes for {{ $date }}</h1>
    
    <form method="GET" action="{{ route('movies.showtimes') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="date" name="date" class="form-control" value="{{ $date }}" min="{{ now()->format('Y-m-d') }}">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    @if($showtimes->isEmpty())
        <div class="alert alert-info">No showtimes available for this date.</div>
    @else
        @foreach($showtimes->groupBy('movie_id') as $movieId => $movieShowtimes)
            @php $movie = $movieShowtimes->first()->movie; @endphp
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ $movie->title }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($movieShowtimes as $showtime)
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
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection