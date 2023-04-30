@extends('layouts.app')
@section('title', 'Csapatok')
@section('content')
    <div>
        <h1>Csapatok oldal</h1>
        <div>
            <div style="display: flex; margin-top: 10px; flex-direction: column">
                @forelse ($teams as $team)
                    <div style="display: flex; align-items:center">
                        <img id="cover_preview_image" {{-- TODO: Cover --}}
                            src="{{ asset($team->image ? 'storage/' . $teamseam->image : 'images/team_placeholder.jpeg') }}"
                            width="350px" alt="Cover preview" class="my-3">
                        <h1>{{ $team->name }}</h1>
                        <h2>({{ $team->shortname }})</h2>
                        <a href="{{ route('teams.show', $team->id) }}" class="btn btn-primary">
                            <span>View csapat</span> <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            No teams found!
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center">
                {{ $teams->links() }}
            </div>
        </div>
    </div>
@endsection
