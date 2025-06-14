@extends('layouts.app')

@section('title', 'Movies')

@section('content')
<div class="container">
    <h1 class="mb-4">Now Showing</h1>
    
    <div class="row">
        @foreach($movies as $movie)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ Storage::url($movie->poster_image) }}" class="card-img-top" alt="{{ $movie->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->title }}</h5>
                        <p class="card-text">{{ Str::limit($movie->description, 100) }}</p>
                        <span class="badge bg-secondary">{{ $movie->duration_minutes }} mins</span>
                        @foreach($movie->genres as $genre)
                            <span class="badge bg-primary">{{ $genre->name }}</span>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('movies.show', $movie) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $movies->links() }}
</div>
@endsection