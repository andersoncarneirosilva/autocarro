<div class="row">
        <div class="col-md-12 px-md-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="header-title text-primary mb-0 text-uppercase" style="letter-spacing: 1px;">
                    Descrição
                </h4>
                <button type="button" class="btn btn-outline-primary btn-sm " data-bs-toggle="modal" data-bs-target="#modalDescricao">
                    <i class="mdi mdi-pencil me-1"></i> Atualizar descrição
                </button>
            </div>
            
            <div class="border p-4 rounded bg-white shadow-none" style="min-height: 150px;">
                <div class="text-muted" style="white-space: pre-wrap; line-height: 1.6; font-size: 14px;">{{ trim($veiculo->observacoes) ?: 'Nenhuma observação cadastrada.' }}</div>
            </div>
        </div>
    </div>