<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MerkozesekController extends Controller
{
    public function index()
    {
        return view("merkozesek.index", [
            //TODO: mi a fasz
            "games" => Game::all()
        ]);
    }
}
