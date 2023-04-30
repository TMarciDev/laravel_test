<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
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
    public function create()
    {
        $this->authorize('create', App\Game::class);
        return view("merkozesek.create", [
            "teams" => Team::all(),
        ]);
    }
    public function edit($gameId)
    {
        $this->authorize('update', App\Game::class);

        return view("merkozesek.edit", [
            "game" => Game::find($gameId),
            "teams" => Team::all(),
        ]);
    }
    public function store(Request $request)
    {
        $this->authorize('create', App\Game::class);

        $validated = $request->validate([
            'start' => ['required', 'date', 'after:now'],
            'home_team_id' => 'required|different:away_team_id',
            'away_team_id' => 'required',
        ]);
        $game = new Game();
        $game->start = $validated['start'];
        $game->home_team_id = $validated['home_team_id'];
        $game->away_team_id = $validated['away_team_id'];
        $game->finished = false;
        $game->save();
        Session::flash("game_created");
        return Redirect::route("merkozesek.create");
    }
    public function update(Request $request, $id)
    {
        $this->authorize('update', App\Game::class);

        $validated = $request->validate([
            'start' => ['required', 'date', 'after:now'],
            'home_team_id' => 'required|different:away_team_id',
            'away_team_id' => 'required',
        ]);
        $game = Game::findOrFail($id);
        $game->start = $validated['start'];
        $game->home_team_id = $validated['home_team_id'];
        $game->away_team_id = $validated['away_team_id'];
        $game->finished = false;
        $game->save();
        Session::flash("game_updated");
        return Redirect::route("merkozesek.edit", $id);
    }
    public function destroy($id)
    {
        $this->authorize('delete', App\Game::class);

        $game = Game::find($id);

        if (!$game) {
            abort(404);
        }

        $game->delete();

        Session::flash("game_deleted");
        return redirect()->route("merkozesek.index");
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
