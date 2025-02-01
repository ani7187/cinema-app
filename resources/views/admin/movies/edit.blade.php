@extends('layouts.main')
@section('title', 'Edit Movie')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.movies.index') }}">{{ __('Movies') }}</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Movie Edit Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')  <!-- Method to simulate PUT request -->

                                <div class="row">
                                    <!-- Movie Title -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">{{ __('Title') }} *</label>
                                            <input type="text"
                                                   class="form-control  @error('title') is-invalid @enderror"
                                                   id="title" name="title" placeholder="Enter movie title"
                                                   value="{{ old('title', $movie->title) }}" required>
                                            @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Movie Poster File Upload -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="poster">{{ __('Movie Poster') }}</label>
                                            <input type="file"
                                                   class="form-control @error('poster') is-invalid @enderror"
                                                   id="poster" name="poster_url">
                                            <small class="text-danger">Select file for update</small>
                                            @error('poster_url')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div id="image-preview-container" class="mt-2">
                                            <img src="{{ asset($movie->poster_url) }}" alt="Poster"
                                                 style="max-width: 100px; max-height: 100px;">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">{{ __('Description') }}</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description" name="description"
                                                      placeholder="Enter movie description">{{ old('description', $movie->description) }}</textarea>
                                            @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update Movie</button>
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
