<?php

//use App\Models\User;



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
//TODO: delete the this
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\CommentController;

Route::get("/", function () {
    return redirect()->route("home.index");
});


// Egyszerre:
Route::resources([

    "home" => HomeController::class,
    // TODO: delete this
    "items" => ItemController::class,
    "labels" => LabelController::class,
    "comments" => CommentController::class,
]);


Auth::routes();
