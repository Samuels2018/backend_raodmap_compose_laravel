@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/movies*') ? 'active' : '' }}" href="{{ route('admin.movies.index') }}">
                            Movies
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/showtimes*') ? 'active' : '' }}" href="{{ route('admin.showtimes.index') }}">
                            Showtimes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/reports*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                            Reports
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">@yield('admin-title')</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    @yield('admin-actions')
                </div>
            </div>

            @include('partials.alerts')
            @yield('admin-content')
        </main>
    </div>
</div>
@endsection