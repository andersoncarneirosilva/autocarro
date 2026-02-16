<div class="modal fade" id="modalEditarServico" tabindex="-1" aria-labelledby="modalEditarServicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-dark fw-bold" id="modalEditarServicoLabel">
                    <i class="mdi mdi-pencil-outline me-1"></i> Editar Serviço
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="edit_servico_form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center border-end">
                            <label class="form-label fw-semibold d-block mb-3">Imagem do Serviço</label>
                            
                            <div class="position-relative d-inline-block">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center overflow-hidden border" style="width: 150px; height: 150px;">
                                    <img id="edit_preview_foto_servico" src="{{ asset('assets/images/placeholder-service.png') }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                    
                                    <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 35px; height: 35px; border: 2px solid white;">
                                        <i class="mdi mdi-camera text-white"></i>
                                    </div>
                                </div>
                                <input type="file" name="image" id="edit_foto_input" class="position-absolute top-0 start-0 opacity-0 w-100 h-100" style="cursor: pointer;" accept="image/*">
                            </div>
                            
                            <p class="text-muted mt-3 small">Clique na imagem para<br>alterar a foto atual.</p>
                        </div>

                        <div class="col-md-8 ps-md-4">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Nome do Serviço <span class="text-danger">*</span></label>
                                    <input type="text" name="nome" id="edit_servico_nome" class="form-control" placeholder="Ex: Lavagem Simples..." required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Preço (R$) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold">R$</span>
                                        <input type="text" name="preco" id="edit_servico_preco" class="form-control money" placeholder="0,00" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Duração <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="duracao" id="edit_servico_duracao" class="form-control" required>
                                        <span class="input-group-text bg-light">min</span>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <label class="form-label fw-semibold">Descrição (Opcional)</label>
                                    <textarea name="descricao" id="edit_servico_descricao" class="form-control" rows="3" placeholder="Descreva o serviço..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                        <i class="mdi mdi-check-circle-outline me-1"></i> Atualizar Serviço
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Máscara para Moeda
    $('.money').mask('#.##0,00', {reverse: true});

    // Preview da imagem para o modal de CADASTRO (se existir)
    $('#foto-input').change(function() {
        renderPreview(this, '#preview-foto-servico');
    });

    // Preview da imagem para o modal de EDIÇÃO (corrigido para o ID certo)
    $('#edit_foto_input').change(function() {
        renderPreview(this, '#edit_preview_foto_servico');
    });

    // Função genérica para renderizar o preview
    function renderPreview(input, targetSelector) {
        const file = input.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $(targetSelector).attr('src', event.target.result);
                // Se você tiver um ícone de placeholder, pode escondê-lo aqui
                $('#icon-placeholder').hide(); 
            }
            reader.readAsDataURL(file);
        }
    }
});
</script>