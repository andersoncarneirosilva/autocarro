<div id="cadastro-rapido" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-car me-2"></i>Novo veículo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info border-0 shadow-sm mb-4">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-file-pdf fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading h6 fw-bold">Dica para um cadastro rápido!</h5>
                            <p class="mb-0 small">Ao enviar o <strong>CRLV Digital (PDF)</strong> original, nosso sistema identifica os dados automaticamente. Isso poupa seu tempo e evita erros de digitação!</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('anuncios.cadastro-rapido') }}" method="POST" enctype="multipart/form-data" id="formDoc">
                    @csrf
                    <div class="row align-items-start">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-upload me-1"></i> CRLV Digital: <span class="text-danger">*</span>
                            </label>
                            <input class="form-control" type="file" name="arquivo_doc" id="arquivo_doc" accept=".pdf" required>
                            <div class="form-text">Selecione o arquivo PDF do documento do veículo.</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Fechar
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitButton">
                            <i class="fas fa-check me-1"></i> Cadastrar
                        </button>
                        <button class="btn btn-primary" id="loadingButton" type="button" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Processando Documento...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formDoc');
    const submitBtn = document.getElementById('submitButton');
    const loadingBtn = document.getElementById('loadingButton');

    if (form) {
        form.addEventListener('submit', function (e) {
            // Verifica se o formulário é válido (HTML5 validation)
            if (!form.checkValidity()) {
                return; // Se houver campos vazios, não faz nada e deixa o navegador avisar
            }

            // 1. Evita o duplo clique desativando o botão imediatamente
            submitBtn.disabled = true;

            // 2. Alterna a visibilidade dos botões
            submitBtn.style.display = 'none';
            loadingBtn.style.display = 'inline-block';

            // Opcional: Se quiser garantir que o form seja enviado mesmo com o botão disabled
            // o próprio evento de 'submit' já cuida disso no envio padrão.
        });
    }
});
</script>