<?php

//use App\Models\User;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return redirect()->route("items.index");
});

// Route::resource('posts', PostController::class);
// Route::resource('categories', CategoryController::class);

// Egyszerre:
Route::resources([
    "items" => ItemController::class,
    "labels" => LabelController::class,
    "comments" => LabelController::class,
    //"posts" => PostController::class,
    //"categories" => CategoryController::class,
]);

// Route::get('/posts', function () {
//     return view('posts.index', [
//         'users_count' => User::count(),
//     ]);
// })->name('posts.index');

Auth::routes();
