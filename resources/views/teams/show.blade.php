@extends('layouts.app')
@section('title', $team->name)
@section('content')
    <div style="display: flex; align-items:center; flex-direction:column">
        <h1>Mérkőzések</h1>

        @forelse ($games as $game)
            <div>
                Mérkőzés: {{ $game->start }}
                @if (strtotime($game->start) < time())
                    @php
                        $homeGoals = 0;
                        $awayGoals = 0;
                        foreach ($game->events as $event) {
                            if ($event->type == 'gól') {
                                if ($event->Player->Team->id == $game->HomeTeam->id) {
                                    $homeGoals++;
                                } else {
                                    $awayGoals++;
                                }
                            } elseif ($event->type == 'öngól') {
                                if ($event->Player->Team->id == $game->HomeTeam->id) {
                                    $awayGoals++;
                                } else {
                                    $homeGoals++;
                                }
                            }
                        }
                    @endphp
                    <b>Állás: {{ $game->HomeTeam->name }} - {{ $homeGoals }} : {{ $awayGoals }} -
                        {{ $game->HomeTeam->name }}</b>
                @endif
            </div>
        @empty
            <div>No games so far</div>
        @endforelse

        <h1>Players:</h1>
        @forelse ($players as $player)
            <div><b>{{ $player->name }}</b>, {{ $player->birthdate }},
                Gólok: {{ count($events->where('player_id', $player->id)->where('type', 'gól')) }}
                Öngólok: {{ count($events->where('player_id', $player->id)->where('type', 'öngól')) }}
                Prios lapok: {{ count($events->where('player_id', $player->id)->where('type', 'piros lap')) }}
                Sárga lapok: {{ count($events->where('player_id', $player->id)->where('type', 'sárga lap')) }}
            </div>
        @empty
        @endforelse
    </div>
@endsection
