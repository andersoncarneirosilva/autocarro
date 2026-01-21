<style>
    /* Área cinza de fundo do editor */
    #modalEditProc .ck-editor__main {
        background-color: #f0f2f5 !important;
        padding: 20px !important;
        max-height: 650px;
        overflow-y: auto;
    }

    /* Simulação da Folha A4 branca */
    #modalEditProc .ck-editor__editable_inline {
        min-height: 800px !important; /* Altura de uma folha */
        width: 100% !important;
        max-width: 800px !important;
        margin: 0 auto !important;
        padding: 2cm !important; /* Margem interna da folha */
        background-color: white !important;
        box-shadow: 0 0 15px rgba(0,0,0,0.2) !important;
        border: none !important;
    }

    /* Ajuste da Toolbar para ficar fixa no topo */
    #modalEditProc .ck-editor__top {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    /* Garante que o menu suspenso do editor (fontes/alinhamento) não fique atrás do modal */
    .ck-rounded-corners .ck.ck-balloon-panel, 
    .ck.ck-balloon-panel.ck-balloon-panel_with-arrow {
        z-index: 9999 !important;
    }
</style>

<div class="modal fade" id="modalEditProc" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="mdi mdi-file-document-edit-outline me-2"></i>Designer de Procuração - Alcecar</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('configuracoes.procuracao.save') }}" id="outorgadosForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
    <div class="mb-3">
        <label class="form-label fw-bold text-dark">Conteúdo da Procuração:</label>
        <textarea name="conteudo" id="edit_conteudo"></textarea>
    </div>
</div>



                        <div class="col-md-4">
                            <div class="card bg-light border-0 shadow-none">
                                <div class="card-body">
                                    <h5 class="header-title mb-3">Configurações</h5>
                                <div class="mb-3">
    <label class="form-label fw-bold">Outorgados Vinculados: <span class="text-danger">*</span></label>
    <select class="select2 form-control select2-multiple" 
            data-toggle="select2" 
            id="edit_outorgados" 
            multiple="multiple" 
            name="outorgados[]" 
            required>
        @foreach ($outorgados as $out)
            <option value="{{ $out->id }}">{{ $out->nome_outorgado }}</option>
        @endforeach
    </select>
    <small class="text-muted">Selecione quem aparecerá na procuração.</small>
</div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Cidade Padrão:</label>
                                        <input class="form-control" id="edit_cidade" name="cidade" required placeholder="Ex: Esteio/RS"/>
                                    </div>

                                    <hr>
                                    
                                    <h5 class="header-title mb-2 text-primary">Tags para o Documento</h5>
                                    <p class="text-muted small mb-3">Clique na tag para copiar:</p>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-primary small uppercase">Dados do Cliente (Outorgante)</label>
                                        <div class="d-flex flex-wrap gap-1">
                                            <code class="cursor-pointer p-1 border" onclick="copyTag('{NOME_CLIENTE}')">{NOME_CLIENTE}</code>
                                            <code class="cursor-pointer p-1 border" onclick="copyTag('{CPF_CLIENTE}')">{CPF_CLIENTE}</code>
                                            <code class="cursor-pointer p-1 border" onclick="copyTag('{ENDERECO_CLIENTE}')">{ENDERECO_CLIENTE}</code>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-danger small uppercase">Dados dos Outorgados (Repetidor)</label>
                                        <div class="d-flex flex-wrap gap-1">
                                            <code class="cursor-pointer p-1 border bg-white" onclick="copyTag('{INICIO_OUTORGADOS}')">{INICIO_OUTORGADOS}</code>
                                            <code class="cursor-pointer p-1 border bg-white" onclick="copyTag('{NOME_OUTORGADO}')">{NOME_OUTORGADO}</code>
                                            <code class="cursor-pointer p-1 border bg-white" onclick="copyTag('{CPF_OUTORGADO}')">{CPF_OUTORGADO}</code>
                                            <code class="cursor-pointer p-1 border bg-white" onclick="copyTag('{ENDERECO_OUTORGADO}')">{ENDERECO_OUTORGADO}</code>
                                            <code class="cursor-pointer p-1 border bg-white" onclick="copyTag('{FIM_OUTORGADOS}')">{FIM_OUTORGADOS}</code>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-success small uppercase">Dados do Veículo</label>
                                        <div class="d-flex flex-wrap gap-1">
                                            <code class="cursor-pointer p-1 border" onclick="copyTag('{PLACA}')">{PLACA}</code>
                                            <code class="cursor-pointer p-1 border" onclick="copyTag('{CHASSI}')">{CHASSI}</code>
                                            <code class="cursor-pointer p-1 border" onclick="copyTag('{RENAVAM}')">{RENAVAM}</code>
                                            <code class="cursor-pointer p-1 border" onclick="copyTag('{MARCA_MODELO}')">{MARCA_MODELO}</code>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning border-0 mb-0">
                                        <p class="small mb-0">
                                            <i class="mdi mdi-information-outline me-1"></i>
                                            <strong>Dica:</strong> Use as tags de <strong>INÍCIO</strong> e <strong>FIM</strong> para envolver o bloco que deve se repetir caso haja mais de um outorgado.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary shadow-sm"><i class="mdi mdi-check-all me-1"></i>Salvar Modelo de Procuração</button>
                </div>
            </form>
        </div>
    </div>
</div>

