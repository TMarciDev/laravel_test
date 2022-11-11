@extends('layouts.app')
@section('title', 'Labels')
@section('content')
    <h1 style="margin: 10px">Label Manager</h1>
    <p style="margin: 10px">Click on the label to edit or delete</p>
    @if (Session::has('label_updated'))
        <div class="alert alert-success" role="alert">
            Label ({{ Session::get('label_updated') }}) successfully edited!
        </div>
    @endif
    @if (Session::has('label_deleted'))
        <div class="alert alert-success" role="alert">
            Label ({{ Session::get('label_deleted') }}) successfully deleted!
        </div>
    @endif
    <div style="display: flex; flex-wrap: wrap">
        @forelse ($labels as $label)
            <div style="margin: 10px">
                {{-- TODO: Link --}}
                <a href="{{ route('labels.edit', $label) }}" class="">
                    <span class="badge" style="background-color: {{ $label->color }}">{{ $label->name }}</span>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    No labels found!
                </div>
            </div>
        @endforelse
    </div>
    <a style="margin: 10px" role="button" class="btn btn-sm btn-primary" href="{{ route('labels.create') }}"><i
            class="far fa-edit"></i>
        Create Label</a>
@endsection
