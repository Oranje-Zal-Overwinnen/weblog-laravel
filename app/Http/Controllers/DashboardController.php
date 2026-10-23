<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the protected dashboard with the articles of the authenticated user.
     */
    public function __invoke(Request $request): View
    {
        return view('dashboard', [
            'weblogs' => $request->user()->weblogs()->latest('published_at')->latest('id')->get(),
        ]);
    }
}
