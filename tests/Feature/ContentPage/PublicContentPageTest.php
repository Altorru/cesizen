<?php

use App\Models\ContentPage;
use App\Models\User;

test('published content page can be viewed by anyone', function (): void {
    $admin = User::factory()->admin()->create();
    $page = ContentPage::factory()->published()->create([
        'slug' => 'about-us',
        'created_by' => $admin->id,
    ]);

    $retrievedPage = ContentPage::where('slug', 'about-us')->first();

    expect($retrievedPage)->not->toBeNull();
    expect($retrievedPage->is_published)->toBeTrue();
    expect($retrievedPage->slug)->toBe('about-us');
});

test('unpublished content page is not accessible', function (): void {
    $admin = User::factory()->admin()->create();
    $page = ContentPage::factory()->create([
        'slug' => 'draft-page',
        'is_published' => false,
        'created_by' => $admin->id,
    ]);

    $publishedPages = ContentPage::published()->where('slug', 'draft-page')->get();

    expect($publishedPages)->toBeEmpty();
});

test('content page can be found by slug', function (): void {
    $admin = User::factory()->admin()->create();
    ContentPage::factory()->published()->create([
        'slug' => 'mental-health-guide',
        'title' => 'Mental Health Guide',
        'created_by' => $admin->id,
    ]);

    $page = ContentPage::where('slug', 'mental-health-guide')->first();

    expect($page)->not->toBeNull();
    expect($page->title)->toBe('Mental Health Guide');
});
