@extends('layouts.app')

@section('content')
    <div class="container py-4">
        {{-- Popup Success hanya di atas --}}

        <!-- Header Simple -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Top Movies by Genre</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">← Back</a>
        </div>

        <!-- Genre Selection -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('genre.top.filter') }}">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label for="genre" class="form-label">Select Genre:</label>
                        </div>
                        <div class="col-md-6">
                            <select name="genre" id="genre" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Choose Genre --</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre }}" {{ ($selectedGenre ?? '') == $genre ? 'selected' : '' }}>
                                        {{ $genre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results -->
        @if($selectedGenre && count($topMovies) > 0)
            <div class="mb-3">
                <h4>Top 5 Movies - {{ $selectedGenre }}</h4>
                <small class="text-muted">Sorted by highest rating</small>
            </div>

            @foreach($topMovies as $movie)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>{{ $movie['title'] ?? 'No Title' }}</h5>
                        <p>{{ is_array($movie['genres']) ? implode(', ', $movie['genres']) : $movie['genres'] }}</p>
                        <p>{{ $movie['year'] }}</p>
                        <p>{{ $movie['plot'] }}</p>

                        @auth
                            @if(!in_array($movie['id'], $bookmarkedMovieIds))
                                <form action="{{ route('bookmarks.store') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="movie_id" value="{{ $movie['id'] }}">
                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-bookmark-plus"></i> Bookmark
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-success btn-sm" disabled>
                                    <i class="bi bi-bookmark-check"></i> Sudah di-bookmark
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-bookmark-plus"></i> Login untuk bookmark
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach

            <div class="text-center mt-4">
                <a href="{{ route('genre.top') }}" class="btn btn-outline-secondary">Clear Filter</a>
            </div>

        @elseif($selectedGenre)
            <div class="alert alert-warning text-center">
                <h5>No movies found for genre "{{ $selectedGenre }}"</h5>
                <a href="{{ route('genre.top') }}" class="btn btn-outline-primary">Try Another Genre</a>
            </div>

        @else
            <div class="text-center py-5 text-muted">
                <h4>Select a genre above to see top movies</h4>
                <p>Choose from {{ count($genres) }} available genres</p>
            </div>
        @endif
    </div>
@endsection