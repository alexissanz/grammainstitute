@extends('layouts.adminlte')

@section('title', 'Parceiros · Partners')
@section('page-title', 'Parceiros · Partners')

@section('breadcrumb')
    <li class="breadcrumb-item active">Parceiros</li>
@endsection

@push('styles')
<style>
    .partner-row {
        display:flex; align-items:center; gap:1rem;
        padding:.85rem 1rem; border:1px solid #e5e7eb; border-radius:8px;
        background:#fff; margin-bottom:.6rem;
    }
    .partner-row .thumb {
        width:48px; height:48px; border-radius:50%; overflow:hidden;
        background:#f3f4f6; display:flex; align-items:center; justify-content:center;
        color:#a87841; font-weight:600; flex-shrink:0;
    }
    .partner-row .thumb img { width:100%; height:100%; object-fit:cover; }
    .partner-row .main { flex:1; min-width:0; }
    .partner-row .actions { display:flex; gap:.4rem; flex-shrink:0; }
    .partner-form { background:#fff; border:1px solid #e5e7eb; border-radius:10px; padding:1.5rem; margin-bottom:1.5rem; }
    .partner-form h5 { font-family:'Bodoni Moda',serif; font-size:1.1rem; margin-bottom:1rem; }
    .partner-form .form-control { border-radius:6px; }
    .hint { font-size:.78rem; color:#6b7280; margin-top:.25rem; }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success" style="border-radius:8px;"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-lg-5">
        <div class="partner-form">
            <h5><i class="fas fa-plus me-2" style="color:#a87841;"></i>Adicionar parceiro</h5>
            <form method="post" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Nome do parceiro</label>
                    <input type="text" name="nome" class="form-control" required
                           placeholder="Ex.: University of São Paulo">
                </div>
                <div class="form-group">
                    <label>Link (opcional)</label>
                    <input type="url" name="link" class="form-control" placeholder="https://www.usp.br">
                    <div class="hint">Se preenchido, o card do parceiro fica clicável e abre o link em nova aba.</div>
                </div>
                <div class="form-group">
                    <label>Foto / logo</label>
                    <input type="file" name="foto" class="form-control-file" accept="image/*">
                    <div class="hint">JPG, PNG ou WebP, até 4 MB. Se vazio, mostra a primeira letra do nome.</div>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="ativo" id="ativo_new" class="form-check-input" value="1" checked>
                    <label class="form-check-label" for="ativo_new">Visível no site</label>
                </div>
                <button class="btn btn-primary" style="background:#1a1612;border-color:#1a1612;">
                    <i class="fas fa-save me-1"></i>Adicionar
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-7">
        <h5 style="font-family:'Bodoni Moda',serif; margin-bottom:1rem;">
            Parceiros actuais
            <small class="text-muted" style="font-size:.75rem;">— arraste o ⠿ para reordenar</small>
        </h5>

        @if($partners->isEmpty())
            <div class="alert alert-info" style="background:#eef3ff; border:1px solid #c7d7f5; color:#1a3a5c; border-radius:10px;">
                <i class="fas fa-info-circle me-1"></i>
                Ainda não há parceiros. Adicione o primeiro no formulário ao lado.
            </div>
        @else
        <div id="partner-list">
            @foreach($partners as $partner)
                <div class="partner-row" data-id="{{ $partner->id }}">
                    <span style="cursor:grab; color:#d1d5db;" class="drag-handle"><i class="fas fa-grip-vertical"></i></span>
                    <div class="thumb">
                        @if($partner->foto)
                            <img src="{{ $partner->fotoUrl() }}" alt="">
                        @else
                            {{ mb_strtoupper(mb_substr($partner->nome, 0, 1)) }}
                        @endif
                    </div>
                    <div class="main">
                        <div style="font-weight:600;">{{ $partner->nome }}</div>
                        @if($partner->link)
                            <small class="text-muted"><i class="fas fa-link me-1"></i>{{ $partner->link }}</small>
                        @endif
                        @if(!$partner->ativo)
                            <span style="font-size:.7rem; padding:.1rem .4rem; background:#f3f4f6; color:#6b7280; border-radius:4px; margin-left:.5rem;">INATIVO</span>
                        @endif
                    </div>
                    <div class="actions">
                        <button class="btn btn-sm btn-outline-primary" onclick='openEdit(@json($partner))'>
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="post" action="{{ route('admin.partners.destroy', $partner) }}" class="d-inline"
                              onsubmit="return confirm('Remover este parceiro?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Edit modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:12px;">
            <form method="post" id="editForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 style="font-family:'Bodoni Moda',serif;"><i class="fas fa-edit me-2"></i>Editar parceiro</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" id="edit_nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Link (opcional)</label>
                        <input type="url" name="link" id="edit_link" class="form-control" placeholder="https://...">
                    </div>
                    <div class="form-group">
                        <label>Substituir foto (opcional)</label>
                        <input type="file" name="foto" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="ativo" id="edit_ativo" class="form-check-input" value="1">
                        <label for="edit_ativo" class="form-check-label">Visível no site</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" style="background:#1a1612;border-color:#1a1612;">
                        <i class="fas fa-save me-1"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function openEdit(p) {
    document.getElementById('editForm').action = '{{ url("admin/partners") }}/' + p.id;
    document.getElementById('edit_nome').value  = p.nome || '';
    document.getElementById('edit_link').value  = p.link || '';
    document.getElementById('edit_ativo').checked = !!p.ativo;
    $('#editModal').modal('show');
}

const list = document.getElementById('partner-list');
if (list) {
    Sortable.create(list, {
        handle: '.drag-handle', animation: 150,
        onEnd: function() {
            const ids = Array.from(list.querySelectorAll('[data-id]')).map(el => el.getAttribute('data-id'));
            fetch('{{ route("admin.partners.reorder") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ order: ids })
            });
        }
    });
}
</script>
@endpush
