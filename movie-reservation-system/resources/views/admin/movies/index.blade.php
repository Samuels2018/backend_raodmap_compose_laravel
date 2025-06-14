@extends('admin.layouts.app')

@section('admin-title', 'Manage Movies')

@section('admin-actions')
    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">Add New Movie</a>
@endsection

@section('admin-content')
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Poster</th>
                <th>Title</th>
                <th>Duration</th>
                <th>Genres</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
                <tr>
                    <td>
                        <img src="{{ Storage::url($movie->poster_image) }}" alt="{{ $movie->title }}" width="50">
                    </td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->duration_minutes }} mins</td>
                    <td>
                        @foreach($movie->genres as $genre)
                            <span class="badge bg-secondary">{{ $genre->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $movies->links() }}
@endsection