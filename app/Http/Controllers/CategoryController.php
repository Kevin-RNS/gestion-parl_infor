<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Liste des catégories et nombre d'équipements par catégorie.
     */
    public function index()
    {
        $categories = Category::withCount('devices')->orderBy('nom')->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return redirect()
            ->route('categories.show', $category)
            ->with('success', 'Catégorie « '.$category->nom.' » créée avec succès.');
    }

    /**
     * Affiche une catégorie et ses équipements.
     */
    public function show(Category $category)
    {
        $category->load('devices.room');

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()
            ->route('categories.show', $category)
            ->with('success', 'Catégorie « '.$category->nom.' » modifiée avec succès.');
    }

    public function destroy(Category $category)
    {
        $nom = $category->nom;
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie « '.$nom.' » supprimée.');
    }

    /**
     * Page de confirmation avant suppression.
     */
    public function confirmDestroy(Category $category)
    {
        return view('confirm-delete', [
            'name' => $category->nom,
            'route' => route('categories.destroy', $category),
            'back' => route('categories.show', $category),
        ]);
    }
}
