<div id="modalUploadCrlv" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalUploadCrlvLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="modalUploadCrlvLabel">
                    <i class="mdi mdi-file-upload text-primary me-1"></i> 
                    Upload de Documento (CRLV)
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('veiculos.upload-crlv', $veiculo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-3">
                        
                        <p class="text-muted">Selecione o arquivo digital do veículo <strong>{{ $veiculo->placa }}</strong>.</p>
                    </div>

                    <div class="mb-3">
    <label for="arquivo_doc" class="form-label">Arquivo (Somente PDF)</label>
    {{-- O accept=".pdf" força o navegador a mostrar apenas arquivos PDF --}}
    <input type="file" name="arquivo_doc" id="arquivo_doc" class="form-control" accept=".pdf" required>
    <div class="form-text">
        <i class="mdi mdi-information-outline"></i> Formato aceito: <strong>PDF</strong> (Máx: 5MB)
    </div>
</div>

                    @if($veiculo->arquivo_doc)
                        <div class="alert alert-warning border-0 mb-0" role="alert">
                            <i class="mdi mdi-alert-circle-outline me-1"></i>
                            <strong>Atenção:</strong> Já existe um arquivo salvo. O novo upload irá substituir o anterior.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-cloud-upload me-1"></i> Iniciar Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>