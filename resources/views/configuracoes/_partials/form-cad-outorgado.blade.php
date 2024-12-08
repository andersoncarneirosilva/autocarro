<div class="modal fade" id="modalCadastroOut" tabindex="-1" aria-labelledby="modalCadastroOutLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCadastroOutLabel">Cadastrar Outorgado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('outorgados.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nome_outorgado" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome_outorgado" name="nome_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf_outorgado" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf_outorgado" name="cpf_outorgado">
                    </div>
                    <div class="mb-3">
                        <label for="end_outorgado" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="end_outorgado" name="end_outorgado" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // Seleciona todos os campos de entrada no formulário
                        const campos = document.querySelectorAll('#nome_outorgado, #cpf_outorgado, #end_outorgado');
                
                        // Adiciona um ouvinte de evento em cada campo
                        campos.forEach(campo => {
                            campo.addEventListener('input', (event) => {
                                // Força o valor para maiúsculas
                                event.target.value = event.target.value.toUpperCase();
                            });
                        });
                    });
                </script>
                
            </div>
        </div>
    </div>
</div>