<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;


class LabelController extends Controller
{
    public function create()
    {
        return view("labels.create", [
            "labels" => Label::all(),
        ]);
    }
}
