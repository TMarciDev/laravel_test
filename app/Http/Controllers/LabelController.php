<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;


class LabelController extends Controller
{
    public function create()
    {
        $this->authorize('create', App\Label::class);
        return view("labels.create");
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

        // return redirect()->route('categories.create');
        return Redirect::route("labels.create");
    }
}
