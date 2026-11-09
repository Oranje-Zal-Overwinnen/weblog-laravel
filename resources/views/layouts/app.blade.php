<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Weblog')</title>
    </head>
    <body>
        <header>
            <nav>
                <a href="{{ route('weblogs.index') }}">Weblog</a> |
                <a href="{{ route('premium.index') }}">Premium content</a>

                @auth
                    | <a href="{{ route('dashboard') }}">Dashboard</a>
                    | <a href="{{ route('weblogs.create') }}">Nieuw artikel</a>
                    | <a href="{{ route('categories.create') }}">Nieuwe categorie toevoegen</a>
                @else
                    | <a href="{{ route('login') }}">Inloggen</a>
                    | <a href="{{ route('register') }}">Registreren</a>
                @endauth
            </nav>
        </header>

        <main>
            @if (session('status'))
                <p role="status">{{ session('status') }}</p>
            @endif

            @include('partials.errors')

            @yield('content')
        </main>
    </body>
</html>
