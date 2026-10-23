@extends('layouts.app')

@section('title', 'Premium content')

@section('content')
    <h1>Premium content</h1>

    <p>Met een abonnement krijg je toegang tot alle exclusieve artikelen op dit weblog.</p>

    @if ($isSubscriber)
        <p>Je hebt een actief abonnement en toegang tot alle premium content.</p>

        <form method="POST" action="{{ route('subscription.destroy') }}">
            @csrf
            @method('DELETE')

            <button type="submit">Abonnement opzeggen</button>
        </form>
    @else
        <h2>Premium abonnement</h2>

        <form method="POST" action="{{ route('subscription.store') }}">
            @csrf

            <button type="submit">Nu betalen</button>
        </form>
    @endif
@endsection
