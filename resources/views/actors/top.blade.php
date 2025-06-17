@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Top Actors</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($actors as $actor)
            <div class="bg-white rounded shadow p-4 flex flex-col items-center">
                <img src="{{ $actor->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($actor->name) }}" alt="{{ $actor->name }}" class="w-24 h-24 rounded-full mb-3 object-cover">
                <h3 class="text-lg font-semibold mb-2">{{ $actor->name }}</h3>
                <a href="{{ route('actors.movies', $actor->id) }}" class="btn btn-primary">Lihat Film</a>
            </div>
        @endforeach
    </div>
</div>
@endsection