<?php

//use App\Models\User;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return redirect()->route("items.index");
});


// Egyszerre:
Route::resources([
    "items" => ItemController::class,
    "labels" => LabelController::class,
    "comments" => CommentController::class,
]);


Auth::routes();
