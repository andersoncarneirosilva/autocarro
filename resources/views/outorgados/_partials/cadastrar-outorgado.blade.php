<div id="modalCadastroOut" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalCadastroOutLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalCadastroOutLabel">
                    <i class="mdi mdi-account-plus me-1"></i> Novo Outorgado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('outorgados.store') }}" method="POST" id="formOutorgado">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="mdi mdi-information-outline font-24"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading h6 fw-bold">Informações do Representante</h5>
                                <p class="mb-0 small">Certifique-se de que o <strong>RG</strong>, <strong>CPF</strong> e o <strong>E-mail</strong> estejam corretos para a emissão das procurações.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-account me-1"></i> Nome Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control uppercase-field" name="nome_outorgado" id="nome_outorgado" placeholder="NOME COMPLETO" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-card-account-details me-1"></i> RG <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="rg_outorgado" id="rg_outorgado" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-card-account-details me-1"></i> CPF <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="cpf_outorgado" id="cpf_outorgado" placeholder="000.000.000-00" required>
                        </div>

                        

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-email me-1"></i> E-mail <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" name="email_outorgado" placeholder="email@exemplo.com" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-phone me-1"></i> Telefone <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                id="telefone_outorgado" 
                                class="form-control telefone-mask" 
                                name="telefone_outorgado" 
                                placeholder="(00) 00000-0000" 
                                required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-map-marker me-1"></i> Endereço Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control uppercase-field" name="end_outorgado" id="end_outorgado" placeholder="RUA, NÚMERO, BAIRRO, CIDADE-UF" required>
                            <div class="form-text">
                                Verifique se o endereço está completo para constar na procuração.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="mdi mdi-close me-1"></i> Cancelar
                    </button>
                    
                    <button type="submit" class="btn btn-primary" id="btnSubmitOut">
                        <i class="mdi mdi-check me-1"></i> Cadastrar
                    </button>

                    <button class="btn btn-primary" id="btnLoadingOut" type="button" disabled style="display: none;">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Salvando...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formOutorgado');
    const submitBtn = document.getElementById('btnSubmitOut');
    const loadingBtn = document.getElementById('btnLoadingOut');

    // 1. Lógica de Submissão e Loading (Igual ao Veículo)
    if (form) {
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) return;

            submitBtn.disabled = true;
            submitBtn.style.display = 'none';
            loadingBtn.style.display = 'inline-block';
        });
    }

    // 2. Máscara de CPF e Maiúsculas (Com proteção contra erro de NULO)
    const inputCPF = document.getElementById('cpf_outorgado');
    if (inputCPF) {
        inputCPF.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = v;
        });
    }

    const camposUpper = document.querySelectorAll('.uppercase-field');
    camposUpper.forEach(campo => {
        campo.addEventListener('input', (e) => {
            e.target.value = e.target.value.toUpperCase();
        });
    });
});
</script>

<script>
    $(document).ready(function() {
    var behavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {
        onKeyPress: function (val, e, field, options) {
            field.mask(behavior.apply({}, arguments), options);
        }
    };

    $('.telefone-mask').mask(behavior, options);
});
</script>