<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use function now;
use function redirect;

class ContentPageController extends Controller
{
    /**
     * Afficher la liste des ressources.
     */
    public function index(): Response
    {
        $pages = ContentPage::with('creator')
            ->latest()
            ->paginate(15);

        return Inertia::render('admin/content-pages/Index', [
            'pages' => $pages,
        ]);
    }

    /**
     * Afficher le formulaire de création d'une nouvelle ressource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/content-pages/Create');
    }

    /**
     * Enregistrer une nouvelle ressource en base de données.
     */
    public function store(Request $request): RedirectResponse
    {
        \Log::info('ContentPage Store - Raw Input:', $request->all());
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:content_pages,slug',
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);
        
        \Log::info('ContentPage Store - Validated:', $validated);
        \Log::info('ContentPage Store - is_published type:', ['type' => gettype($validated['is_published'] ?? null), 'value' => $validated['is_published'] ?? 'null']);

        $page = ContentPage::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'is_published' => $validated['is_published'] ?? false,
            'created_by' => $request->user()->id,
            'published_at' => ($validated['is_published'] ?? false) ? now() : null,
        ]);

        return redirect()->route('admin.content-pages.index')
            ->with('success', 'Page de contenu créée avec succès.');
    }

    /**
     * Afficher la ressource spécifiée.
     */
    public function show(ContentPage $contentPage): Response
    {
        return Inertia::render('admin/content-pages/Show', [
            'page' => $contentPage->load('creator'),
        ]);
    }

    /**
     * Afficher le formulaire d'édition de la ressource spécifiée.
     */
    public function edit(ContentPage $contentPage): Response
    {
        return Inertia::render('admin/content-pages/Edit', [
            'page' => $contentPage,
        ]);
    }

    /**
     * Mettre à jour la ressource spécifiée en base de données.
     */
    public function update(Request $request, ContentPage $contentPage): RedirectResponse
    {
        \Log::info('ContentPage Update - Raw Input:', $request->all());
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:content_pages,slug,'.$contentPage->id,
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);
        
        \Log::info('ContentPage Update - Validated:', $validated);
        \Log::info('ContentPage Update - is_published type:', ['type' => gettype($validated['is_published'] ?? null), 'value' => $validated['is_published'] ?? 'null']);

        $contentPage->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'is_published' => $validated['is_published'] ?? false,
            'published_at' => ($validated['is_published'] ?? false) ? now() : null,
        ]);

        return redirect()->route('admin.content-pages.index')
            ->with('success', 'Page de contenu mise à jour avec succès.');
    }

    /**
     * Supprimer la ressource spécifiée de la base de données.
     */
    public function destroy(ContentPage $contentPage): RedirectResponse
    {
        $contentPage->delete();

        return redirect()->route('admin.content-pages.index')
            ->with('success', 'Page de contenu supprimée avec succès.');
    }
}
