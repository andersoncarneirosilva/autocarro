<div class="modal fade" id="modalCadastroRapido" tabindex="-1" aria-labelledby="modalCadastroRapidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary p-3">
                <h5 class="modal-title text-white" id="modalCadastroRapidoLabel">
                    <i class="mdi mdi-lightning-bolt me-1"></i> Cadastro Rápido via CNH
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="ocr_upload_zone" class="text-center p-4 border border-2 border-dashed rounded mb-4">
                    <i class="mdi mdi-cloud-upload d-block font-size-24 text-primary"></i>
                    <p class="mt-2">Arraste ou selecione o PDF/Imagem da CNH</p>
                    <input type="file" id="input_arquivo_ocr" class="form-control d-none" onchange="processarDocumento()">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('input_arquivo_ocr').click()">
                        Selecionar Arquivo
                    </button>
                    
                    <div id="ocr_loading" class="mt-3" style="display:none;">
                        <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                        <span class="ms-2">O <b>alcecar</b> está processando o documento...</span>
                    </div>
                </div>

                <form id="form_confirmar_cadastro" action="{{ route('clientes.store') }}" method="POST" style="display:none;">
    @csrf
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label font-weight-bold">Nome Completo</label>
            <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                <input type="text" name="nome" id="res_nome" class="form-control" placeholder="Nome identificado pelo OCR" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label font-weight-bold">CPF</label>
            <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-card-account-details"></i></span>
                <input type="text" name="cpf" id="res_cpf" class="form-control" placeholder="000.000.000-00" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label font-weight-bold">RG / Identidade</label>
            <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-identifier"></i></span>
                <input type="text" name="rg" id="res_rg" class="form-control" placeholder="Número do documento" required>
            </div>
        </div>
    </div>

    <div class="modal-footer px-0 pb-0">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">
            <i class="mdi mdi-check-all me-1"></i> Confirmar e Salvar no Alcecar
        </button>
    </div>
</form>
            </div>
        </div>
    </div>
</div>

<script>
    function processarDocumento() {
    const input = document.getElementById('input_arquivo_ocr');
    const loading = document.getElementById('ocr_loading');
    const form = document.getElementById('form_confirmar_cadastro');
    const uploadZone = document.getElementById('ocr_upload_zone');

    if (!input.files.length) return;

    let formData = new FormData();
    formData.append('arquivo', input.files[0]);

    // UI Feedback
    loading.style.display = 'block';
    
    fetch('{{ route("ocr.processar") }}', { // Certifique-se de que esta rota existe
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        loading.style.display = 'none';
        
        if (data.status === 'sucesso') {
            // Preenche os campos
            document.getElementById('res_nome').value = data.dados_extraidos.nome;
    document.getElementById('res_cpf').value  = data.dados_extraidos.cpf;
    document.getElementById('res_rg').value   = data.dados_extraidos.rg;

            // Mostra o formulário e "minimiza" a zona de upload
            form.style.display = 'block';
            uploadZone.classList.remove('p-4');
            uploadZone.classList.add('p-2');
        } else {
            alert('Erro ao ler documento: ' + (data.erro || 'Verifique o arquivo.'));
        }
    })
    .catch(error => {
        loading.style.display = 'none';
        console.error('Erro:', error);
        alert('Falha na comunicação com o servidor do Alcecar.');
    });
}
</script>