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
    public function create()
    {
        $this->authorize('create', App\Team::class);
        return view("teams.create", []);
    }

    public function store(Request $request)
    {
        $this->authorize('create', App\Team::class);

        $validated = $request->validate([
            "name" => "required|min:3",
            "shortname" => "required|min:3",
            "image" => "nullable|file|image|max:4096",
        ]);

        $image = null;

        if ($request->hasFile("image")) {
            $file = $request->file("image");

            $image =
                "team_image_" .
                Str::random(10) .
                "." .
                $file->getClientOriginalExtension();

            Storage::disk("public")->put(
                // File útvonala
                $image,
                // File tartalma
                $file->get()
            );
        }

        $team = new Team();
        $team->name = $validated["name"];
        $team->shortname = $validated["shortname"];
        $team->image = $image;
        $team->save();

        Session::flash("team_created", $validated["name"]);

        return Redirect::route("teams.show", $team);
    }

    public function edit($teamId)
    {
        $this->authorize('update', App\Team::class);

        return view("teams.edit", [
            "team" => Team::find($teamId),
        ]);
    }

    public function update(Request $request, Team $team)
    {
        $this->authorize('update', App\Team::class);

        $validated = $request->validate([
            "name" => "required|min:3",
            "shortname" => "required|min:3",
            "image" => "nullable|file|image|max:4096",
        ]);


        $image = $team->image;
        $remove_cover_image = isset($validated["image"]);

        if ($request->hasFile("cover_image") && !$remove_cover_image) {
            $file = $request->file("cover_image");

            $image =
                "team_image_" .
                Str::random(10) .
                "." .
                $file->getClientOriginalExtension();

            Storage::disk("public")->put(
                // File útvonala
                $image,
                // File tartalma
                $file->get()
            );
        }

        if ($remove_cover_image) {
            $image = null;
        }

        if (
            $image != $team->image &&
            $team->image !== null
        ) {
            Storage::disk("public")->delete($team->image);
        }

        $team->name = $validated["name"];
        $team->shortname = $validated["shortname"];
        $team->image = $image;
        $team->save();

        if (isset($validated["labels"])) {
            $team->labels()->sync($validated["labels"]);
        }

        Session::flash("team_updated");

        return Redirect::route("teams.show", $team->id);
    }
}
