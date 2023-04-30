@extends('layouts.app')
@section('title', 'Edit game')

@section('content')
    <div class="container">
        <h1>Edit mérkőzés</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('home.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        {{-- TODO: Session flashes --}}
        @if (Session::has('game_updated'))
            <div class="alert alert-success" role="alert">
                Game successfully updated!
            </div>
        @endif

        {{-- TODO: action, method --}}
        <form method="POST" action="{{ route('merkozesek.update', $game->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group row mb-3">
                <label for="start" class="col-sm-2 col-form-label">Start*</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control @error('start') is-invalid @enderror" id="start"
                        name="start" value="{{ old('start', $game->start) }}">
                    @error('start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="home_team_id" class="col-sm-2 col-form-label">Home team*</label>
                <div class="col-sm-10">
                    <select class="form-control @error('home_team_id') is-invalid @enderror" id="home_team_id"
                        name="home_team_id">
                        <option value="" disabled>Select home team</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" {{ $game->home_team_id == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}</option>
                        @endforeach
                    </select>
                    @error('home_team_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="away_team_id" class="col-sm-2 col-form-label">Away team*</label>
                <div class="col-sm-10">
                    <select class="form-control @error('away_team_id') is-invalid @enderror" id="away_team_id"
                        name="away_team_id">
                        <option value="" disabled>Select away team</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" {{ $game->away_team_id == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}</option>
                        @endforeach
                    </select>
                    @error('away_team_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update game</button>
            </div>

        </form>
    </div>
@endsection
