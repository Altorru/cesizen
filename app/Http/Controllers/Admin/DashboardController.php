<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'total_articles' => ContentPage::count(),
            'published_articles' => ContentPage::where('is_published', true)->count(),
            'draft_articles' => ContentPage::where('is_published', false)->count(),
            'total_users' => User::count(),
        ];

        return Inertia::render('admin/Index', [
            'stats' => $stats,
        ]);
    }
}
