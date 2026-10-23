<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Weblog;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Store a comment on the given article.
     */
    public function store(StoreCommentRequest $request, Weblog $weblog): RedirectResponse
    {
        if (! $weblog->isVisibleTo($request->user())) {
            abort(404);
        }

        $weblog->comments()->create([
            'user_id' => $request->user()->id,
            'text' => $request->validated('text'),
            'published_at' => now(),
        ]);

        return back()->with('status', 'Commentaar geplaatst.');
    }
}
