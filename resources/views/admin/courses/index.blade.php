@extends('layouts.adminlte')

@section('title', 'Cursos')
@section('page-title', 'Cursūs · Cursos')

@section('breadcrumb')
    <li class="breadcrumb-item active">Cursos</li>
@endsection

@push('styles')
<style>
    .courses-toolbar {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 1.2rem 1.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 12px rgba(26,22,18,.05);
    }
    .courses-toolbar .lead {
        flex: 1;
        min-width: 240px;
    }
    .courses-toolbar h6 {
        font-family: 'Bodoni Moda', serif;
        margin: 0 0 .2rem;
        font-size: 1.1rem;
        color: var(--ink);
    }
    .courses-toolbar p {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--stone);
        font-size: .95rem;
        margin: 0;
    }
    .btn-classic-new {
        font-family: 'Inter', sans-serif;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        padding: .75rem 1.4rem;
        background: var(--ink);
        color: var(--ivory);
        border: 1.5px solid var(--ink);
        border-radius: 999px;
        text-decoration: none;
        transition: all .2s;
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        box-shadow: 0 4px 14px rgba(26,22,18,.18);
    }
    .btn-classic-new:hover {
        background: var(--bronze-dark);
        border-color: var(--bronze-dark);
        color: var(--ivory);
        text-decoration: none;
        transform: translateY(-2px);
    }

    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
        gap: 1.25rem;
    }
    .course-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform .25s, box-shadow .25s, border-color .25s;
        animation: cardIn .55s cubic-bezier(.2,.8,.2,1) backwards;
        box-shadow: 0 2px 12px rgba(26,22,18,.05);
    }
    @keyframes cardIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .course-card:nth-child(1) { animation-delay: .05s; }
    .course-card:nth-child(2) { animation-delay: .10s; }
    .course-card:nth-child(3) { animation-delay: .15s; }
    .course-card:nth-child(4) { animation-delay: .20s; }
    .course-card:nth-child(5) { animation-delay: .25s; }
    .course-card:nth-child(6) { animation-delay: .30s; }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(26,22,18,.14);
        border-color: var(--bronze);
    }
    .course-card .cover {
        height: 180px;
        background: linear-gradient(135deg, var(--bronze) 0%, var(--ink) 100%);
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }
    .course-card .cover::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(26,22,18,0) 30%, rgba(26,22,18,.7) 100%);
    }
    .course-card .cover-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        font-family: 'Cinzel', serif;
        color: rgba(231,200,115,.6);
        font-size: 4rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }
    .course-card .glyph-bubble {
        position: absolute;
        top: 1rem; left: 1rem;
        z-index: 2;
        width: 52px; height: 52px;
        border-radius: 50%;
        background: rgba(250,246,236,.95);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Cinzel', serif;
        font-size: 1.4rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(26,22,18,.2);
    }
    .course-card .status-pills {
        position: absolute;
        top: 1rem; right: 1rem;
        z-index: 2;
        display: flex;
        gap: .35rem;
        flex-wrap: wrap;
    }
    .status-pill {
        font-family: 'Cormorant SC', serif;
        font-size: .6rem;
        letter-spacing: .22em;
        text-transform: uppercase;
        padding: .25rem .6rem;
        border-radius: 999px;
        background: rgba(250,246,236,.95);
        color: var(--ink);
        backdrop-filter: blur(4px);
    }
    .status-pill.on   { background: rgba(187,247,208,.9); color: #14532d; }
    .status-pill.off  { background: rgba(250,246,236,.95); color: var(--stone); }
    .status-pill.star { background: rgba(231,200,115,.95); color: var(--ink); }

    .course-card .body {
        padding: 1.25rem 1.4rem 1.4rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .course-card .body h5 {
        font-family: 'Bodoni Moda', serif;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0 0 .25rem;
        color: var(--ink);
        line-height: 1.2;
    }
    .course-card .body .slug {
        font-family: 'Cormorant SC', serif;
        font-size: .65rem;
        letter-spacing: .22em;
        text-transform: uppercase;
        color: var(--stone);
        margin-bottom: .8rem;
    }
    .course-card .body .subtitle {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--ink-soft);
        font-size: .95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .course-card .meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
        margin-bottom: 1rem;
    }
    .meta-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .25rem .55rem;
        background: var(--parchment);
        border-radius: 999px;
        font-size: .72rem;
        color: var(--bronze-dark);
        font-family: 'Inter', sans-serif;
    }
    .meta-chip i { font-size: .7rem; opacity: .8; }
    .meta-chip.muted { background: rgba(26,22,18,.04); color: var(--stone); }

    .course-card .actions {
        display: flex;
        gap: .4rem;
        padding-top: .8rem;
        border-top: 1px solid var(--line);
    }
    .course-card .actions a,
    .course-card .actions button {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
        padding: .5rem .65rem;
        font-family: 'Inter', sans-serif;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        border-radius: 8px;
        border: 1px solid var(--line);
        background: #fff;
        color: var(--ink-soft);
        text-decoration: none;
        transition: all .15s;
        cursor: pointer;
    }
    .course-card .actions .a-view:hover { background: #fff7e6; color: var(--bronze-dark); border-color: var(--bronze); }
    .course-card .actions .a-edit { background: var(--ink); color: var(--ivory); border-color: var(--ink); }
    .course-card .actions .a-edit:hover { background: var(--bronze-dark); border-color: var(--bronze-dark); color: var(--ivory); }
    .course-card .actions .a-del:hover { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }

    .empty-state {
        background: #fff;
        border: 2px dashed var(--line);
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
    }
    .empty-state .glyph {
        font-family: 'Cinzel', serif;
        font-size: 4rem;
        color: var(--bronze);
        opacity: .35;
        margin-bottom: 1rem;
    }
    .empty-state h5 {
        font-family: 'Bodoni Moda', serif;
        color: var(--ink);
        margin-bottom: .35rem;
    }
    .empty-state p {
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--stone);
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')

<div class="courses-toolbar">
    <div class="lead">
        <h6><i class="fas fa-book-open" style="color: var(--bronze);"></i> {{ $courses->count() }} curso{{ $courses->count() === 1 ? '' : 's' }} no banco</h6>
        <p>Cada curso aparece na página inicial e tem a sua página detalhada em <code style="background:var(--parchment); padding:.1rem .4rem; border-radius:4px; color:var(--bronze-dark);">/courses/&#123;slug&#125;</code>.</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="btn-classic-new">
        <i class="fas fa-plus"></i> Novo Curso
    </a>
</div>

@if($courses->isEmpty())
    <div class="empty-state">
        <div class="glyph">Γ</div>
        <h5>Ainda nenhum curso</h5>
        <p>Comece por adicionar o primeiro curso do instituto.</p>
        <a href="{{ route('admin.courses.create') }}" class="btn-classic-new">
            <i class="fas fa-plus"></i> Criar primeiro curso
        </a>
    </div>
@else
    <div class="course-grid">
        @foreach($courses as $c)
            <div class="course-card">
                {{-- Cover --}}
                <div class="cover" @if($c->imagemCapaUrl()) style="background-image: url('{{ $c->imagemCapaUrl() }}');" @endif>
                    @if(! $c->imagemCapaUrl())
                        <div class="cover-empty" style="color: {{ $c->cor_destaque ?: '#e7c873' }};">
                            {{ $c->glifo ?: 'Γ' }}
                        </div>
                    @endif
                    @if($c->glifo)
                        <span class="glyph-bubble" style="color: {{ $c->cor_destaque ?: '#a87841' }};">
                            {{ $c->glifo }}
                        </span>
                    @endif
                    <div class="status-pills">
                        @if($c->ativo)
                            <span class="status-pill on">✓ Activo</span>
                        @else
                            <span class="status-pill off">Oculto</span>
                        @endif
                        @if($c->destaque)
                            <span class="status-pill star">★ Destaque</span>
                        @endif
                    </div>
                </div>

                {{-- Body --}}
                <div class="body">
                    <h5>{{ $c->t('nome') ?: 'Curso sem nome' }}</h5>
                    <div class="slug">/{{ $c->slug }}</div>

                    @if($c->t('subtitulo'))
                        <div class="subtitle">{{ $c->t('subtitulo') }}</div>
                    @elseif($c->t('descricao_curta'))
                        <div class="subtitle">{{ Str::limit($c->t('descricao_curta'), 120) }}</div>
                    @else
                        <div class="subtitle" style="color:var(--stone); opacity:.6;">Sem subtítulo · adicione um para enriquecer a página.</div>
                    @endif

                    <div class="meta-row">
                        @if($c->t('formato'))
                            <span class="meta-chip"><i class="fas fa-laptop-house"></i> {{ $c->t('formato') }}</span>
                        @endif
                        @if($c->t('duracao_total'))
                            <span class="meta-chip"><i class="far fa-clock"></i> {{ $c->t('duracao_total') }}</span>
                        @endif
                        @if($c->t('preco'))
                            <span class="meta-chip"><i class="fas fa-tag"></i> {{ $c->t('preco') }}</span>
                        @endif
                        @if($c->vagas_por_turma)
                            <span class="meta-chip"><i class="fas fa-users"></i> {{ $c->vagas_por_turma }}/turma</span>
                        @endif
                        @if($c->professor_nome)
                            <span class="meta-chip muted"><i class="fas fa-user-graduate"></i> {{ Str::limit($c->professor_nome, 22) }}</span>
                        @endif
                    </div>

                    <div class="actions">
                        <a href="{{ route('courses.show', $c->slug) }}" target="_blank" class="a-view" title="Ver no site público">
                            <i class="fas fa-external-link-alt"></i> Ver
                        </a>
                        <a href="{{ route('admin.courses.edit', $c) }}" class="a-edit">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form method="post" action="{{ route('admin.courses.destroy', $c) }}" style="flex:1; margin:0;" onsubmit="return confirm('Remover o curso « {{ $c->t('nome') }} »? Esta acção não pode ser desfeita.');">
                            @csrf @method('DELETE')
                            <button type="submit" class="a-del">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
