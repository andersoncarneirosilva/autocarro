<div class="modal fade" id="modalEditarUsuario{{ $user->id }}" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white fw-bold">
                    <i class="uil uil-edit me-2"></i>Editar Membro da Equipe
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('users.update', $user->id) }}" method="POST" id="formUsuario">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        {{-- Campos de Nome, Email, CPF e Telefone (Mantidos como você enviou) --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">Nome Completo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-user text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" name="name" value="{{ $user->name }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">E-mail (Login)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-envelope text-muted"></i></span>
                                <input type="email" class="form-control bg-light border-start-0 email-mask" name="email" value="{{ $user->email }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">CPF</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-card-atm text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 cpf-mask" value="{{ $user->cpf }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Telefone/WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-phone text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 tel-mask" name="telefone" value="{{ $user->telefone }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Nova Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-lock text-muted"></i></span>
                                <input type="password" class="form-control bg-light border-start-0" name="password" placeholder="Em branco para manter">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Status de Acesso</label>
                            <select name="status" class="form-select bg-light">
                                <option value="Ativo" {{ $user->status == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="Inativo" {{ $user->status == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="mdi mdi-close me-1"></i> Cancelar
                    </button>
                    
                    <button type="submit" class="btn btn-primary" id="btnSubmitUser">
                        <i class="mdi mdi-check me-1"></i> Atualizar
                    </button>

                    <button class="btn btn-primary" id="btnLoadingUser" type="button" disabled style="display: none;">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Atualizando...
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