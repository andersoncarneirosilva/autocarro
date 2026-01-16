<div class="modal fade" id="modalEditarUsuario{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-dark">
                <h5 class="modal-title text-white"><i class="fas fa-user-edit me-2"></i> Editar Usuário: {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nome Completo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telefone</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                <input type="text" name="telefone" class="form-control" value="{{ old('telefone', $user->telefone) }}">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nível de Acesso</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-shield-alt"></i></span>
                                <select name="nivel_acesso" class="form-select">
                                    <option value="user" {{ $user->nivel_acesso == 'user' ? 'selected' : '' }}>Usuário Comum</option>
                                    <option value="admin" {{ $user->nivel_acesso == 'admin' ? 'selected' : '' }}>Administrador</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-toggle-on"></i></span>
                                <select name="status" class="form-select">
                                    <option value="1" {{ $user->status == '1' ? 'selected' : '' }}>Ativo</option>
                                    <option value="0" {{ $user->status == '0' ? 'selected' : '' }}>Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Alterar Foto</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="col-12 mt-2">
                            <div class="alert alert-info py-2" style="font-size: 0.85rem;">
                                <i class="fas fa-info-circle me-1"></i> Deixe os campos de senha em branco caso não queira alterá-la.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nova Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Preencha para alterar">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Confirmar Nova Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-check-double"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a nova senha">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold">
                        <i class="fas fa-sync-alt me-1"></i> Atualizar Dados
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>