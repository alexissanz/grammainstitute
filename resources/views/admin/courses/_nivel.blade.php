<div class="nivel-card">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <strong style="color:#1a3a5c; font-size:.9rem;">Nível #{{ is_numeric($idx) ? $idx + 1 : '?' }}</strong>
        <button type="button" class="btn btn-sm btn-link text-danger remove-nivel"><i class="fas fa-trash"></i></button>
    </div>

    <div class="row g-2">
        <div class="col-md-12">
            <label class="form-label small">Nome do nível (multilíngue)</label>
            <ul class="nav lang-tabs mb-2" data-field="nivel_nome_{{ $idx }}">
                @foreach($locales as $i => $loc)
                    <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                @endforeach
            </ul>
            @foreach($locales as $i => $loc)
                <div class="lang-pane" data-field="nivel_nome_{{ $idx }}" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                    <input name="niveis[{{ $idx }}][nome][{{ $loc }}]" type="text" class="form-control"
                           value="{{ is_array($nivel) ? ($nivel['nome'][$loc] ?? '') : '' }}"
                           placeholder="Iniciante (Α) / Beginner / ...">
                </div>
            @endforeach
        </div>

        <div class="col-md-12">
            <label class="form-label small mt-2">Descrição (multilíngue)</label>
            <ul class="nav lang-tabs mb-2" data-field="nivel_desc_{{ $idx }}">
                @foreach($locales as $i => $loc)
                    <li class="nav-item"><a href="#" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $loc }}">{{ strtoupper(str_replace('_','-',$loc)) }}</a></li>
                @endforeach
            </ul>
            @foreach($locales as $i => $loc)
                <div class="lang-pane" data-field="nivel_desc_{{ $idx }}" data-lang="{{ $loc }}" style="{{ $i === 0 ? '' : 'display:none;' }}">
                    <textarea name="niveis[{{ $idx }}][descricao][{{ $loc }}]" class="form-control" rows="2">{{ is_array($nivel) ? ($nivel['descricao'][$loc] ?? '') : '' }}</textarea>
                </div>
            @endforeach
        </div>

        <div class="col-md-4">
            <label class="form-label small mt-2">Duração</label>
            <input name="niveis[{{ $idx }}][duracao]" type="text" class="form-control"
                   value="{{ is_array($nivel) ? ($nivel['duracao'] ?? '') : '' }}" placeholder="60h">
        </div>
    </div>
</div>
