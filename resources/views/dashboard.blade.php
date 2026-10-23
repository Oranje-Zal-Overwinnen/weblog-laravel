@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>

    <p>Je bent ingelogd als <strong>{{ auth()->user()->username }}</strong>.</p>

    <h2>Mijn artikelen</h2>

    @if ($weblogs->isEmpty())
        <p>Je hebt nog geen artikelen.</p>
    @else
        <ul>
            @foreach ($weblogs as $weblog)
                <li>
                    <a href="{{ route('weblogs.show', $weblog) }}">{{ $weblog->title }}</a>
                    @if ($weblog->is_premium)
                        <em>(premium)</em>
                    @endif
                    — <time datetime="{{ $weblog->published_at->toDateString() }}">{{ $weblog->published_at->format('d-m-Y') }}</time>

                    <a href="{{ route('weblogs.edit', $weblog) }}">Bewerken</a>

                    <form method="POST" action="{{ route('weblogs.premium', $weblog) }}">
                        @csrf
                        @method('PATCH')

                        <label>
                            <input type="checkbox" name="is_premium" value="1" @checked($weblog->is_premium)>
                            Markeer als Premium
                        </label>

                        <button type="submit">Bijwerken</button>
                    </form>

                    <form method="POST" action="{{ route('weblogs.destroy', $weblog) }}" onsubmit="return confirm('Weet je zeker dat je dit artikel wilt verwijderen?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Verwijderen</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">Uitloggen</button>
    </form>
@endsection
