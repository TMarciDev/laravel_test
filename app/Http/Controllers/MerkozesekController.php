<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use App\Models\Player;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MerkozesekController extends Controller
{
    public function index()
    {
        return view("merkozesek.index", [
            "games" => Game::orderBy('start', 'desc')->paginate(6),
            "ongoing" => Game::all()->whereIn('finished', 0),
            "players" => Player::all(),
        ]);
    }
    public function show(Game $game)
    {
        return view("merkozesek.show", [
        ]);
    }
}
