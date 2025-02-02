<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Foundation\Application as App;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * @return App|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|App
    {
        $movies = Movie::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $genres = Genre::all();
        return view('admin.movies.create', compact('genres'));
    }

    /**
     * @param StoreMovieRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMovieRequest $request): RedirectResponse
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

    /**
     * @param Movie $movie
     * @return App|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(Movie $movie): \Illuminate\Foundation\Application|View|Factory|App
    {
        $genres = Genre::all();
        return view('admin.movies.edit', compact('movie', 'genres'));
    }

    /**
     * @param UpdateMovieRequest $request
     * @param Movie $movie
     * @return RedirectResponse
     */
    public function update(UpdateMovieRequest $request, Movie $movie): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('poster_url')) {
            $posterPath = Storage::disk('public')->put('/images',  $data['poster_url']);
            $data['poster_url'] = 'storage/' . $posterPath;
        }
        $movie->update($data);

        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully.');
    }

    /**
     * @param Movie $movie
     * @return RedirectResponse
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        if ($movie->hasActiveSchedules()) {
            return redirect()->back()->with('error', 'Cannot delete movie. There are active schedules.');
        }

        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully.');
    }
}
