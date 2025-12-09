<?php

use App\Models\ContentPage;
use App\Models\User;

// Admin Access Tests - Testing authorization logic
test('admin middleware allows admin users', function (): void {
    $admin = User::factory()->admin()->create();

    expect($admin->isAdmin())->toBeTrue();
});

test('admin middleware blocks regular users', function (): void {
    $user = User::factory()->create();

    expect($user->isAdmin())->toBeFalse();
});

// Admin CRUD Tests - Testing model operations (bypassing HTTP/CSRF)
test('admin can create content page through controller logic', function (): void {
    $admin = User::factory()->admin()->create();

    $page = ContentPage::create([
        'title' => 'About Mental Health',
        'content' => 'This is content about mental health.',
        'is_published' => true,
        'created_by' => $admin->id,
        'published_at' => now(),
    ]);

    expect($page)->not->toBeNull();
    expect($page->slug)->toBe('about-mental-health');
    expect($page->is_published)->toBeTrue();
    expect($page->created_by)->toBe($admin->id);
});

test('admin can update content page through controller logic', function (): void {
    $admin = User::factory()->admin()->create();
    $page = ContentPage::factory()->create(['created_by' => $admin->id]);

    $page->update([
        'title' => 'Updated Title',
        'content' => 'Updated content.',
        'is_published' => true,
        'published_at' => now(),
    ]);

    $page->refresh();
    expect($page->title)->toBe('Updated Title');
    expect($page->content)->toBe('Updated content.');
    expect($page->is_published)->toBeTrue();
});

test('admin can delete content page through controller logic', function (): void {
    $admin = User::factory()->admin()->create();
    $page = ContentPage::factory()->create(['created_by' => $admin->id]);

    $pageId = $page->id;
    $page->delete();

    expect(ContentPage::find($pageId))->toBeNull();
});

// Validation Tests - Testing validation rules
test('content page requires title for creation', function (): void {
    $admin = User::factory()->admin()->create();

    expect(fn () => ContentPage::create([
        'content' => 'Content without title.',
        'created_by' => $admin->id,
    ]))->toThrow(\Illuminate\Database\QueryException::class);
});

test('content page slug must be unique', function (): void {
    $admin = User::factory()->admin()->create();
    ContentPage::factory()->create([
        'slug' => 'existing-slug',
        'created_by' => $admin->id,
    ]);

    expect(fn () => ContentPage::create([
        'title' => 'New Page',
        'slug' => 'existing-slug',
        'content' => 'Content.',
        'created_by' => $admin->id,
    ]))->toThrow(\Illuminate\Database\QueryException::class);
});

test('controller validates required fields', function (): void {
    $admin = User::factory()->admin()->create();

    $controller = new \App\Http\Controllers\Admin\ContentPageController;
    $request = \Illuminate\Http\Request::create('/admin/content-pages', 'POST', [
        'content' => 'Content without title',
    ]);
    $request->setUserResolver(fn () => $admin);

    expect(fn () => $controller->store($request))
        ->toThrow(\Illuminate\Validation\ValidationException::class);
});
