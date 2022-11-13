<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;


class LabelController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', App\Label::class);
        return view("labels.index", [
            "labels" => Label::all(),
        ]);
    }
    public function create()
    {
        $this->authorize('create', App\Label::class);
        return view("labels.create");
    }

    public function edit(Label $label)
    {
        $this->authorize('update', App\Label::class);
        return view("labels.edit", ["label" => $label,]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', App\Label::class);

        if(is_null($request["display"])) {
            $request["display"] = false;
        }

        $validated = $request->validate([
            "name" => "required",
            "color" => [
                'required',
                'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'
            ],
            "display" => "required|bool",
        ]);

        // Ide már csak akkor jut el a vezérlés, hogyha a validáció sikeres volt
        Label::factory()->create($validated);

        Session::flash("label_created", $validated["name"]);

        return Redirect::route("labels.create");
    }

    public function update(Request $request, Label $label)
    {
        // Jogosultságkezelés
        $this->authorize('update', App\Label::class);

        if(is_null($request["display"])) {
            $request["display"] = false;
        }

        $validated = $request->validate([
            "name" => "required",
            "color" => [
                'required',
                'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'
            ],
            "display" => "required|bool",
        ]);


        $label->name = $validated["name"];
        $label->color = $validated["color"];
        $label->display = $validated["display"];
        $label->save();

        // Ilyenkor a label_updated default értéke true
        Session::flash("label_updated", $validated["name"]);
        return Redirect::route("labels.index", $label);
    }

    public function destroy(Label $label)
    {
        $this->authorize("delete", App\Label::class);

        $label->delete();

        Session::flash("label_deleted", $label->name);

        return Redirect::route("labels.index");
    }
}
