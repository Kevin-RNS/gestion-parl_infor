<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    // Liste des catégories rt nombre d'equipements par catégorie 
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
            ->with('success', 'Catégorie créée avec succès.');
    }

    // Filtre catégorie
    public function show(Category $category)
    {
        $category->load('devices.room');

        return view('categories.show', compact('category'));
    }
}