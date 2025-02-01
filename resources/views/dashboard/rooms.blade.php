@extends('layouts.app')

@section('content')
    <div class="container mt-5">


        <h1 class="text-center pb-5" style="font-size: 36px; font-weight: bold; color: #343a40;">
            <span style="text-decoration: underline; font-style: italic;">
                Select a Room
            </span>
        </h1>
        <div class="row">
            @if($rooms->isEmpty())
                <div class="alert alert-warning text-center w-100 p-4 rounded shadow-lg"
                     style="background-color: #f8d7da; border: 1px solid #f5c6cb;">
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-exclamation-circle-fill" style="font-size: 40px; color: #856404;"></i>
                        <span class="ms-3" style="font-size: 20px; color: #856404;">
                No rooms available at the moment.
            </span>
                    </div>
                    <p class="mt-3" style="font-size: 18px; color: #6c757d;">Please check back later.</p>
                </div>
            @else
                @foreach ($rooms as $room)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg border-0 rounded">
                            <div class="card-body text-center">
                                <h4 class="card-title text-success font-weight-bold">{{ $room->name }}</h4>
                                <p class="card-text text-muted">Select this room to view available movie schedules.</p>
                                <a href="{{ route('room.schedules', $room->id) }}"
                                   class="btn btn-outline-primary btn-lg px-4 py-1">View Movies</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Pagination with center alignment -->
        <div class="d-flex justify-content-center mt-4">
            {{ $rooms->links('pagination::bootstrap-4') }}
        </div>

    </div>
@endsection
