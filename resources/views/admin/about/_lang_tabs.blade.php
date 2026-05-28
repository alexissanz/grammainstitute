{{-- Language tabs partial. Expects $name (unique prefix per section) and $languages. --}}
<ul class="nav nav-tabs lang-tabs mb-3">
    @foreach($languages as $code => $lang)
        <li class="nav-item">
            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $name }}-{{ $code }}">
                {!! $lang['flag'] !!} {{ strtoupper(str_replace('_', '-', $code)) }}
            </a>
        </li>
    @endforeach
</ul>
