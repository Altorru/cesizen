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
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/content-pages/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:content_pages,slug',
            'content' => 'required|string',
            'is_published' => 'sometimes|boolean',
        ]);

        $isPublished = $validated['is_published'] ?? false;

        $page = ContentPage::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'is_published' => $isPublished,
            'created_by' => $request->user()->id,
            'published_at' => $isPublished ? now() : null,
        ]);

        return redirect()->route('admin.content-pages.index')
            ->with('success', 'Content page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentPage $contentPage): Response
    {
        return Inertia::render('admin/content-pages/Show', [
            'page' => $contentPage->load('creator'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentPage $contentPage): Response
    {
        return Inertia::render('admin/content-pages/Edit', [
            'page' => $contentPage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentPage $contentPage): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:content_pages,slug,'.$contentPage->id,
            'content' => 'required|string',
            'is_published' => 'sometimes|boolean',
        ]);

        $isPublished = $validated['is_published'] ?? false;

        $contentPage->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ]);

        return redirect()->route('admin.content-pages.index')
            ->with('success', 'Content page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentPage $contentPage): RedirectResponse
    {
        $contentPage->delete();

        return redirect()->route('admin.content-pages.index')
            ->with('success', 'Content page deleted successfully.');
    }
}
