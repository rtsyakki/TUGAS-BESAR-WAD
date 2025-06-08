@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4">Ready to Pick a Movie?</h2>
    <form action="{{ route('movie-picker.quiz.form') }}" method="GET">
        <button type="submit" class="btn btn-primary btn-lg">Start Now</button>
    </form>
</div>
@endsection