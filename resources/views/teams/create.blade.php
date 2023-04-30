@extends('layouts.app')
@section('title', 'Create new csapat')

@section('content')
    <div class="container">
        <h1>Create new Csapat</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('teams.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        {{-- TODO: action, method, enctype --}}
        <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="shortname" class="col-sm-2 col-form-label">Short name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('shortname') is-invalid @enderror" id="shortname"
                        name="shortname" value="{{ old('shortname') }}">
                    @error('shortname')
                        <div class="invalid-feedback">
                            {{-- A $message ugyanúgy elérhető az error alatt, mint a ciklusok alatt a $loop --}}
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>


            <div class="form-group row mb-3">
                <label for="image" class="col-sm-2 col-form-label">Cover image</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="file" class="form-control-file" id="image" name="image">
                            </div>
                            <div id="cover_preview" class="col-12 d-none">
                                <p>Cover preview:</p>
                                <img width="350px" id="cover_preview_image" src="#" alt="Cover preview">
                            </div>
                        </div>
                    </div>
                </div>

                @error('image')
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
        const coverImageInput = document.querySelector('input#image');
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
