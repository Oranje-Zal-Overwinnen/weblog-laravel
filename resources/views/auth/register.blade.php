@extends('layouts.app')

@section('title', 'Registreren')

@section('content')
    <h1>Registreren</h1>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <p>
            <label for="username">Gebruikersnaam</label>
            <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus autocomplete="username">
        </p>

        <p>
            <label for="password">Wachtwoord</label>
            <input id="password" name="password" type="password" required autocomplete="new-password">
        </p>

        <p>
            <label for="password_confirmation">Wachtwoord bevestigen</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password">
        </p>

        <button type="submit">Registreren</button>
    </form>
@endsection
