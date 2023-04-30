<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use App\Models\Player;
use App\Models\Event;

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
            "ongoing" => Game::all()->whereIn('finished', 0)->sortBy('start', -1),
            "players" => Player::all(),
        ]);
    }
    public function show($gameId)
    {
        return view("merkozesek.show", [
            "game" => Game::find($gameId),
            "events" => Event::orderBy('minute', 'desc')->get()->whereIn('game_id', $gameId),
            "homeTeam" => Game::find($gameId)->HomeTeam,
            "awayTeam" => Game::find($gameId)->AwayTeam,
            "homePlayers" => Game::find($gameId)->HomeTeam->Players,
            "awayPlayers" => Game::find($gameId)->AwayTeam->Players,
        ]);
    }
    public function stop($gameId)
    {
        $this->authorize('stop', App\Game::class);
        $game = Game::find($gameId);
        $game->finished = true;
        $game->save();
        Session::flash("game_stopped");
        return Redirect::route("merkozesek.show", $gameId);
    }
}
