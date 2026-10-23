<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('categories.create', [
            'categories' => Category::orderBy('title')->get(),
        ]);
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()
            ->route('categories.create')
            ->with('status', 'Categorie toegevoegd.');
    }
}
