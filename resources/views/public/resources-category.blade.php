@extends('layouts.public')

@section('meta-title', $category->t('title') . ' — ' . config('app.name'))

@push('styles')
    @include('public._resources_styles')
@endpush

@section('content')

<section class="resources-hero">
    <div class="container">
        <div class="eyebrow">{{ __('site.nav_resources') }}</div>
        <h1>{{ $category->t('title') }}</h1>
        @if($category->t('description'))
            <p class="lede">{{ $category->t('description') }}</p>
        @endif
    </div>
</section>

<section class="resources-body">
    <div class="container">
        <div class="row g-5">

            <aside class="col-lg-3">
                <nav class="resource-side-nav">
                    @foreach($categories as $cat)
                        <a href="{{ route('resources.show', $cat) }}"
                           class="{{ $cat->id === $category->id ? 'is-current' : '' }}">
                            {{ $cat->t('title') }}
                        </a>
                    @endforeach
                </nav>
                <a href="{{ route('resources.index') }}" style="display:inline-flex; align-items:center; gap:.5rem; font-family:'Cormorant SC',serif; font-size:.7rem; letter-spacing:.25em; text-transform:uppercase; color:var(--bronze-dark); text-decoration:none; padding:.85rem 1.2rem; margin-top:1rem;">
                    <i class="fas fa-arrow-left"></i>{{ __('site.resources_back') }}
                </a>
            </aside>

            <div class="col-lg-9 resource-section">
                @if($links->isEmpty())
                    <div class="resources-empty">
                        <i class="fas fa-bookmark"></i> Links will be added soon.
                    </div>
                @else
                    <div class="resource-link-list">
                        @foreach($links as $link)
                            <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="resource-link">
                                <div class="body">
                                    <div class="title">{{ $link->t('title') ?: $link->url }}</div>
                                    @if($link->t('description'))
                                        <p class="desc">{{ $link->t('description') }}</p>
                                    @endif
                                </div>
                                <span class="open">{{ __('site.resources_open_link') }} <i class="fas fa-external-link-alt"></i></span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
