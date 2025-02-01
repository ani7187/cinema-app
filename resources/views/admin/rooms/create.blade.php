@extends('layouts.main')
@section('title', 'Create New Room')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">{{ __('Rooms') }}</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Room Creation Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.rooms.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <!-- Room Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('Room Name') }} *</label>
                                            <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                                   id="name" name="name" placeholder="Enter room name"
                                                   value="{{ old('name') }}" required>
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Room Rows -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="room_rows">{{ __('Room Rows') }} *</label>
                                            <input type="number"
                                                   class="form-control  @error('rows') is-invalid @enderror"
                                                   id="room_rows" name="rows" placeholder="Enter room rows"
                                                   value="{{ old('rows') }}" required>
                                            @error('rows')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Seats Per Row -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="seats_per_row">{{ __('Seats per row') }} *</label>
                                            <input type="number"
                                                   class="form-control  @error('seats_per_row') is-invalid @enderror"
                                                   id="seats_per_row" name="seats_per_row"
                                                   placeholder="Enter seats per row" value="{{ old('seats_per_row') }}"
                                                   required>
                                            @error('seats_per_row')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="published" value="0">
                                                <input class="custom-control-input" type="checkbox" value="1"
                                                       name="published" id="published">
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
                                    <button type="submit" class="btn btn-primary">Create Room</button>
                                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
