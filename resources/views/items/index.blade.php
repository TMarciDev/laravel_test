@extends('layouts.app')
@section('title', 'Items')

@section('content')
<div class="container">
    <h1>Items </h1>
    <div>
        @forelse ($items as $item)
            <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch">
                <div class="card w-100">
                    <img
                        src="{{
                            asset(
                                $item->cover_image_path
                                ? 'storage/' . $item->cover_image_path
                                : 'images/default_item_cover.jpg'
                            )
                        }}"
                        class="card-img-top"
                        alt="Item cover"
                    >
                    <div class="card-body">
                        {{-- TODO: Title --}}
                        <h5 class="card-title mb-0">{{ $item->name }}</h5>
                        <br />
                        <p class="small mb-0">
                            <span>
                                <i class="far fa-calendar-alt"></i>
                                {{-- TODO: Date --}}
                                <span>Obtained: {{ str_replace('_', '.', explode(' ', $item->obtained)[0]) }}</span>
                            </span>
                        </p>

                        {{-- TODO: Short desc --}}
                        <p class="card-text mt-1">{{ Str::of($item->description)->limit(100, ' (...)') }}</p>

                        <button>View details (TODO)</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    No items found!
                </div>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {{ $items->links() }}
    </div>
</div>
@endsection
