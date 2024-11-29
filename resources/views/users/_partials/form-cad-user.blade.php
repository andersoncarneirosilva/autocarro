<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Informações pessoais</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="tel" class="form-control" name="telefone" onkeyup="handlePhone(event)" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Perfil</label>
                                <select class="form-select" name="perfil">
                                    <option value="">Selecione o perfil</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Usuário">Usuário</option>
                                  </select>
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Acesso</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-fb" class="form-label">Senha</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Confirmar senha</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirm" id="password_confirm" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-box me-1"></i> Foto de perfil</h5>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Imagem</label>
                            <div class="input-group">
                                
                                <input class="form-control" type="file" name="image">
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <br>


                    
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" onclick="form.reset();" class="btn btn-warning btn-sm">Limpar</button>
                        <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                        </div>
                    </div>
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div>
    
</div>
