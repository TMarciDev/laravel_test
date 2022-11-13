@extends('layouts.app')
{{-- TODO: Item title --}}
@section('title', 'View item: ' . $item->title)

@section('content')
    <div class="container">

        {{-- TODO: Session flashes --}}
        @if (Session::has('item_created'))
            <div class="alert alert-success" role="alert">
                Item ({{ Session::get('item_created') }}) successfully created!
            </div>
        @endif

        @if (Session::has('item_updated'))
            <div class="alert alert-success" role="alert">
                Item successfully updated!
            </div>
        @endif

        @if (Session::has('comment_created'))
            <div class="alert alert-success" role="alert">
                Comment created succesfully!
            </div>
        @endif

        @if (Session::has('comment_deleted'))
            <div class="alert alert-success" role="alert">
                Comment deleted succesfully!
            </div>
        @endif

        @if (Session::has('comment_updated'))
            <div class="alert alert-success" role="alert">
                Comment edited succesfully!
            </div>
        @endif

        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                {{-- TODO: Title --}}
                <h1>{{ $item->name }}</h1>

                {{-- TODO: Author
                <p class="small text-secondary mb-0">
                    <i class="fas fa-user"></i>
                    <span>By {{ $item->author ? $item->author->name : "Unknown" }}</span>
                </p>
            --}}
                <p class="small text-secondary mb-0">
                    <i class="far fa-calendar-alt"></i>
                    <span>Obtained: </span>
                    {{-- TODO: Date --}}
                    {{ substr(str_replace('_', '.', explode(' ', $item->obtained)[0]), 0, 10) }}</span>
                </p>

                <div class="mb-2">
                    {{-- TODO: Read item categories from DB
                    @foreach ($item->categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="text-decoration-none">
                        <span class="badge bg-{{ $category->style }}">{{ $category->name }}</span>
                    </a>
                    @endforeach
                --}}
                    @forelse ($labels as $label)
                        <span class="badge" style="background-color: {{ $label->color }}">{{ $label->name }}</span>
                    @empty
                        No label is added.
                    @endforelse

                </div>

                {{-- TODO: Link --}}
                <a href="{{ route('items.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>

            </div>


            <div class="col-12 col-md-4">
                <div class="float-lg-end">

                    @can('update', App\Item::class)
                        <a role="button" class="btn btn-sm btn-primary" href="{{ route('items.edit', $item) }}"><i
                                class="far fa-edit"></i> Edit item</a>
                    @endcan

                    @can('delete', App\Item::class)
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"><i
                                class="far fa-trash-alt">
                                <span></i> Delete item</span>
                        </button>
                    @endcan

                </div>
            </div>


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
                        Are you sure you want to delete item <strong>{{ $item->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger"
                            onclick="document.getElementById('delete-item-form').submit();">
                            Yes, delete this item
                        </button>

                        {{-- TODO: Route, directives --}}
                        <form id="delete-item-form" action="{{ route('items.destroy', $item) }}" method="POST"
                            class="d-none">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            {{ $item->image }}
            {{ $image }}
        </div>

        <img id="cover_preview_image" {{-- TODO: Cover --}}
            src="{{ asset($item->image ? 'storage/' . $item->image : 'images/default_item_cover.jpg') }}" width="350px"
            alt="Cover preview" class="my-3">

        <div class="mt-3">
            {{-- TODO: Item paragraphs --}}
            {!! nl2br(e($item->description)) !!}
        </div>
        <div>
            @auth
                <h4>Create comment</h4>
                <form action="{{ route('comments.store', 'itemId=' . $item->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="text" class="col-sm-2 col-form-label">Comment text*</label>
                        <div class="col-sm-10">
                            <textarea rows="5" class="form-control @error('text') is-invalid @enderror" id="text" name="text">{{ old('text') }}</textarea>
                            @error('text')
                                <div class="invalid-feedback">
                                    {{-- A $message ugyanúgy elérhető az error alatt, mint a ciklusok alatt a $loop --}}
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit comment</button>
                    </div>
                </form>
            @endauth

            @section('scripts')
                <script>
                    const handleDeleteCommentSelection = (cId) => {
                        let deleteForm = document.getElementById("delete-comment-form");
                        link = deleteForm.action;
                        deleteForm.action = link.replace('##REPLACETHIS##', cId)
                    }

                    let updatedText = "";
                    const handleUpdateCommentSelection = (cId, cText) => {
                        text = atob(cText);
                        const textarea = document.querySelector('#edit-confirm-modal #text-comment')
                        textarea.value = text;
                        updatedText = text;

                        let editForm = document.getElementById("edit-comment-form");
                        link = editForm.action;
                        editForm.action = link.replace('##REPLACETHIS##', cId)

                        const realInput = document.querySelector('#edit-confirm-modal #text');
                        realInput.innerText = text;
                    }
                    document.querySelector('#edit-confirm-modal #text-comment').addEventListener("input", () => {
                        const text = document.querySelector('#edit-confirm-modal #text-comment').value;
                        const realInput = document.querySelector('#edit-confirm-modal #text');
                        updatedText = text;
                        realInput.value = updatedText;
                    })
                </script>
            @endsection

            <h3>Comments: </h3>
            <ul>
                @forelse ($comments as $comment)
                    <li
                        style="
                            @can('update', [App\Comment::class, $comment])
                                border-left: 4px solid teal
                            @endcan
                    ">
                        <div style="margin: 10px">
                            <b>{{ $comment->author->name }}</b>
                            <br />
                            {!! nl2br(e($comment->text)) !!}
                            <br />
                            <hr />
                            <i class="far fa-calendar-alt"></i>
                            <span>Date: </span>
                            <span>{{ $comment->created_at }}</span>
                            <br />
                            <hr />
                            @can('update', [App\Comment::class, $comment])
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#edit-confirm-modal"
                                    onClick="handleUpdateCommentSelection({{ $comment->id }}, '{{ base64_encode($comment->text) }}')"><i
                                        class="far fa-trash-alt">
                                        <span></i> Edit this comment</span>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-confirm-modal-comment"
                                    onClick="handleDeleteCommentSelection({{ $comment->id }})"><i class="far fa-trash-alt">
                                        <span></i> Delete this comment</span>
                                </button>
                            @endcan
                        </div>
                    </li>
                    <br />
                @empty
                    <p>No comments are made for this artifact yet.</p>
                @endforelse
            </ul>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="delete-confirm-modal-comment" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- TODO: Title --}}
                        Are you sure you want to delete your comment?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger"
                            onclick="document.getElementById('delete-comment-form').submit();">
                            Yes, delete this comment
                        </button>

                        {{-- TODO: Route, directives --}}
                        <form id="delete-comment-form" action="{{ route('comments.destroy', '##REPLACETHIS##') }}"
                            method="POST" class="d-none">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Modal -->
        <div class="modal fade" id="edit-confirm-modal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit yor comment:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- TODO: Title --}}
                        <label for="text-comment" class="col-sm-2 col-form-label">Comment:*</label>

                        <textarea rows="5" class="form-control" id="text-comment" name="text-comment"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary"
                            onclick="document.getElementById('edit-comment-form').submit();">
                            Edit comment
                        </button>

                        {{-- TODO: Route, directives --}}
                        <form id="edit-comment-form" action="{{ route('comments.update', '##REPLACETHIS##') }}"
                            method="POST" class="d-none">
                            @method('PUT')
                            @csrf
                            <textarea id="text" name="text"></textarea>
                        </form>
                    </div>
                </div>
            </div>
            {{ $item->image }}
            {{ $image }}
        </div>
    </div>
@endsection
