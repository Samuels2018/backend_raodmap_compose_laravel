@extends('layouts.app')

@section('title', 'My Reservations')

@section('content')
<div class="container">
    <h1 class="mb-4">My Reservations</h1>
    
    @if($reservations->isEmpty())
        <div class="alert alert-info">You don't have any upcoming reservations.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Movie</th>
                        <th>Showtime</th>
                        <th>Theater</th>
                        <th>Seat</th>
                        <th>Reservation Code</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->showtime->movie->title }}</td>
                            <td>{{ $reservation->showtime->start_time->format('M j, Y g:i A') }}</td>
                            <td>{{ $reservation->seat->theater->name }}</td>
                            <td>Row {{ $reservation->seat->row }}, Seat {{ $reservation->seat->number }}</td>
                            <td>{{ $reservation->reservation_code }}</td>
                            <td>${{ number_format($reservation->price, 2) }}</td>
                            <td>
                                <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-info">View</a>
                                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $reservations->links() }}
    @endif
</div>
@endsection