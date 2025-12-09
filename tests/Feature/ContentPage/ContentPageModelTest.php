<?php

use App\Models\ContentPage;
use App\Models\User;

// Model Tests
test('content page can be created with required fields', function (): void {
    $admin = User::factory()->admin()->create();

    $page = ContentPage::create([
        'slug' => 'test-page',
        'title' => 'Test Page',
        'content' => 'This is test content.',
        'created_by' => $admin->id,
    ]);

    expect($page)->not->toBeNull();
    expect($page->slug)->toBe('test-page');
    expect($page->title)->toBe('Test Page');
    expect($page->is_published)->toBeFalse();
});

test('content page auto-generates slug from title', function (): void {
    $admin = User::factory()->admin()->create();

    $page = ContentPage::create([
        'title' => 'My Amazing Page',
        'content' => 'Content here.',
        'created_by' => $admin->id,
    ]);

    expect($page->slug)->toBe('my-amazing-page');
});

test('content page slug must be unique', function (): void {
    $admin = User::factory()->admin()->create();

    ContentPage::create([
        'slug' => 'duplicate-slug',
        'title' => 'First Page',
        'content' => 'Content.',
        'created_by' => $admin->id,
    ]);

    expect(fn () => ContentPage::create([
        'slug' => 'duplicate-slug',
        'title' => 'Second Page',
        'content' => 'Content.',
        'created_by' => $admin->id,
    ]))->toThrow(\Illuminate\Database\QueryException::class);
});

test('published scope returns only published pages', function (): void {
    $admin = User::factory()->admin()->create();

    ContentPage::factory()->count(3)->create(['created_by' => $admin->id]);
    ContentPage::factory()->count(2)->published()->create(['created_by' => $admin->id]);

    expect(ContentPage::count())->toBe(5);
    expect(ContentPage::published()->count())->toBe(2);
});

test('content page belongs to creator', function (): void {
    $admin = User::factory()->admin()->create();
    $page = ContentPage::factory()->create(['created_by' => $admin->id]);

    expect($page->creator)->not->toBeNull();
    expect($page->creator->id)->toBe($admin->id);
    expect($page->creator->isAdmin())->toBeTrue();
});

test('factory can create published page', function (): void {
    $page = ContentPage::factory()->published()->create();

    expect($page->is_published)->toBeTrue();
    expect($page->published_at)->not->toBeNull();
});
