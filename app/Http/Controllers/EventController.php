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
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', App\Event::class);
        $gameId = $request["gameId"];
        $game = Game::find($gameId);

        $validated = $request->validate([
            "type" => ['required', Rule::in(['gól', 'öngól', 'piros lap', 'sárga lap'])],
            "minute" => 'required|integer|between:0,110',
            "player_id" => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($game) {
                    $player1 = $game->HomeTeam->Players->find($value);
                    $player2 = $game->AwayTeam->Players->find($value);

                    if (!$player1 && !$player2) {
                        $fail("The selected player is not in any of the teams.");
                    }
                }
            ]
        ]);
        $event = new Event();
        $event->type = $validated['type'];
        $event->game_id = $gameId;
        $event->minute = $validated['minute'];
        $event->player_id = $validated['player_id'];

        $event->save();

        Session::flash("event_created");
        return Redirect::route("merkozesek.show", $gameId);
    }
}
