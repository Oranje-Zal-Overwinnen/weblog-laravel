<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PremiumController extends Controller
{
    /**
     * Show the overview of the premium content and subscription offer.
     */
    public function __invoke(Request $request): View
    {
        return view('premium', [
            'isSubscriber' => $request->user()?->is_subscriber ?? false,
        ]);
    }
}
