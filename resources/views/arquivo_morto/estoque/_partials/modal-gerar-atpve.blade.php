<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Gerar APTVe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="addressForm" method="POST">
                    @csrf <!-- Necessário para o Laravel validar a requisição -->
                    <div class="form-group">
                        <label>Selecione o cliente: <span style="color: red;">*</span></label>
                        <select class="select2 form-control select2-multiple" name="cliente[]" id="inputAddress" data-toggle="select2" multiple="multiple">
                            <option value="">Selecione um cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" id="docId" name="docId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="submitAddress()">Gerar Procuração</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openAddressModal(event, docId) {

    window.selectedDocId = docId;  // Salva o docId globalmente

    $('#addressModal').modal('show');
}

</script>



<script>
 function submitAddress() {
    const selectedClient = $('#inputAddress').val(); // Retorna um array para múltiplos valores

    if (!selectedClient || selectedClient.length === 0) {
        Swal.fire('Erro', 'Você precisa selecionar um cliente antes de continuar.', 'error');
        return;
    }

    // Usando o doc_id armazenado globalmente
    const doc_id = window.selectedDocId;

    console.log('Doc ID:', doc_id);
    console.log('Selected Client:', selectedClient);  // Exibe o ID do cliente

    const form = document.getElementById('addressForm');
    form.action = `{{ url('estoque/gerarProc') }}/${selectedClient}/${doc_id}`;

    // Enviar o formulário
    form.submit();
}

</script>