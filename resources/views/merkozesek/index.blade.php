@extends('layouts.app')
@section('title', 'Labels')
@section('content')
    <div>
        <h1>Mérkőzések oldal</h1>
        <div>Folyamatban lévő meccsek container</div>
        <div>
            <div style="display: flex; flex-wrap: wrap; margin-top: 10px">
                @forelse ($games as $game)
                    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch">
                        <div class="card w-100">
                            <img src="{{ asset($game->image ? 'storage/' . $game->image : 'images/default_game_cover.jpg') }}"
                                class="card-img-top" alt="game cover">
                            <div class="card-body">
                                {{-- TODO: Title --}}
                                <h5 class="card-title mb-0">{{ $game->name }}</h5>
                                <br />
                                <p class="small mb-0">
                                    <span>
                                        <i class="far fa-calendar-alt"></i>
                                        {{-- TODO: Date --}}
                                        <span>Obtained:
                                            {{ substr(str_replace('_', '.', explode(' ', $game->obtained)[0]), 0, 10) }}</span>
                                    </span>
                                </p>

                                {{-- TODO: Short desc --}}
                                <p class="card-text mt-1">{{ Str::of($game->description)->limit(100, ' (...)') }}</p>
                            </div>
                            <div class="card-footer">
                                {{-- TODO: Link --}}
                                <a href="{{ route('games.show', $game) }}" class="btn btn-primary">
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
