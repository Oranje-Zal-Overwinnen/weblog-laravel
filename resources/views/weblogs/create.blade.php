@extends('layouts.app')

@section('title', 'Nieuw artikel')

@section('content')
    <h1>Nieuw artikel</h1>

    <form method="POST" action="{{ route('weblogs.store') }}" enctype="multipart/form-data">
        @include('weblogs._form')
    </form>

    <p><a href="{{ route('weblogs.index') }}">Terug naar het overzicht</a></p>
@endsection
