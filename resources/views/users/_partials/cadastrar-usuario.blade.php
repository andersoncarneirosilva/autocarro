<div class="modal fade" id="modalCadastrarUsuario" tabindex="-1" aria-labelledby="modalCadastrarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white fw-bold" id="modalCadastrarUsuarioLabel">
                    <i class="uil uil-user-plus me-2"></i>Adicionar Novo Vendedor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('users.store') }}" method="POST" id="formUsuario">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        {{-- Nome Completo --}}
                        <div class="col-md-12">
                            <label for="name" class="form-label fw-semibold text-dark">Nome Completo do Vendedor</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-user text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="name" name="name" placeholder="Ex: João Silva" required>
                            </div>
                        </div>

                        {{-- E-mail --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-dark">E-mail (Login)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-envelope text-muted"></i></span>
                                <input type="email" class="form-control bg-light border-start-0" id="email" name="email" placeholder="joao@email.com" required>
                            </div>
                        </div>

                        {{-- CPF --}}
                        <div class="col-md-6">
                            <label for="cpf_usuario" class="form-label fw-semibold text-dark">CPF</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-card-atm text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="cpf_usuario" name="cpf" placeholder="000.000.000-00" required>
                            </div>
                        </div>

                        {{-- Telefone --}}
                        <div class="col-md-6">
                            <label for="telefone_usuario" class="form-label fw-semibold text-dark">Telefone/WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-phone text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="telefone_usuario" name="telefone" placeholder="(00) 0 0000-0000">
                            </div>
                        </div>

                        {{-- Senha --}}
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold text-dark">Senha de Acesso</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-lock text-muted"></i></span>
                                <input type="password" class="form-control bg-light border-start-0" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
                            </div>
                        </div>

                        {{-- Campos Ocultos de Segurança --}}
                        <input type="hidden" name="nivel_acesso" value="Vendedor">
                        <input type="hidden" name="status" value="Ativo">
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="mdi mdi-close me-1"></i> Cancelar
                    </button>
                    
                    <button type="submit" class="btn btn-primary" id="btnSubmitUser">
                        <i class="mdi mdi-check me-1"></i> Cadastrar
                    </button>

                    <button class="btn btn-primary" id="btnLoadingUser" type="button" disabled style="display: none;">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Processando...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formUsuario');
        const submitBtn = document.getElementById('btnSubmitUser');
        const loadingBtn = document.getElementById('btnLoadingUser');

        // 1. Controle de Loading
        if (form) {
            form.addEventListener('submit', function (e) {
                if (form.checkValidity()) {
                    submitBtn.style.display = 'none';
                    loadingBtn.style.display = 'inline-block';
                }
            });
        }

        // 2. Máscara CPF
        const cpfInput = document.getElementById('cpf_usuario');
        if (cpfInput) {
            cpfInput.addEventListener('input', function (e) {
                let v = e.target.value.replace(/\D/g, '');
                if (v.length > 11) v = v.slice(0, 11);
                v = v.replace(/(\d{3})(\d)/, '$1.$2');
                v = v.replace(/(\d{3})(\d)/, '$1.$2');
                v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = v;
            });
        }

        // 3. Máscara Telefone
        const telInput = document.getElementById('telefone_usuario');
        if (telInput) {
            telInput.addEventListener('input', function (e) {
                let v = e.target.value.replace(/\D/g, '');
                if (v.length > 11) v = v.slice(0, 11);
                if (v.length > 10) {
                    v = v.replace(/^(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
                } else {
                    v = v.replace(/^(\d{2})(\d{4})(\d{4})/, "($1) $2-$3");
                }
                e.target.value = v;
            });
        }
    });
</script>