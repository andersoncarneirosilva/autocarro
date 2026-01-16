<style>
    .modal-content {
    border-radius: 15px;
    overflow: hidden;
}
.input-group-text {
    border-right: none;
    color: #6c757d;
}
.form-control {
    border-left: none;
}
.form-control:focus {
    box-shadow: none;
    border-color: #dee2e6;
}
.btn-primary {
    border-radius: 8px;
    font-weight: 500;
}
</style>

<div class="modal fade" id="modalCadastrarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-red text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i> Novo Usuário</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nome Completo</label>
                            <div class="input-group">
                                <span class="input-group-text "><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ex: João Silva" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="joao@email.com" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telefone</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                <input type="text" name="telefone" class="form-control @error('telefone') is-invalid @enderror" value="{{ old('telefone') }}" placeholder="(00) 00000-0000">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nível de Acesso</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-shield-alt"></i></span>
                                <select name="nivel_acesso" class="form-select @error('nivel_acesso') is-invalid @enderror">
                                    <option value="user" {{ old('nivel_acesso') == 'user' ? 'selected' : '' }}>Usuário Comum</option>
                                    <option value="admin" {{ old('nivel_acesso') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mínimo 8 caracteres" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Confirmar Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-check-double"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a senha" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Foto de Perfil</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            <div class="form-text">Formatos aceitos: JPG, PNG. Tamanho máx: 2MB</div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-red px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>