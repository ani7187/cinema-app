@extends('layouts.main')

@section('title', 'Schedules')

@section('content')
    <section class="content">
        <div class="container-fluid">
            @include('includes.alert')
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add new schedule') }}
                            </a>
                        </div>
                        <div class="card-body">
                            @if($schedules->isEmpty())
                                <div class="alert alert-warning">
                                    {{ __('Schedules not found.') }}
                                </div>
                            @else
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc"> {{ __('N') }}</th>
                                        <th> {{ __('Room Name') }} </th>
                                        <th> {{ __('Movie Title') }} </th>
                                        <th> {{ __('Start Time') }} </th>
                                        <th> {{ __('End Time') }} </th>
                                        <th> {{ __('Is published') }} </th>
                                        <th> {{ __('Actions') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($schedules as $key => $schedule)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $schedule->room->name }}</td>
                                            <td>{{ $schedule->movie->title }}</td>
                                            <td>{{ $schedule->start_time_formatted }}</td>
                                            <td>{{ $schedule->end_time_formatted }}</td>
                                            <td>{{ $schedule->published ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> {{ __('Delete')}}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

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
