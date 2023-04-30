@extends('layouts.app')
@section('title', 'Részletek')
@section('content')
    <div style="display: flex; align-items:center; flex-direction:column">
        @if (Session::has('event_created'))
            <div class="alert alert-success" role="alert">
                Event successfully created!
            </div>
        @endif
        @if (Session::has('game_stopped'))
            <div class="alert alert-success" role="alert">
                Game was stopped
            </div>
        @endif
        <a href="{{ route('home.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        @if (!$game->finished)
            <h1 style="color: lightgreen">Játék folyamatban van</h1>
            @can('stop', App\Game::class)
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"><i
                        class="far fa-trash-alt">
                        <span></i> Stop game</span>
                </button>
            @endcan
        @endif

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
                    <li style="display: flex; margin: 10px">
                        {{ $event->minute }}. perc: {{ $event->type }}, {{ $event->Player->name }},
                        {{ $event->Player->Team->name }}
                        @if (!$game->finished)
                            @can('delete', App\Event::class)
                                <button class="btn btn-sm btn-danger" style="margin-left: 40px" data-bs-toggle="modal"
                                    data-bs-target="#delete-confirm-modal-event"
                                    onClick="handleDeleteEventSelection({{ $event->id }})"><i class="far fa-trash-alt">
                                        <span></i> Delete event</span>
                                </button>
                            @endcan
                        @endif
                    </li>
                @endforeach
            </ul>
            @if (!$game->finished)
                @can('create', App\Event::class)
                    <form method="POST" action="{{ route('events.store', 'gameId=' . $game->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="type" class="col-sm-2 col-form-label">Event típus*</label>
                            <div class="col-sm-10">
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                    <option value="">-- válasszon --</option>
                                    <option value="gól" {{ old('type') == 'gól' ? 'selected' : '' }}>Gól</option>
                                    <option value="öngól" {{ old('type') == 'öngól' ? 'selected' : '' }}>Öngól</option>
                                    <option value="piros lap" {{ old('type') == 'piros lap' ? 'selected' : '' }}>Piros lap
                                    </option>
                                    <option value="sárga lap" {{ old('type') == 'sárga lap' ? 'selected' : '' }}>Sárga lap
                                    </option>
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

    @endif
    </div>
@section('scripts')
    <script>
        const handleDeleteEventSelection = (cId) => {
            let deleteForm = document.getElementById("delete-event-form");
            link = deleteForm.action;
            deleteForm.action = link.replace('##REPLACETHIS##', cId)
        }
    </script>
@endsection
<!-- Modal -->
<div class="modal fade" id="delete-confirm-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- TODO: Title --}}
                Are you sure you want to stop the game?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger"
                    onclick="document.getElementById('stop-game-form').submit();">
                    Yes, stop the games
                </button>

                {{-- TODO: Route, directives --}}
                <form id="stop-game-form" action="{{ route('merkozesek.stop', $game->id) }}" method="POST"
                    class="d-none">
                    @method('POST')
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete-confirm-modal-event" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- TODO: Title --}}
                Are you sure you want to delete your event?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger"
                    onclick="document.getElementById('delete-event-form').submit();">
                    Yes, delete this event
                </button>

                {{-- TODO: Route, directives --}}
                <form id="delete-event-form" action="{{ route('events.destroy', '##REPLACETHIS##') }}"
                    method="POST" class="d-none">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div> <!-- Modal -->
@endsection
