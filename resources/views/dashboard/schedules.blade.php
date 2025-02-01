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
                                     class="img-fluid mb-3 rounded-3 w-100" style="object-fit: cover; height: 600px; width: 300px">
                            @else
                                <div class="text-center py-5">
                                    <p class="text-muted">No poster available</p>
                                </div>
                            @endif

                                <div class="card-body">
                                    <h5 class="card-title text-center text-uppercase font-weight-bold mb-3"
                                        style="color: #333; font-size: 1.25rem;">
                                        {{ $schedule->movie->title }}
                                    </h5>
                                    <p class="card-text text-muted" style="font-size: 1rem; line-height: 1.6;">
                                        {{ Str::limit($schedule->movie->description, 100) }}
                                    </p>
                                </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-muted">{{ $startTime->diffForHumans() }}</p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="{{ route('schedule.seats', ['schedule' => $schedule->id]) }}"
                                           class="btn btn-primary">Book Seat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{--<div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ $schedule->movie->title }}</h3>
                            </div>
                            <div class="card-body">
                                @if($schedule->movie->poster_url)
                                    <img src="{{ asset($schedule->movie->poster_url) }}"
                                         alt="{{ $schedule->movie->title }} Poster" class="img-fluid mb-3 w-50">
                                @else
                                    <p>No poster available</p>
                                @endif
                                <p><strong>Start Time:</strong> {{ $startTime->format('M d, Y h:i A') }}</p>
                                <p><strong>End Time:</strong> {{ $endTime->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="card-footer text-muted">
                                <div class="row">
                                    <div class="col-md-8">
                                        {{ $startTime->diffForHumans() }}
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ route('schedule.seats', ['schedule' => $schedule->id]) }}"
                                           class="btn btn-primary float-right">Book Seat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                @endforeach
            </div>
        @endif

        <div class="d-flex justify-content-center mt-4">
            {{ $schedules->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
