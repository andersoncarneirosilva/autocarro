<div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="modalEditarProdutoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalEditarProdutoLabel">
                    <i class="mdi mdi-pencil me-2"></i>Editar Produto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formEditarProduto" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nome do Produto <span class="text-danger">*</span></label>
                            <input type="text" name="nome" id="edit_nome" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Categoria <span class="text-danger">*</span></label>
                            <select name="categoria" id="edit_categoria" class="form-select" required>
                                <option value="Cabelo">Cabelo</option>
                                <option value="Unhas">Unhas</option>
                                <option value="Estética">Estética</option>
                                <option value="Insumos">Insumos (Uso Interno)</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Marca</label>
                            <input type="text" name="marca" id="edit_marca" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Código de Barras</label>
                            <input type="text" name="codigo_barras" id="edit_codigo_barras" class="form-control">
                        </div>

                        <hr class="my-3 text-muted">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-danger">Preço de Custo (R$)</label>
                            <input type="text" name="preco_custo" id="edit_preco_custo" class="form-control money" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-success">Preço de Venda (R$)</label>
                            <input type="text" name="preco_venda" id="edit_preco_venda" class="form-control money" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estoque Atual</label>
                            <input type="number" name="estoque_atual" id="edit_estoque_atual" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estoque Mínimo</label>
                            <input type="number" name="estoque_minimo" id="edit_estoque_minimo" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4">Atualizar Produto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).on('click', '.btn-editar-produto', function() {
    const id = $(this).data('id');
    const nome = $(this).data('nome');
    const categoria = $(this).data('categoria');
    const marca = $(this).data('marca');
    const codigo = $(this).data('codigo');
    const custo = $(this).data('custo');
    const venda = $(this).data('venda');
    const atual = $(this).data('atual');
    const minimo = $(this).data('minimo');

    // Define a rota de atualização dinamicamente
    $('#formEditarProduto').attr('action', `/estoque/update/${id}`);

    // Preenche os campos
    $('#edit_nome').val(nome);
    $('#edit_categoria').val(categoria);
    $('#edit_marca').val(marca);
    $('#edit_codigo_barras').val(codigo);
    $('#edit_preco_custo').val(custo).trigger('input'); // Trigger para a máscara formatar
    $('#edit_preco_venda').val(venda).trigger('input');
    $('#edit_estoque_atual').val(atual);
    $('#edit_estoque_minimo').val(minimo);

    $('#modalEditarProduto').modal('show');
});
</script>