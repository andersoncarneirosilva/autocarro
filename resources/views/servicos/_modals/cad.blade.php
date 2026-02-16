<div class="modal fade" id="modalCadastrarServico" tabindex="-1" aria-labelledby="modalCadastrarServicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-dark fw-bold" id="modalCadastrarServicoLabel">
                    <i class="mdi mdi-plus-circle-outline me-1"></i> Novo Serviço
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('servicos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center border-end">
                            <label class="form-label fw-semibold d-block mb-3">Imagem do Serviço</label>
                            
                            <div class="position-relative d-inline-block">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center overflow-hidden border" style="width: 150px; height: 150px;">
                                    <img id="preview-foto-servico" src="{{ asset('assets/images/placeholder-service.png') }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                    <div id="icon-placeholder" class="position-absolute">
                                        <i class="mdi mdi-camera-plus text-muted shadow-sm" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <input type="file" name="image" id="foto-input" class="position-absolute top-0 start-0 opacity-0 w-100 h-100" style="cursor: pointer;" accept="image/*">
                            </div>
                            
                            <p class="text-muted mt-3 small">Clique no círculo para<br>selecionar uma foto.</p>
                        </div>

                        <div class="col-md-8 ps-md-4">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Nome do Serviço <span class="text-danger">*</span></label>
                                    <input type="text" name="nome" class="form-control" placeholder="Ex: Lavagem Simples, Polimento..." required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Preço (R$) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold">R$</span>
                                        <input type="text" name="preco" class="form-control money" placeholder="0,00" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Duração <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="duracao" class="form-control" value="30" required>
                                        <span class="input-group-text bg-light">min</span>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <label class="form-label fw-semibold">Descrição (Opcional)</label>
                                    <textarea name="descricao" class="form-control" rows="3" placeholder="Descreva brevemente o serviço para seus clientes..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                        <i class="mdi mdi-check-circle-outline me-1"></i> Salvar Serviço
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

        // Preview da imagem
        $('#foto-input').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#preview-foto-servico').attr('src', event.target.result);
                    $('#icon-placeholder').hide(); // Esconde o ícone de câmera
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>