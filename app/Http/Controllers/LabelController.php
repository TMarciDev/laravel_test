<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;


class LabelController extends Controller
{
    public function create()
    {
        $this->authorize('create', Label::class);
        return view("labels.create", [
            "labels" => Label::all(),
        ]);
    }
}
