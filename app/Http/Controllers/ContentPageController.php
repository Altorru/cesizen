<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use Inertia\Inertia;
use Inertia\Response;

class ContentPageController extends Controller
{
    /**
     * Afficher la liste des pages de contenu publiées.
     */
    public function index(): Response
    {
        $pages = ContentPage::published()
            ->with('creator')
            ->latest('published_at')
            ->paginate(12);

        return Inertia::render('content/Index', [
            'pages' => $pages,
        ]);
    }

    /**
     * Afficher la page de contenu spécifiée.
     */
    public function show(string $slug): Response
    {
        $page = ContentPage::published()
            ->where('slug', $slug)
            ->with('creator')
            ->firstOrFail();

        return Inertia::render('content/Show', [
            'page' => $page,
        ]);
    }
}
