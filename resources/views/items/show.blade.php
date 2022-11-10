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
                    <span>{{ $item->created_at }}</span>
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
                        <span class="badge" style="background-color: {{ $label->color }}">{{ $label->name }}</span> |
                    @empty
                        No label is added.
                    @endforelse

                </div>

                {{-- TODO: Link --}}
                <a href="{{ route('items.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>

            </div>

            <div class="col-12 col-md-4">
                <div class="float-lg-end">

                    {{-- TODO: Links, policy --}}
                    @can('update', $item)
                        <a role="button" class="btn btn-sm btn-primary" href="{{ route('items.edit', $item) }}"><i
                                class="far fa-edit"></i> Edit item</a>
                    @endcan

                    @can('delete', $item)
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
                        Are you sure you want to delete item <strong>{{ $item->title }}</strong>?
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
        </div>

        <img id="cover_preview_image" {{-- TODO: Cover --}}
            src="{{ asset($item->cover_image_path ? 'storage/' . $item->cover_image_path : 'images/default_item_cover.jpg') }}"
            width="350px" alt="Cover preview" class="my-3">

        <div class="mt-3">
            {{-- TODO: Item paragraphs --}}
            {!! nl2br(e($item->description)) !!}
        </div>
    </div>
@endsection