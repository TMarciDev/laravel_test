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
        $this->authorize('create', App\Comment::class);
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
        //$this->authorize("update", $comment);
    }

    public function destroy(Comment $comment, Item $item)
    {
        //$this->authorize("delete", [App\Comment::class, $comment]);
        error_log("deletion on teh was");

        $comment->delete();

        Session::flash("comment_deleted");

        return Redirect::route("items.show", $item);
    }
}
