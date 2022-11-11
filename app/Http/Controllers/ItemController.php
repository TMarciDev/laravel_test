<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Label;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("items.index", [
            "users_count" => User::count(),
            "items" => Item::orderBy('obtained', 'desc')->paginate(6),
            "labels" => Label::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("items.create", [
            "labels" => Label::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create', App\Item::class);

        $validated = $request->validate([
            "name" => "required|min:3",
            "description" => "required",
            "obtained" => "required|date",
            "labels" => "nullable|array",
            "labels.*" => "numeric|integer|exists:labels,id",
            "cover_image" => "nullable|file|image|max:4096",
        ]);

        $image = null;

        if ($request->hasFile("cover_image")) {
            $file = $request->file("cover_image");

            $image =
                "cover_image_" .
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

        $item = new Item();
        $item->name = $validated["name"];
        $item->description = $validated["description"];
        $item->obtained = $validated["obtained"];
        $item->image = $image;
        $item->save();

        // Labelek-k hozzárendelése a item-hoz az id lista alapján
        if (isset($validated["labels"])) {
            $item->labels()->sync($validated["labels"]);
        }

        Session::flash("item_created", $validated["name"]);

        return Redirect::route("items.show", $item);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view("items.show", [
            "item" => $item,
            "image" => $item->image,
            "labels" => $item->Labels->whereIn('display', 1),
            "comments" => $item->comments()->with('author')->orderBy('updated_at', 'desc')->get(),
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $item)
    {
        // Jogosultságkezelés
        $this->authorize("update", $item);

        return view("items.edit", [
            "item" => $item,
            "categories" => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $item)
    {
        // Jogosultságkezelés
        $this->authorize("update", $item);

        $validated = $request->validate([
            "name" => "required|min:3",
            "description" => "nullable|max:255",
            "text" => "required",
            "categories" => "nullable|array",
            "categories.*" => "numeric|integer|exists:categories,id",
            // checkbox:
            "remove_cover_image" => "nullable|boolean",
            "cover_image" => "nullable|file|image|max:4096",
        ]);

        $image = $item->image;
        $remove_cover_image = isset($validated["remove_cover_image"]);

        if ($request->hasFile("cover_image") && !$remove_cover_image) {
            $file = $request->file("cover_image");

            $image =
                "cover_image_" .
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

        // Régi fájl törlése
        // Ha a path módosult az eredetihez képest
        if (
            $image != $item->image &&
            $item->image !== null
        ) {
            Storage::disk("public")->delete($item->image);
        }

        // Post adatainak frissítése
        $item->name = $validated["name"];
        $item->description = $validated["description"];
        $item->text = $validated["text"];
        $item->image = $image;
        $item->save();

        // Category-k hozzárendelése a item-hoz az id lista alapján
        if (isset($validated["categories"])) {
            // A sync azt fogja csinálni, hogy csak a megadott kategóriák lesznek hozzárendelve
            $item->categories()->sync($validated["categories"]);
        }

        // Ilyenkor a item_updated default értéke true
        Session::flash("item_updated");

        return Redirect::route("items.show", $item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $item)
    {
        $this->authorize("delete", $item);

        $item->delete();

        Session::flash("item_deleted", $item->name);

        return Redirect::route("items.index");
    }
}
