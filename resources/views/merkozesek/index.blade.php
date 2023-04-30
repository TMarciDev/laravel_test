@extends('layouts.app')
@section('title', 'Mérkőzések')
@section('content')
    <div>
        <h1>Mérkőzések oldal</h1>
        <div style="display: flex; flex-wrap: wrap">
            @forelse ($ongoing as $game)
                @if (strtotime($game->start) < time())
                    <div style="border: 5px solid green; margin: 10px; width: 30vw">
                        <div style="display: flex; flex-direction: column; align-items: center; margin: 20px;">
                            <p class="mb-0">
                                <span>
                                    <i class="far fa-calendar-alt"></i>
                                    <span>Schedulet at: {{ $game->start }}</span>
                                </span>
                            </p>
                            <div>
                                <h3>
                                    {{ $game->HomeTeam->name }}
                                </h3>
                                <img id="cover_preview_image" {{-- TODO: Cover --}}
                                    src="{{ asset($game->HomeTeam->image ? 'storage/' . $game->HomeTeam->image : 'images/team_placeholder.jpeg') }}"
                                    width="350px" alt="Cover preview" class="my-3">
                            </div>
                            <h1>-VS-</h1>
                            <div>
                                <h3>
                                    {{ $game->AwayTeam->name }}
                                </h3>
                                <img id="cover_preview_image" {{-- TODO: Cover --}}
                                    src="{{ asset($game->AwayTeam->image ? 'storage/' . $game->AwayTeam->image : 'images/team_placeholder.jpeg') }}"
                                    width="350px" alt="Cover preview" class="my-3">
                            </div>
                            <div>
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
                                    <h1>{{ $game->HomeTeam->name }} - {{ $homeGoals }} : {{ $awayGoals }} -
                                        {{ $game->AwayTeam->name }}</h1>
                                @endif
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('merkozesek.show', $game) }}" class="btn btn-primary">
                                    <span>View game</span> <i class="fas fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
            @endforelse
        </div>
        <div>
            <div style="display: flex; flex-wrap: wrap; margin-top: 10px">
                @forelse ($games as $game)
                    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch">
                        <div class="card w-100">
                            <img src="{{ asset('images/default_game_cover.jpg') }}" class="card-img-top" alt="cover">
                            <div class="card-body"
                                style="display: flex; align-items: center; justify-content: center; flex-direction: column">
                                <p class="mb-0">
                                    <span>
                                        <i class="far fa-calendar-alt"></i>
                                        <span>Schedulet at: {{ $game->start }}</span>
                                    </span>
                                </p>
                                <div>
                                    <h3>
                                        {{ $game->HomeTeam->name }}
                                    </h3>
                                    <img id="cover_preview_image" {{-- TODO: Cover --}}
                                        src="{{ asset($game->HomeTeam->image ? 'storage/' . $game->HomeTeam->image : 'images/team_placeholder.jpeg') }}"
                                        width="350px" alt="Cover preview" class="my-3">
                                </div>
                                <h1>-VS-</h1>
                                <div>
                                    <h3>
                                        {{ $game->AwayTeam->name }}
                                    </h3>
                                    <img id="cover_preview_image" {{-- TODO: Cover --}}
                                        src="{{ asset($game->AwayTeam->image ? 'storage/' . $game->AwayTeam->image : 'images/team_placeholder.jpeg') }}"
                                        width="350px" alt="Cover preview" class="my-3">
                                </div>
                                <div>
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
                                        <h1>{{ $game->HomeTeam->name }} - {{ $homeGoals }} : {{ $awayGoals }} -
                                            {{ $game->AwayTeam->name }}</h1>
                                    @else
                                        <span>Game not started yet</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('merkozesek.show', $game->id) }}" class="btn btn-primary">
                                    <span>View game</span> <i class="fas fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            No games found!
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center">
                {{ $games->links() }}
            </div>
        </div>
    </div>
@endsection
