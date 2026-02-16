<div class="modal fade" id="modalCadastrarProduto" tabindex="-1" aria-labelledby="modalCadastrarProdutoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" id="modalCadastrarProdutoLabel">
                    <i class="mdi mdi-package-variant-closed me-2"></i>Novo Produto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('estoque.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nome do Produto <span class="text-danger">*</span></label>
                            <input type="text" name="nome" class="form-control" placeholder="Ex: Shampoo Pós-Química 1L" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Categoria <span class="text-danger">*</span></label>
                            <select name="categoria" class="form-select" required>
                                <option value="Cabelo">Cabelo</option>
                                <option value="Unhas">Unhas</option>
                                <option value="Estética">Estética</option>
                                <option value="Insumos">Insumos (Uso Interno)</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Marca</label>
                            <input type="text" name="marca" class="form-control" placeholder="Ex: L'Oréal, Wella...">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Código de Barras</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="mdi mdi-barcode"></i></span>
                                <input type="text" name="codigo_barras" class="form-control" placeholder="Opcional">
                            </div>
                        </div>

                        <hr class="my-3 text-muted">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-danger">Preço de Custo (R$)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-start-0">R$</span>
                                <input type="text" name="preco_custo" class="form-control money" placeholder="0,00" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-success">Preço de Venda (R$)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-start-0">R$</span>
                                <input type="text" name="preco_venda" class="form-control money" placeholder="0,00" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estoque Atual <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="mdi mdi-plus-box"></i></span>
                                <input type="number" name="estoque_atual" class="form-control" value="0" min="0" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estoque Mínimo (Alerta)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="mdi mdi-alert-circle"></i></span>
                                <input type="number" name="estoque_minimo" class="form-control" value="5" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="mdi mdi-check me-1"></i>Salvar Produto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
    $('.money').mask('#.##0,00', {reverse: true});
});
</script>