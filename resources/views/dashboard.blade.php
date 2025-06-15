@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="d-flex justify-content-center align-items-center mb-4" style="gap: 24px;">
        <h1 class="text-3xl font-bold mb-0">Pick a Movie by Mood</h1>
      
    </div>
    <div class="text-center my-5">
        <a href="{{ route('movie-picker.start') }}" class="btn btn-lg btn-primary">Start Now</a>
    </div>
</div>
@endsection