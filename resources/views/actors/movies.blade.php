
@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Movies by {{ $actor->name }}</h2>
    <ul>
        @forelse($movies as $movie)
            <li class="mb-2">
                <strong>{{ $movie->title ?? '-' }}</strong>
                @if(isset($movie->year))
                    ({{ $movie->year }})
                @endif
                @if(isset($movie->special))
                    <br>
                    <small>
                        <em>
                            {{ is_array($movie->special) ? implode(', ', $movie->special) : $movie->special }}
                        </em>
                    </small>
                @endif
            </li>
        @empty
            <li>No movies found for this actor.</li>
        @endforelse
    </ul>
    <a href="{{ route('actors.top') }}" class="btn btn-secondary mt-4">Kembali ke Top Actors</a>
</div>
@endsection