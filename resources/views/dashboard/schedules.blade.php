@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h1 class="text-center pb-5" style="font-size: 36px; font-weight: bold; color: #343a40;">
            You are in
            <span style="text-decoration: underline; font-style: italic;">
                {{ $room->name }}
            </span>
        </h1>

        @if($schedules->isEmpty())
            <div class="alert alert-warning text-center w-100 p-4 rounded shadow-lg"
                 style="background-color: #f8d7da; border: 1px solid #f5c6cb;">
                <div class="d-flex justify-content-center align-items-center">
                    <i class="bi bi-exclamation-circle-fill" style="font-size: 40px; color: #856404;"></i>
                    <span class="ms-3" style="font-size: 20px; color: #856404;">
                No movies available at the moment.
            </span>
                </div>
                <p class="mt-3" style="font-size: 18px; color: #6c757d;">Please check back later.</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($schedules as $schedule)
                    @php
                        $startTime = \Carbon\Carbon::parse($schedule->start_time);
                        $endTime = \Carbon\Carbon::parse($schedule->end_time);
                    @endphp

                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            @if($schedule->movie->poster_url)
                                <img src="{{ asset($schedule->movie->poster_url) }}"
                                     alt="{{ $schedule->movie->title }} Poster"
                                     class="img-fluid mb-2 rounded-3 w-100"
                                     style="object-fit: cover; height: 600px;"> <!-- Reduced height -->
                            @else
                                <div class="text-center py-3">
                                    <p class="text-muted">No poster available</p>
                                </div>
                            @endif

                            <div class="card-body p-3">
                                <h5 class="card-title text-center text-uppercase font-weight-bold mb-2"
                                    style="color: #333; font-size: 1rem;">
                                    <b>{{ $schedule->movie->title }}</b>
                                    {{ $schedule->movie->min_allowed_age ? $schedule->movie->min_allowed_age . '+' : ''}}
                                </h5>
                                <p>Genre: {{ $schedule->movie->genre?->name }}</p>
                                <p class="card-text text-muted" style="font-size: 0.9rem; line-height: 1.4;"
                                   title="{{$schedule->movie->description}}">
                                    {!! $schedule->movie->description ? Str::limit($schedule->movie->description, 40) : '&nbsp;' !!}
                                </p>
                                <span class="text-muted" style="font-size: 0.9rem;">Start at: {{ $startTime }}</span>
                            </div>

                            <div class="card-footer p-2">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-muted m-0" style="font-size: 0.8rem;">{{ $startTime->diffForHumans() }}</p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="{{ route('schedule.seats', ['schedule' => $schedule->id]) }}"
                                           class="btn btn-sm btn-primary">Book Seat</a> <!-- Reduced button size -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="d-flex justify-content-center mt-4">
            {{ $schedules->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
