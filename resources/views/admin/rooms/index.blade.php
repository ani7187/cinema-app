@extends('layouts.main')

@section('title', 'Rooms')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Rooms Management Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Room
                            </a>
                        </div>
                        <div class="card-body">
                            <!-- Check if there are rooms -->
                            @if($rooms->isEmpty())
                                <div class="alert alert-warning">
                                    Rooms not found.
                                </div>
                            @else
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc">ID</th>
                                        <th>Room Name</th>
                                        <th>Room rows</th>
                                        <th>Seats per row</th>
                                        <th>Is published</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rooms as $key => $room)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $room->name }}</td>
                                            <td>{{ $room->rows }}</td>
                                            <td>{{ $room->seats_per_row }}</td>
                                            <td>{{ $room->published ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.rooms.destroy', $room->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            <!-- Pagination -->
                            <div class="d-flex justify-content-end pt-4">
                                {{ $rooms->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
