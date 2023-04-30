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

class TeamController extends Controller
{
    public function index()
    {
        return view("teams.index", [
            "teams" => Team::orderBy('name', 'asc')->paginate(6),
        ]);
    }
    public function show($teamId)
    {
        return view("teams.show", [
            "team" => Team::find($teamId),
            "players" => Team::find($teamId)->Players,
            "games" => Game::query()
                ->where('home_team_id', $teamId)
                ->orWhere('away_team_id', $teamId)
                ->get(),
            "events" => Event::all()
        ]);
    }
}
