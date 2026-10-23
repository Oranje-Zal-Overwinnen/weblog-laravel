@extends('layouts.app')

@section('title', $weblog->title)

@section('content')
    <article>
        <h1>{{ $weblog->title }}</h1>

        <p>
            Door {{ $weblog->user->username }} —
            <time datetime="{{ $weblog->published_at->toDateString() }}">{{ $weblog->published_at->format('d-m-Y') }}</time>
        </p>

        @if ($weblog->categories->isNotEmpty())
            <p>
                Categorieën:
                @foreach ($weblog->categories as $category)
                    {{ $category->title }}@if (! $loop->last), @endif
                @endforeach
            </p>
        @endif

        @foreach ($weblog->images as $image)
            <p>
                <img src="{{ Storage::disk('public')->url($image->url) }}" alt="{{ $image->alt_text }}">
            </p>
        @endforeach

        <p>{{ $weblog->text }}</p>

        @can('update', $weblog)
            <p><a href="{{ route('weblogs.edit', $weblog) }}">Bewerken</a></p>
        @endcan
    </article>

    <h2>Commentaar</h2>

    @if ($weblog->comments->isEmpty())
        <p>Er is nog geen commentaar.</p>
    @else
        <ul>
            @foreach ($weblog->comments as $comment)
                <li>
                    <strong>{{ $comment->user->username }}</strong> —
                    <time datetime="{{ $comment->published_at->toDateString() }}">{{ $comment->published_at->format('d-m-Y') }}</time>
                    <p>{{ $comment->text }}</p>
                </li>
            @endforeach
        </ul>
    @endif

    @auth
        <form method="POST" action="{{ route('comments.store', $weblog) }}">
            @csrf

            <p>
                <label for="text">Commentaar</label>
                <textarea id="text" name="text" rows="5" required></textarea>
            </p>

            <button type="submit">Plaats commentaar</button>
        </form>
    @else
        <p><a href="{{ route('login') }}">Log in om commentaar te plaatsen.</a></p>
    @endauth

    <p><a href="{{ route('weblogs.index') }}">Terug naar het overzicht</a></p>
@endsection
