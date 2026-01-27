<div class="row">
        <div class="col-md-12 px-md-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-primary mb-0"><i class="mdi mdi-file me-1"></i> Documentos</h5>
                
                <button type="button" class="btn btn-outline-primary btn-xs " data-bs-toggle="modal" data-bs-target="#modalGerarDocs">
                    <i class="mdi mdi-pencil"></i> Gerar documentos
                </button>
            </div>
            
            <ul class="list-group list-group-flush border rounded bg-light-lighten">


    <li class="list-group-item bg-transparent py-3">
    <div class="d-flex align-items-center mb-2">
        <i class="mdi mdi-file-document-outline me-2 font-18 text-muted"></i>
        <div>
            <span class="fw-medium d-block">CRLV</span>
            <small class="text-muted">Certificado de Registro e Licenciamento de Veículo</small>
        </div>
    </div>

    @if($veiculo->arquivo_doc)
        <div class="shadow-none border rounded p-2 bg-white">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light bg-soft-danger text-danger rounded">
                            <i class="mdi mdi-file-pdf-box font-24"></i>
                        </span>
                    </div>
                </div>
                <div class="col ps-0 text-start">
                    {{-- O link usa o campo direto do veículo --}}
                    <a href="{{ asset('storage/' . $veiculo->arquivo_doc) }}" target="_blank" class="text-muted fw-bold d-block text-truncate font-13" title="{{ basename($veiculo->arquivo_doc) }}">
                        {{ basename($veiculo->arquivo_doc) }}
                    </a>
                    <p class="mb-0 font-12 text-muted">
                        {{-- Caso você tenha o tamanho salvo no banco, senão pode exibir 'Documento PDF' --}}
                        {{ isset($veiculo->size_doc) ? number_format($veiculo->size_doc / 1024, 2, ',', '.') . ' KB' : 'Documento Digital' }}
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ $veiculo->arquivo_doc }}" download class="btn btn-link btn-sm text-muted">
                        <i class="mdi mdi-download font-18"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center bg-light-lighten border border-dashed rounded p-2">
            <span class="text-muted font-12 italic">Documento não anexado</span>
            <span class="badge bg-soft-warning text-warning border border-warning">Pendente</span>
        </div>
    @endif
</li>

    <li class="list-group-item bg-transparent py-3">
    <div class="d-flex align-items-center mb-2">
        <i class="mdi mdi-file-certificate-outline me-2 font-18 text-muted"></i>
        <div>
            <span class="fw-medium d-block">Procuração</span>
            <small class="text-muted">Documento de representação jurídica</small>
        </div>
    </div>

    @if($veiculo->documentos && $veiculo->documentos->arquivo_proc)
        <div class="shadow-none border rounded p-2 bg-white">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light bg-soft-danger text-danger rounded">
                            <i class="mdi mdi-file-pdf-box font-24"></i>
                        </span>
                    </div>
                </div>
                <div class="col ps-0 text-start">
                    <a href="{{ asset('storage/' . $veiculo->documentos->arquivo_proc) }}" target="_blank" class="text-muted fw-bold d-block text-truncate font-13" title="{{ basename($veiculo->documentos->arquivo_proc) }}">
                        {{ basename($veiculo->documentos->arquivo_proc) }}
                    </a>
                    <p class="mb-0 font-12 text-muted">
                        {{ number_format($veiculo->documentos->size_proc / 1024, 2, ',', '.') }} KB
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ asset('storage/' . $veiculo->documentos->arquivo_proc) }}" download class="btn btn-link btn-sm text-muted">
                        <i class="mdi mdi-download font-18"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center bg-light-lighten border border-dashed rounded p-2">
            <span class="text-muted font-12 italic">Arquivo não gerado</span>
            <span class="badge bg-soft-secondary text-secondary border border-secondary">N/A</span>
        </div>
    @endif
</li>

    <li class="list-group-item bg-transparent py-3">
    <div class="d-flex align-items-center mb-2">
        <i class="mdi mdi-file-send-outline me-2 font-18 text-muted"></i>
        <div>
            <span class="fw-medium d-block">Solicitação ATPVe</span>
            <small class="text-muted">Intenção de venda e transferência</small>
        </div>
    </div>

    @if($veiculo->documentos && $veiculo->documentos->arquivo_atpve)
        <div class="shadow-none border rounded p-2 bg-white">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light bg-soft-danger text-danger rounded">
                            <i class="mdi mdi-file-pdf-box font-24"></i>
                        </span>
                    </div>
                </div>
                <div class="col ps-0 text-start">
                    <a href="{{ asset('storage/' . $veiculo->documentos->arquivo_atpve) }}" target="_blank" class="text-muted fw-bold d-block text-truncate font-13" title="{{ basename($veiculo->documentos->arquivo_atpve) }}">
                        {{ basename($veiculo->documentos->arquivo_atpve) }}
                    </a>
                    <p class="mb-0 font-12 text-muted">
                        {{ number_format($veiculo->documentos->size_atpve / 1024, 2, ',', '.') }} KB
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ asset('storage/' . $veiculo->documentos->arquivo_atpve) }}" download class="btn btn-link btn-sm text-muted">
                        <i class="mdi mdi-download font-18"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center bg-light-lighten border border-dashed rounded p-2">
            <span class="text-muted font-12 italic">Documento não gerado</span>
            <span class="badge bg-soft-secondary text-secondary border border-secondary">N/A</span>
        </div>
    @endif
</li>
</ul>
        </div>
    </div>