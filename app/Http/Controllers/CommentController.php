<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        //$this->authorize('create', App\Comment::class);
        Auth::check();
        $itemId = $request["itemId"];

        $validated = $request->validate([
            "text" => "required",
        ]);
        $comment = new Comment();
        $comment->text = $validated['text'];
        $comment->item_id = $itemId;
        $comment->author_id = Auth::user()->id;
        $comment->save();

        // Ide már csak akkor jut el a vezérlés, hogyha a validáció sikeres volt
        //Comment::factory()->create($validated);

        Session::flash("comment_created");

        // return redirect()->route('categories.create');
        return Redirect::route("items.show", $itemId);
    }

    public function update(Request $request, Comment $comment)
    {
        // Jogosultságkezelés
        $this->authorize('update', App\Comment::class);

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


        // Post adatainak frissítése
        $comment->name = $validated["name"];
        $comment->color = $validated["color"];
        $comment->display = $validated["display"];
        $comment->save();

        // Ilyenkor a comment_updated default értéke true
        Session::flash("comment_updated", $validated["name"]);
        return Redirect::route("comments.index", $comment);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize("delete", App\Comment::class);

        $comment->delete();

        Session::flash("comment_deleted", $comment->name);

        return Redirect::route("comments.index");
    }
}
