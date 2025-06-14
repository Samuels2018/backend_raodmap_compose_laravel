@extends('admin.layouts.app')

@section('admin-title', 'Reports')

@section('admin-content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Daily Revenue</h5>
            </div>
            <div class="card-body">
                @if($reports['daily_revenue']->isEmpty())
                    <div class="alert alert-info">No revenue data available.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Total Reservations</th>
                                    <th>Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports['daily_revenue'] as $report)
                                    <tr>
                                        <td>{{ $report->date }}</td>
                                        <td>{{ $report->total_reservations }}</td>
                                        <td>${{ number_format($report->total_revenue, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Movie Popularity</h5>
            </div>
            <div class="card-body">
                @if($reports['movie_popularity']->isEmpty())
                    <div class="alert alert-info">No movie popularity data available.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Movie</th>
                                    <th>Reservations</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports['movie_popularity'] as $report)
                                    <tr>
                                        <td>{{ $report->showtime->movie->title }}</td>
                                        <td>{{ $report->total_reservations }}</td>
                                        <td>${{ number_format($report->total_revenue, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Theater Utilization</h5>
            </div>
            <div class="card-body">
                @if($reports['theater_utilization']->isEmpty())
                    <div class="alert alert-info">No theater utilization data available.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Theater</th>
                                    <th>Capacity</th>
                                    <th>Showtimes</th>
                                    <th>Reservations</th>
                                    <th>Utilization</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports['theater_utilization'] as $report)
                                    <tr>
                                        <td>{{ $report->name }}</td>
                                        <td>{{ $report->capacity }}</td>
                                        <td>{{ $report->total_showtimes }}</td>
                                        <td>{{ $report->total_reservations }}</td>
                                        <td>{{ $report->utilization_percentage }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection