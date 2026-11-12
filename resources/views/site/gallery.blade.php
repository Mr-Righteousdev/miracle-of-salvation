@extends('layouts.site')

@section('title', 'Church Gallery')

@section('content')
@include('site.partials.page-hero', ['heading' => 'Church Gallery', 'intro' => 'Moments of worship, fellowship and ministry.'])

<div class="page-section">
    <div class="container">
        @if ($images->isNotEmpty())
            <div class="media-grid gallery-grid">
                @foreach ($images as $image)
                    <figure class="card media-card">
                        <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $image->caption ?? 'Church gallery photo' }}" loading="lazy">
                        @if ($image->caption)
                            <figcaption class="media-card-body"><p>{{ $image->caption }}</p></figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>

            {{ $images->links('site.partials.pagination') }}
        @else
            <p class="empty-state">No photos yet.</p>
        @endif
    </div>
</div>
@endsection
