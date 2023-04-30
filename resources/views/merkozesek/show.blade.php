@extends('layouts.app')
@section('title', 'Részletek')
@section('content')
    <div style="display: flex; align-items:center; flex-direction:column">
        @if (Session::has('event_created'))
            <div class="alert alert-success" role="alert">
                Event successfully created!
            </div>
        @endif
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
            <h1>{{ $homeTeam->name }} - {{ $homeGoals }} : {{ $awayGoals }} -
                {{ $awayTeam->name }}</h1>

            <ul>
                @foreach ($events as $event)
                    <li>
                        {{ $event->minute }}. perc: {{ $event->type }}, {{ $event->Player->name }},
                        {{ $event->Player->Team->name }}
                    </li>
                @endforeach
            </ul>
            @can('create', App\Event::class)
                <form method="POST" action="{{ route('events.store', 'gameId=' . $game->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row mb-3">
                        <label for="type" class="col-sm-2 col-form-label">Event típus*</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="">-- válasszon --</option>
                                <option value="gól" {{ old('type') == 'gól' ? 'selected' : '' }}>Gól</option>
                                <option value="öngól" {{ old('type') == 'öngól' ? 'selected' : '' }}>Öngól</option>
                                <option value="piros lap" {{ old('type') == 'piros lap' ? 'selected' : '' }}>Piros lap</option>
                                <option value="sárga lap" {{ old('type') == 'sárga lap' ? 'selected' : '' }}>Sárga lap</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row mb-3">
                        <label for="style" class="col-sm-2 col-form-label py-0">minute*</label>
                        <div class="col-sm-10">
                            <input type="number" name="minute" id="minute" value="10">
                            @error('minute')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="player_id" class="col-sm-2 col-form-label py-0">Player*</label>
                        <div class="col-sm-10">
                            <h1 class="text-success mb-2">{{ $homeTeam->name }}</h1>
                            @foreach ($homeTeam->players as $player)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="player_id"
                                        id="player_{{ $player->id }}" value="{{ $player->id }}"
                                        {{ old('player_id') == $player->id ? 'checked' : '' }}>
                                    <label class="form-check-label text-success"
                                        for="player_{{ $player->id }}">{{ $player->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="player_id" class="col-sm-2 col-form-label py-0"></label>
                        <div class="col-sm-10">
                            <h1 class="text-danger mb-2">{{ $awayTeam->name }}</h1>
                            @foreach ($awayTeam->players as $player)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="player_id"
                                        id="player_{{ $player->id }}" value="{{ $player->id }}"
                                        {{ old('player_id') == $player->id ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger"
                                        for="player_{{ $player->id }}">{{ $player->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @error('player_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create event</button>
        </div>

        </form>
    @endcan
    @endif
    </div>
@endsection
