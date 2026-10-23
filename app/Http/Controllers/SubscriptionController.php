<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Activate the premium subscription of the authenticated user.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->is_subscriber = true;
        $user->save();

        return redirect()
            ->route('premium.index')
            ->with('status', 'Je abonnement is actief.');
    }

    /**
     * Revoke the premium subscription of the authenticated user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->is_subscriber = false;
        $user->save();

        return redirect()
            ->route('premium.index')
            ->with('status', 'Je abonnement is opgezegd.');
    }
}
