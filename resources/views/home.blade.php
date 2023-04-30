@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div clFss="container" style="margin: 10px;  height: 100vh; font-size: 200%">
        <div style="margin-top: 10px; width: 100%; text-align: center">
            <h1>Foci app</h1>
            <p>
                A feladatod egy fikcionális labdarúgó-bajnokságot kezelő webes alkalmazás elkészítése, ahol böngészhetők és
                megfelelő jogosultság esetén szerkeszthetők az egyes csapatok és játékosok adatai, illetve a meccsek
                időpontjai és eseményei.
            </p>
        </div>
        <ul>
            <li><a href="/merkozesek">Mérkőzések</a></li>
            <li><a href="/teams">Csapatok</a></li>
            <li><a href="/tabella">Tabella</a></li>
            <li><a href="/kedvenceim">Kedvenceim</a></li>
        </ul>
    </div>
@endsection
