<div class="row">
                            <div class="col-md-4 px-md-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="text-primary"><i class="mdi mdi-plus-box-outline me-1"></i> Adicionais</h5>
                                    @php
                                        $listaAdicionais = is_array($veiculo->adicionais) ? $veiculo->adicionais : json_decode($veiculo->adicionais, true);
                                    @endphp

                                    @if(is_array($listaAdicionais) && count($listaAdicionais) > 0)
                                        {{-- Caso já existam itens cadastrados --}}
                                        <button class="btn btn-xs btn-outline-primary  px-3" data-bs-toggle="modal" data-bs-target="#modalAdicionais">
                                            <i class="mdi mdi-pencil me-1"></i> Atualizar adicionais
                                        </button>
                                    @else
                                        {{-- Caso esteja vazio [], null ou string vazia --}}
                                        <button class="btn btn-xs btn-primary  px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionais">
                                            <i class="mdi mdi-plus me-1"></i> Adicionar adicionais
                                        </button>
                                    @endif
                                </div>
                                <div class="d-flex flex-wrap gap-2 p-2 border rounded min-height-100 bg-light-lighten">
                                    @php $adicionais = json_decode($veiculo->adicionais) ?? []; @endphp

                                    @forelse($adicionais as $ad)
                                        <span class="badge badge-outline-secondary px-2 py-1 fw-normal" style="font-size: 13px;">
                                            {{ $ad }}
                                        </span>
                                    @empty
                                        <span class="text-muted small p-1">Nenhum adicional selecionado.</span>
                                    @endforelse
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="text-primary mb-0"><i class="mdi mdi-check-all me-1"></i> Opcionais</h5>
                                    
                                @php
                                    $listaOpcionais = is_array($veiculo->opcionais) ? $veiculo->opcionais : json_decode($veiculo->opcionais, true);
                                @endphp

                                    @if(is_array($listaOpcionais) && count($listaOpcionais) > 0)
                                        {{-- Se o array tem itens, o botão é de ATUALIZAR --}}
                                        <button class="btn btn-xs btn-outline-primary  px-3" data-bs-toggle="modal" data-bs-target="#modalOpcionais">
                                            <i class="mdi mdi-pencil me-1"></i> Atualizar opcionais
                                        </button>
                                    @else
                                        {{-- Se for vazio [], null ou string vazia, o botão é de ADICIONAR --}}
                                        <button class="btn btn-xs btn-primary  px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalOpcionais">
                                            <i class="mdi mdi-plus me-1"></i> Adicionar opcionais
                                        </button>
                                    @endif

                                </div>
                                <div class="d-flex flex-wrap gap-2 p-2 border rounded min-height-100 bg-light-lighten">
                                    @forelse(json_decode($veiculo->opcionais) ?? [] as $opt)
                                        <span class="badge badge-outline-secondary px-2 py-1 fw-normal" style="font-size: 13px;">
                                            {{ $opt }}
                                        </span>
                                    @empty
                                        <span class="text-muted small p-1">Nenhum opcional selecionado.</span>
                                    @endforelse
                                </div>
                            </div>

<div class="col-md-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="text-primary mb-0"><i class="mdi mdi-auto-fix me-1"></i> Modificações</h5>
        @php
            $listaModificacoes = is_array($veiculo->modificacoes) ? $veiculo->modificacoes : json_decode($veiculo->modificacoes, true);
        @endphp

        @if(is_array($listaModificacoes) && count($listaModificacoes) > 0)
            {{-- Se já existem modificações registradas --}}
            <button class="btn btn-xs btn-outline-primary  px-3" data-bs-toggle="modal" data-bs-target="#modalModificacoes">
                <i class="mdi mdi-pencil me-1"></i> Atualizar modificações
            </button>
        @else
            {{-- Se estiver vazio [], null ou string vazia --}}
            <button class="btn btn-xs btn-primary  px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalModificacoes">
                <i class="mdi mdi-plus me-1"></i> Adicionar modificações
            </button>
        @endif
    </div>
    <div class="d-flex flex-wrap gap-2 p-2 border rounded min-height-100 bg-light-lighten">
        @forelse(json_decode($veiculo->modificacoes) ?? [] as $mod)
            <span class="badge badge-outline-secondary px-2 py-1 fw-normal" style="font-size: 13px;">
                {{ $mod }}
            </span>
        @empty
            <span class="text-muted small p-1">Nenhuma modificação.</span>
        @endforelse
    </div>
</div>
                        </div>