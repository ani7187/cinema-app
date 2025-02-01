@extends('layouts.main')
@section('title', 'Add movie')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.movies.index') }}">{{ __('Movies') }}</a></li>
        <li class="breadcrumb-item active"> {{ __('Create') }} </li>
    </ol>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
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

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="poster">{{ __('Movie Poster') }}*</label>
                                            <input type="file" class="form-control @error('poster') is-invalid @enderror"
                                                   id="poster" name="poster_url">
                                            @error('poster_url')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="min_allowed_age">{{ __('Min Allowed Age') }} </label>
                                            <input type="number" class="form-control @error('min_allowed_age') is-invalid @enderror"
                                                   id="min_allowed_age" name="min_allowed_age"
                                                   placeholder="Enter min allowed age"
                                                   value="{{ old('min_allowed_age') }}">
                                            @error('min_allowed_age')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="genre_id">{{ __('Genre') }}</label>
                                            <select class="select2 form-control @error('genre_id') is-invalid @enderror" id="genre_id" name="genre_id" required>
                                                <option value="">{{ __('Select Genre') }}</option>
                                                @foreach($genres as $genre)
                                                    <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                                        {{ $genre->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('genre_id')
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
                                    <button type="submit" class="btn btn-primary"> {{ __('Create movie') }}</button>
                                    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">{{ __('Cancel')}}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
