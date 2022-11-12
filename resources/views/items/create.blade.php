@extends('layouts.app')
@section('title', 'Create new item')

@section('content')
    <div class="container">
        <h1>Create new item</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('items.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        {{-- TODO: action, method, enctype --}}
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- TODO: Validation --}}

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
                <label for="description" class="col-sm-2 col-form-label">Description*</label>
                <div class="col-sm-10">
                    <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{-- A $message ugyanúgy elérhető az error alatt, mint a ciklusok alatt a $loop --}}
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="obtained" class="col-sm-2 col-form-label">Obtained*</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control @error('obtained') is-invalid @enderror" id="obtained"
                        name="obtained" value="2022-11-19T14:42:11">
                    @error('obtained')
                        <div class="invalid-feedback">
                            {{-- A $message ugyanúgy elérhető az error alatt, mint a ciklusok alatt a $loop --}}
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>


            <div class="form-group row mb-3">
                <label for="labels" class="col-sm-2 col-form-label py-0">Categories</label>
                <div class="col-sm-10">
                    <div class="row">
                        @forelse ($labels->chunk(4) as $chunk)
                            <div class="col-6 col-md-3 col-lg-2">
                                @foreach ($chunk as $label)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" value="{{ $label->id }}"
                                            id="label{{ $label->id }}" name="labels[]" @checked(in_array($label->id, old('labels', [])))>
                                        <label for="label{{ $label->id }}" class="form-check-label">
                                            <span class="badge" style="background-color: {{ $label->color }}">
                                                {{ $label->name }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            <p>No labels found</p>
                        @endforelse
                    </div>

                    @error('labels.*')
                        <ul class="text-danger">
                            @foreach ($errors->get('labels.*') as $message)
                                <li>{{ $message[0] }}</li>
                            @endforeach
                        </ul>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="cover_image" class="col-sm-2 col-form-label">Cover image</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                            </div>
                            <div id="cover_preview" class="col-12 d-none">
                                <p>Cover preview:</p>
                                <img width="350px" id="cover_preview_image" src="#" alt="Cover preview">
                            </div>
                        </div>
                    </div>
                </div>

                @error('cover_image')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    <br>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Store</button>
            </div>
        </form>
    </div>
@endsection



@section('scripts')
    <script>
        const coverImageInput = document.querySelector('input#cover_image');
        const coverPreviewContainer = document.querySelector('#cover_preview');
        const coverPreviewImage = document.querySelector('img#cover_preview_image');

        coverImageInput.onchange = event => {
            const [file] = coverImageInput.files;
            if (file) {
                coverPreviewContainer.classList.remove('d-none');
                coverPreviewImage.src = URL.createObjectURL(file);
            } else {
                coverPreviewContainer.classList.add('d-none');
            }
        }
    </script>
@endsection
