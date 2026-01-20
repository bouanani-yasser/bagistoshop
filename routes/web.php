<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Storage Fallback Route (Windows/Apache symlink workaround)
|--------------------------------------------------------------------------
*/
Route::get('storage/{path}', function (string $path) {
    $path = ltrim($path, '/');

    // Block directory traversal
    if (str_contains($path, '..')) {
        abort(404);
    }

    if (! Storage::disk('public')->exists($path)) {
        abort(404);
    }

    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('storage.serve');