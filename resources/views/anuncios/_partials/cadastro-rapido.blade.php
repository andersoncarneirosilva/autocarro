<div id="cadastro-rapido" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Novo veículo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('anuncios.cadastro-rapido') }}" method="POST" enctype="multipart/form-data" id="formDoc">
                    @csrf
                    <div class="row align-items-start">
                            <div class="mb-3">
                                <label>CRLV Digital: <span style="color: red;">*</span></label>
                                <div class="col-lg">
                                    <input class="form-control" type="file" name="arquivo_doc" id="arquivo_doc" accept=".pdf" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary" id="submitButton">Cadastrar</button>
                            <!-- Botão com Spinner (Oculto por padrão) -->
                            <button class="btn btn-primary" id="loadingButton" type="button" disabled style="display: none;">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Cadastrando...
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>