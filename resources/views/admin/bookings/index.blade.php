@extends('layouts.main')

@section('title', 'Bookings')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Schedules Management Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Schedules (Select a schedule to view seat availability)
                        </div>
                        <div class="card-body">
                            <!-- Check if there are schedules -->
                            @if($schedules->isEmpty())
                                <div class="alert alert-warning">
                                    Schedules not found.
                                </div>
                            @else
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc">ID</th>
                                        <th>Room Name</th>
                                        <th>Movie Title</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Is published</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($schedules as $key => $schedule)
                                        <tr style="cursor: pointer" onclick="window.location='{{ route('admin.bookings.show', ['schedule' => $schedule->id]) }}'">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $schedule->room->name }}</td>
                                            <td>{{ $schedule->movie->title }}</td>
                                            <td>{{ $schedule->start_time_formatted }}</td>
                                            <td>{{ $schedule->end_time_formatted }}</td>
                                            <td>{{ $schedule->published ? 'Yes' : 'No' }}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            <!-- Pagination -->
                            <div class="d-flex justify-content-end pt-4">
                                {{ $schedules->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
