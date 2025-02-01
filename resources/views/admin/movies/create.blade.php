@extends('layouts.main')
@section('title', 'Add movie')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.movies.index') }}">{{ __('Movies') }}</a></li>
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
                            <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Room Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">{{ __('Title') }} *</label>
                                            <input type="text" class="form-control  @error('title') is-invalid @enderror"
                                                   id="title" name="title" placeholder="Enter movie name"
                                                   value="{{ old('title') }}" required>
                                            @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Movie Poster File Upload -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="poster">{{ __('Movie Poster') }}</label>
                                            <input type="file" class="form-control @error('poster') is-invalid @enderror"
                                                   id="poster" name="poster_url">
                                            <small class="form-text text-muted">
                                                Please upload an image with dimensions of 800px by 600px.
                                            </small>
                                            @error('poster_url')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">{{ __('Description') }}</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter movie description">{{ old('description') }}</textarea>
                                            @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Create movie</button>
                                    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Cancel</a>
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
