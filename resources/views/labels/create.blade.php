@extends('layouts.app')
@section('title', 'Create label')

@section('content')
    <div class="container">
        <h1>Create label</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('items.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        {{-- TODO: Session flashes --}}
        @if (Session::has('label_created'))
            <div class="alert alert-success" role="alert">
                Label ({{ Session::get('label_created') }}) successfully created!
            </div>
        @endif

        {{-- TODO: action, method --}}
        <form method="POST" action="{{ route('labels.store') }}">
            @csrf

            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}">
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
                    {{--
                    @foreach ($styles as $style)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="style" id="{{ $style }}"
                            value="{{ $style }}" @checked(old('style') == $style)>
                        <label class="form-check-label" for="{{ $style }}">
                            <span class="badge bg-{{ $style }}">{{ $style }}</span>
                        </label>
                        </div>
                    @endforeach
                    @error('style')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    --}}
                    <input type="color" name="color" id="color" value="#9090ff">
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
                    <input type="checkbox" id="display" name="display" value="1" checked>
                </div>
                @error('display')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Store</button>
            </div>

        </form>
    </div>
@endsection
