@extends('layouts.main')

@section('title', 'Edit Schedule')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">{{ __('Schedules') }}</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
                                @csrf
                                @method('PATCH') <!-- Required for updating -->

                                <div class="row">
                                    <!-- Room -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="room_id">{{ __('Room') }} *</label>
                                            <select name="room_id" id="room_id" class="select2 form-control @error('room_id') is-invalid @enderror" required>
                                                <option value="">Select Room</option>
                                                @foreach($rooms as $room)
                                                    <option value="{{ $room->id }}" {{ old('room_id', $schedule->room_id) == $room->id ? 'selected' : '' }}>
                                                        {{ $room->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('room_id')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Movie -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="movie_id">{{ __('Movie') }} *</label>
                                            <select name="movie_id" id="movie_id" class="select2 form-control @error('movie_id') is-invalid @enderror" required>
                                                <option value="">Select Movie</option>
                                                @foreach($movies as $movie)
                                                    <option value="{{ $movie->id }}" {{ old('movie_id', $schedule->movie_id) == $movie->id ? 'selected' : '' }}>
                                                        {{ $movie->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('movie_id')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Start Time -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_time">{{ __('Start Time') }} *</label>
                                            <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror"
                                                   id="start_time" name="start_time"
                                                   value="{{ old('start_time', date('Y-m-d\TH:i', strtotime($schedule->start_time))) }}" required>
                                            @error('start_time')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- End Time -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_time">{{ __('End Time') }} *</label>
                                            <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror"
                                                   id="end_time" name="end_time"
                                                   value="{{ old('end_time', date('Y-m-d\TH:i', strtotime($schedule->end_time))) }}" required>
                                            @error('end_time')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="published" value="0">
                                                <input class="custom-control-input" type="checkbox" value="1"
                                                       name="published" id="published"
                                                    {{ old('published', $schedule->published) ? 'checked' : '' }}>
                                                <label for="published" class="custom-control-label">
                                                    {{ __('Is published') }}</label>
                                            </div>
                                            @error('published')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update Schedule</button>
                                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
