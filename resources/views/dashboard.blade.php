@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-4">Pick a Movie by Mood</h1>
    <div class="text-center my-5">
        <a href="{{ route('movie-picker.start') }}" class="btn btn-lg btn-primary">Start Now</a>
    </div>
    <div class="text-center my-5">
        <a href="{{ route('actors.top') }}" class="btn btn-lg btn-success">Top Actors</a>
    </div>
</div>
@endsection