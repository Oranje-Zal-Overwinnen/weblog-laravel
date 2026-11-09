@extends('layouts.app')

@section('title', 'Inloggen')

@section('content')
    <h1>Inloggen</h1>

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <p>
            <label for="username">Gebruikersnaam</label>
            <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus autocomplete="username">
        </p>

        <p>
            <label for="password">Wachtwoord</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
        </p>

        <button type="submit">Inloggen</button>
    </form>
@endsection
