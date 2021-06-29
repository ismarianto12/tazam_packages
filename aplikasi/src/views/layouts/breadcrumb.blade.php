{{-- @include('layouts.article', ['mainTitle' => "404, page not found", 'mainContent' => "sorry, but the requested page does not exist :("]) --}}
<div class="section-header">
    <h1>{{ $titledash }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="">{{ $titledash }}</a></div>
    </div>
</div>
