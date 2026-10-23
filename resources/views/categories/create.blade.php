@extends('layouts.app')

@section('title', 'Nieuwe categorie')

@section('content')
    <h1>Nieuwe categorie toevoegen</h1>

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <p>
            <label for="title">Categorienaam</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}" required>
        </p>

        <button type="submit">Nieuwe categorie toevoegen</button>
    </form>

    <h2>Bestaande categorieën</h2>

    @if ($categories->isEmpty())
        <p>Er zijn nog geen categorieën.</p>
    @else
        <ul>
            @foreach ($categories as $category)
                <li>{{ $category->title }}</li>
            @endforeach
        </ul>
    @endif

    <p><a href="{{ route('dashboard') }}">Terug naar het dashboard</a></p>
@endsection
