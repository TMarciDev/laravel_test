@extends('layouts.app')
@section('title', 'Edit label: ' . $label->name)

@section('content')

    <div class="container">
        <h1 style="margin: 10px">Edit Label</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('items.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        {{-- TODO: action, method, enctype --}}
        <form action="{{ route('labels.update', $label) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            {{-- TODO: Validation --}}

            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $label->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{-- A $message ugyanúgy elérhető az error alatt, mint a ciklusok alatt a $loop --}}
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="style" class="col-sm-2 col-form-label py-0">Color*</label>
                <div class="col-sm-10">
                    <input type="color" name="color" id="color" value="{{ old('color', $label->color) }}">
                    @error('color')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="style" class="col-sm-2 col-form-label py-0">Visible:</label>
                <div class="col-sm-10">
                    <input type="checkbox" id="display" name="display" value="1"
                        {{ $label->display ? 'checked' : '' }}>
                </div>
                @error('display')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Edit label</button>
            </div>
        </form>
        @can('delete', App\Label::class)
            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"><i
                    class="far fa-trash-alt">
                    <span></i> Delete label</span>
            </button>
        @endcan
    </div>

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
                    Are you sure you want to delete label <strong>{{ $label->name }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger"
                        onclick="document.getElementById('delete-label-form').submit();">
                        Yes, delete this label
                    </button>

                    {{-- TODO: Route, directives --}}
                    <form id="delete-label-form" action="{{ route('labels.destroy', $label) }}" method="POST"
                        class="d-none">
                        @method('DELETE')
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
