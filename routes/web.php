<?php

//use App\Models\User;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MerkozesekController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamController;

Route::get("/", function () {
    return redirect()->route("home.index");
});
Route::post('/merkozesek/{gameId}/stop', 'App\Http\Controllers\MerkozesekController@stop')
    ->name('merkozesek.stop');

// Egyszerre:
Route::resources([

    "home" => HomeController::class,
    "merkozesek" => MerkozesekController::class,
    "events" => EventController::class,
    "teams" => TeamController::class,
]);


Auth::routes();
