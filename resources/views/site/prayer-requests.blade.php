@extends('layouts.site')

@section('title', 'Prayer Requests')

@section('content')
@include('site.partials.page-hero', ['heading' => 'Prayer Requests', 'intro' => 'Share what is on your heart. Your request will be prayed over by our team.'])

<div class="page-section">
    <div class="container">
        <div class="card form-card">
            <livewire:prayer-request-form />
        </div>
    </div>
</div>
@endsection
