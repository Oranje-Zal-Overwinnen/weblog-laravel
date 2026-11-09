<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWeblogRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Weblog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WeblogController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->integer('category');

        $weblogs = Weblog::query()
            ->visibleTo($request->user())
            ->with('categories')
            ->when($category, fn(Builder $query) => $query->whereHas(
                'categories',
                fn(Builder $query) => $query->whereKey($category)
            ))
            ->latest('published_at')
            ->latest('id')
            ->get();

        return view('weblogs.index', [
            'weblogs' => $weblogs,
            'categories' => Category::orderBy('title')->get(),
            'selectedCategory' => $category,
        ]);
    }

    public function create(): View
    {
        return view('weblogs.create', [
            'weblog' => new Weblog(),
            'categories' => Category::orderBy('title')->get(),
        ]);
    }

    public function store(StoreWeblogRequest $request): RedirectResponse
    {
        $weblog = $request->user()->weblogs()->create([
            'title' => $request->validated('title'),
            'text' => $request->validated('text'),
            'is_premium' => $request->boolean('is_premium'),
            'published_at' => now(),
        ]);

        $weblog->categories()->sync($request->validated('categories', []));

        $this->storeImage($request, $weblog);

        return redirect()
            ->route('weblogs.show', $weblog)
            ->with('status', 'Artikel opgeslagen.');
    }

    public function show(Request $request, Weblog $weblog): View
    {
        if (! $weblog->isVisibleTo($request->user())) {
            abort(404);
        }

        $weblog->load([
            'user',
            'categories',
            'images',
            'comments' => fn($query) => $query->latest('published_at'),
            'comments.user',
        ]);

        return view('weblogs.show', [
            'weblog' => $weblog,
        ]);
    }

    public function edit(Weblog $weblog): View
    {
        Gate::authorize('update', $weblog);

        return view('weblogs.edit', [
            'weblog' => $weblog->load('categories'),
            'categories' => Category::orderBy('title')->get(),
        ]);
    }

    public function update(StoreWeblogRequest $request, Weblog $weblog): RedirectResponse
    {
        Gate::authorize('update', $weblog);

        $weblog->update([
            'title' => $request->validated('title'),
            'text' => $request->validated('text'),
            'is_premium' => $request->boolean('is_premium'),
        ]);

        $weblog->categories()->sync($request->validated('categories', []));

        $this->storeImage($request, $weblog);

        return redirect()
            ->route('weblogs.show', $weblog)
            ->with('status', 'Artikel bijgewerkt.');
    }

    public function updatePremium(Request $request, Weblog $weblog): RedirectResponse
    {
        Gate::authorize('update', $weblog);

        $weblog->update([
            'is_premium' => $request->boolean('is_premium'),
        ]);

        return back()->with(
            'status',
            $weblog->is_premium ? 'Artikel gemarkeerd als premium.' : 'Artikel is niet langer premium.'
        );
    }

    public function destroy(Weblog $weblog): RedirectResponse
    {
        Gate::authorize('delete', $weblog);

        $weblog->images->each(
            fn(Image $image) => Storage::disk('public')->delete($image->url)
        );

        $weblog->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', 'Artikel verwijderd.');
    }


    private function storeImage(WeblogRequest $request, Weblog $weblog): void
    {
        if (! $request->hasFile('image')) {
            return;
        }

        $path = $request->file('image')->store('weblogs', 'public');

        $weblog->images()->create([
            'url' => $path,
            'alt_text' => $weblog->title,
            'uploaded_at' => now(),
        ]);
    }
}
