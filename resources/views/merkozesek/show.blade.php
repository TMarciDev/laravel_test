@extends('layouts.app')
@section('title', 'Részletek')
@section('content')
    <div style="display: flex; align-items:center; flex-direction:column">
        <a href="{{ route('home.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>

        <p class="mb-0">
            <span>
                <i class="far fa-calendar-alt"></i>
                <span>Schedulet at: {{ $game->start }}</span>
            </span>
        </p>
        <div style="display: flex; align-items: center; margin: 40px">
            <div style="display: flex; align-items: center; flex-direction:column">
                <h3>
                    {{ $homeTeam->name }}
                </h3>
                <img id="cover_preview_image"
                    src="{{ asset($homeTeam->image ? 'storage/' . $homeTeam->image : 'images/team_placeholder.jpeg') }}"
                    width="350px" alt="Cover preview" class="my-3">
            </div>
            <h1>-| VS |-</h1>
            <div style="display: flex; align-items: center; flex-direction:column">
                <h3>
                    {{ $awayTeam->name }}
                </h3>
                <img id="cover_preview_image"
                    src="{{ asset($awayTeam->image ? 'storage/' . $hwayTeam->image : 'images/team_placeholder.jpeg') }}"
                    width="350px" alt="Cover preview" class="my-3">
            </div>
        </div>

        @if (strtotime($game->start) < time())
            @php
                $homeGoals = 0;
                $awayGoals = 0;
                foreach ($events as $event) {
                    if ($event->type == 'gól') {
                        if ($players[$event->player_id]->Team->id == $game->HomeTeam->id) {
                            $homeGoals++;
                        } else {
                            $awayGoals++;
                        }
                    } elseif ($event->type == 'öngól') {
                        if ($players[$event->player_id]->Team->id == $game->HomeTeam->id) {
                            $awayGoals++;
                        } else {
                            $homeGoals++;
                        }
                    }
                }
            @endphp
            <h1>{{ $homeTeam->name }} - {{ $homeGoals }} : {{ $awayGoals }} -
                {{ $awayTeam->name }}</h1>

            <ul>
                @foreach ($events as $event)
                    <li>
                        {{-- Todo: finish this --}}
                        {{ $event->type }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
