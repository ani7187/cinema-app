<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(StoreMovieRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('poster_url')) {
            $posterPath = Storage::disk('public')->put('/images',  $data['poster_url']);
        } else {
            $posterPath = null;
        }
        $data['poster_url'] = 'storage/' . $posterPath;
        Movie::create($data);

        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully.');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $data = $request->validated();
        if ($request->hasFile('poster_url')) {
            $posterPath = Storage::disk('public')->put('/images',  $data['poster_url']);
            $data['poster_url'] = 'storage/' . $posterPath;
        }
        $movie->update($data);

        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully.');
    }
}
