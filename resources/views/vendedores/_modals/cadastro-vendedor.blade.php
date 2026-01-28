<div class="modal fade" id="modalCadastroVend" tabindex="-1" aria-labelledby="modalCadastroVendLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white fw-bold" id="modalCadastroVendLabel">
                    <i class="uil uil-user-plus me-2"></i>Cadastrar Novo Vendedor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('vendedores.store') }}" method="POST" id="formVendedor">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label fw-semibold text-dark">Nome Completo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-user text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="name" name="name" placeholder="Ex: João Silva" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-dark">E-mail (Login)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-envelope text-muted"></i></span>
                                <input type="email" class="form-control bg-light border-start-0" id="email" name="email" placeholder="joao@alcecar.com.br" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="cpf_vendedor" class="form-label fw-semibold text-dark">CPF</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-card-atm text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="cpf_vendedor" name="cpf" placeholder="000.000.000-00" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="telefone" class="form-label fw-semibold text-dark">Telefone/WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-phone text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="telefone_vendedor" name="telefone" placeholder="(00) 0 0000-0000">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold text-dark">Senha de Acesso</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-lock text-muted"></i></span>
                                <input type="password" class="form-control bg-light border-start-0" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
                            </div>
                            <small class="text-muted">O vendedor poderá alterar a senha após o primeiro login.</small>
                        </div>

                        <input type="hidden" name="nivel_acesso" value="Vendedor">
                        <input type="hidden" name="status" value="Ativo">
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
    const form = document.getElementById('formVendedor');
    const submitBtn = document.getElementById('btnSubmitOut');
    const loadingBtn = document.getElementById('btnLoadingOut');

    // 1. Controle de Loading
    if (form) {
        form.addEventListener('submit', function (e) {
            // Verifica a validade do formulário antes de mostrar o loading
            if (form.checkValidity()) {
                submitBtn.style.display = 'none';
                loadingBtn.style.display = 'inline-block';
            }
        });
    }

    // 2. Máscaras
    aplicarMascaraCPF('cpf_vendedor');

    const telInput = document.getElementById('telefone_vendedor');
    if (telInput) {
        telInput.addEventListener('input', function (e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            if (!x) return;
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    }

    // 3. Transformar em Maiúsculas (Adicione a classe 'uppercase-field' nos inputs desejados)
    const camposUpper = document.querySelectorAll('.uppercase-field');
    camposUpper.forEach(campo => {
        campo.addEventListener('input', (e) => {
            e.target.value = e.target.value.toUpperCase();
        });
    });
});

// Função de Máscara Global (Certifique-se que esta função existe no seu arquivo)
function aplicarMascaraCPF(idElemento) {
    const el = document.getElementById(idElemento);
    if (el) {
        el.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
    }
}
</script>