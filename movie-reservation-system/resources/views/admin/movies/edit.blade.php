@extends('admin.layouts.app')

@section('admin-title', 'Edit Movie: ' . $movie->title)

@section('admin-content')
<form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $movie->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required>{{ $movie->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                        <input type="number" class="form-control" id="duration_minutes" name="duration_minutes" min="1" value="{{ $movie->duration_minutes }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="poster_image" class="form-label">Poster Image</label>
                        <input type="file" class="form-control" id="poster_image" name="poster_image">
                        <div class="mt-2">
                            <img src="{{ Storage::url($movie->poster_image) }}" alt="{{ $movie->title }}" class="img-thumbnail" width="150">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Genres</label>
                        <div class="genre-checkboxes">
                            @foreach($genres as $genre)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="genres[]" 
                                          value="{{ $genre->id }}" id="genre-{{ $genre->id }}"
                                          {{ $movie->genres->contains($genre) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genre-{{ $genre->id }}">
                                        {{ $genre->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Update Movie</button>
            </div>
        </div>
    </div>
</form>
@endsection