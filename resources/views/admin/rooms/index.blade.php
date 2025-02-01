@extends('layouts.main')

@section('title', 'Rooms')

@section('content')
    <section class="content">
        <div class="container-fluid">

            @include('includes.alert')

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add New Room') }}
                            </a>
                        </div>
                        <div class="card-body">
                            @if($rooms->isEmpty())
                                <div class="alert alert-warning">
                                    {{ __('Rooms not found.') }}
                                </div>
                            @else
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc">N</th>
                                        <th> {{ __('Room Name')}} </th>
                                        <th> {{ __('Room rows')}} </th>
                                        <th> {{ __('Seats per row')}} </th>
                                        <th> {{ __('Is published')}} </th>
                                        <th> {{ __('Actions')}} </th>
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
                                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                                </a>
                                                <form action="{{ route('admin.rooms.destroy', $room->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

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
