@extends('layouts.app')

@section('title', 'Weblog')

@section('content')
    <h1>Weblog</h1>

    <h2>Filteren</h2>

    <form method="GET" action="{{ route('weblogs.index') }}">
        <label for="category">Categorie</label>
        <select id="category" name="category" onchange="this.form.submit()">
            <option value="">Alle categorieën</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected($selectedCategory === $category->id)>
                    {{ $category->title }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filter</button>
    </form>

    <h2>Artikelen</h2>

    @if ($weblogs->isEmpty())
        <p>Er zijn nog geen artikelen.</p>
    @else
        <ul>
            @foreach ($weblogs as $weblog)
                <li>
                    <a href="{{ route('weblogs.show', $weblog) }}">{{ $weblog->title }}</a>
                    — <time datetime="{{ $weblog->published_at->toDateString() }}">{{ $weblog->published_at->format('d-m-Y') }}</time>
                    @if ($weblog->is_premium)
                        <strong>(premium)</strong>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
@endsection
