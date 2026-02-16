<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCreateLabel">
                    <i class="mdi mdi-whatsapp me-1"></i> Nova Conexão WhatsApp
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('whatsapp.store') }}" method="POST" id="formCreateInstance">
    @csrf
    <div class="modal-body">
    <div class="mb-3">
        <label for="instance_number" class="form-label">Número do WhatsApp (com DDD)</label>
        <input type="text" 
               name="number" 
               id="instance_number" 
               class="form-control" 
               placeholder="(00) 00000-0000" 
               required>
        <div class="form-text">Informe o número que será conectado.</div>
    </div>

    <div class="alert alert-info border-0 mb-0" role="alert">
        <i class="mdi mdi-information-outline me-1"></i>
        <strong>Dica:</strong> Após criar, você precisará ler o QR Code.
    </div>
</div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary shadow-sm" id="btnSubmitCreate">
            <span class="spinner-border spinner-border-sm d-none" id="spinnerCreate"></span>
            Criar conexão
        </button>
    </div>
</form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    // Máscara para Telefone (DDD + 8 ou 9 dígitos)
    var behavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {
        onKeyPress: function (val, e, field, options) {
            field.mask(behavior.apply({}, arguments), options);
        }
    };

    $('#instance_number').mask(behavior, options);

    // Feedback no submit
    $('#formCreateInstance').on('submit', function() {
        $('#btnSubmitCreate').prop('disabled', true);
        $('#spinnerCreate').removeClass('d-none');
    });
});
</script>