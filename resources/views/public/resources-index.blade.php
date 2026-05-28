@extends('layouts.public')

@section('meta-title', __('site.resources_page_title') . ' — ' . config('app.name'))

@push('styles')
    @include('public._resources_styles')
@endpush

@section('content')

<section class="resources-hero">
    <div class="container">
        <div class="eyebrow">{{ __('site.nav_resources') }}</div>
        <h1>{{ __('site.resources_page_title') }}</h1>
        <p class="lede">{{ __('site.resources_page_lede') }}</p>
    </div>
</section>

<section class="resources-body">
    <div class="container">
        @if($categories->isEmpty())
            <div class="resources-empty">
                <i class="fas fa-book-open"></i>
                Categories will appear here.
            </div>
        @else
            <div class="resource-cat-grid">
                @foreach($categories as $cat)
                    <a href="{{ route('resources.show', $cat) }}" class="resource-cat-card">
                        <span class="count">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="ico"><i class="fas {{ $cat->icon ?: 'fa-bookmark' }}"></i></div>
                        <h3>{{ $cat->t('title') }}</h3>
                        @if($cat->t('description'))
                            <p class="desc">{{ $cat->t('description') }}</p>
                        @endif
                        <span class="more">{{ __('site.about_read_more') }} <i class="fas fa-arrow-right"></i></span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
