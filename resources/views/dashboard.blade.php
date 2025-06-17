@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="d-flex flex-row align-items-center justify-content-between mb-5">
        <h1 class="text-3xl font-bold mb-0">Pick a Movie by Mood</h1>
        <div class="d-flex align-items-center">
            <label for="genre-dropdown" class="fw-semibold me-2 mb-0">Top Genre Film:</label>
            <select id="genre-dropdown" class="form-select w-auto">
                <option value="">-- Pilih Genre --</option>
                @foreach($genres as $genre)
                    <option value="{{ route('movies.by.genre.page', ['genre' => is_object($genre) ? $genre->name : $genre]) }}">
                        {{ is_object($genre) ? $genre->name : $genre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="text-center my-5">
        <a href="{{ route('movie-picker.start') }}" class="btn btn-lg btn-primary">Start Now</a>
    </div>
    <div id="movies-list" class="my-8">
        @if(isset($filteredMovies) && $selectedGenre)
            @if(count($filteredMovies) > 0)
                <h2 class="text-xl font-bold mb-4">Film dengan rating tertinggi:</h2>
                <ul class="space-y-4">
                    @foreach($filteredMovies as $movie)
                        <li class="border p-4 rounded shadow">
                            <div class="font-semibold text-lg">{{ $movie->title }} ({{ $movie->year }})</div>
                            <div>Rating: <span class="font-bold">{{ $movie->rating }}</span></div>
                            <div class="text-sm text-gray-600">{{ $movie->plot ?? '' }}</div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center text-gray-500">Tidak ada film dengan genre ini.</p>
            @endif
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('genre-dropdown').addEventListener('change', function() {
    if(this.value) {
        window.location.href = this.value;
    }
});
</script>
@endpush