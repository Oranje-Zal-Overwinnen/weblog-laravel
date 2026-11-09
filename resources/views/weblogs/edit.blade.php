@extends('layouts.app')

@section('title', 'Artikel bewerken')

@section('content')
    <h1>Artikel bewerken</h1>

    <form method="POST" action="{{ route('weblogs.update', $weblog) }}" enctype="multipart/form-data">
        @include('weblogs._form')
    </form>

    <p><a href="{{ route('weblogs.show', $weblog) }}">Terug naar het artikel</a></p>
@endsection
