@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4">5 Movie Terbaik Genre {{ $genre }}</h2>
    @if(count($topMovies) > 0)
        <ul class="list-disc pl-8">
            @foreach($topMovies as $movie)
                <li class="mb-2">
                    <strong>{{ $movie->title }}</strong> ({{ $movie->year }})<br>
                    Rating: {{ $movie->rating }}<br>
                    <span class="text-sm text-gray-600">{{ $movie->plot }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-center text-gray-500">Tidak ada film untuk genre ini.</p>
    @endif
    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection