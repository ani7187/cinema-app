@extends('layouts.main')

@section('title', 'Movies')

@section('content')
    <section class="content">
        <div class="container-fluid">
            @include('includes.alert')
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add movie') }}
                            </a>
                        </div>
                        <div class="card-body">
                            @if($movies->isEmpty())
                                <div class="alert alert-warning">
                                    {{ __('Movies not found.') }}
                                </div>
                            @else
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc"> {{ __('N') }} </th>
                                        <th> {{ __('Title') }} </th>
                                        <th> {{ __('Poster') }} </th>
                                        <th> {{ __('Description') }}</th>
                                        <th> {{ __('Creation date') }}</th>
                                        <th> {{ __('Genre') }}</th>
                                        <th> {{ __('Min age') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($movies as $key => $movie)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $movie->title }}</td>
                                            <td>
                                                <img src="{{ asset($movie->poster_url) }}" alt="Poster"
                                                     style="max-width: 20px; max-height: 50px;">
                                            </td>
                                            <td><span
                                                    title="{{$movie->description}}">{{ Str::limit($movie->description, 45) }}</span>
                                            </td>
                                            <td>{{ $movie->created_at }}</td>
                                            <td>{{ $movie->genre?->name }}</td>
                                            <td>{{ $movie->min_allowed_age }}</td>
                                            <td>
                                                <a href="{{ route('admin.movies.edit', $movie->id) }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.movies.destroy', $movie->id) }}"
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
                            <div class="d-flex justify-content-end pt-4">
                                {{ $movies->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
