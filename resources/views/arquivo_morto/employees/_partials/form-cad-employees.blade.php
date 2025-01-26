<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Colaboradores</a></li>
                    <li class="breadcrumb-item active">Novo colaborador</li>
                </ol>
            </div>
            <h3 class="page-title">Novo colaborador</h3>
        </div>
    </div>
</div>
<br>

<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                <img src="{{ url('assets/img/icon_user.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                <h4 class="mb-0 mt-2"></h4>
                <p class="text-muted font-14"></p>

                <ul class="social-list list-inline mt-3 mb-0">
                    <li class="list-inline-item">
                        <a href="#" target="_blank" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" target="_blank"  class="social-list-item border-danger text-danger"><i class="mdi mdi-instagram"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" target="_blank"  class="social-list-item border-info text-info"><i class="mdi mdi-skype"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" target="_blank"  class="social-list-item border-secondary text-secondary"><i class="mdi mdi-linkedin"></i></a>
                    </li>
                </ul>
            </div> 
        </div> 
    </div>
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Informações pessoais</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Nome:<span style="color:#ff0000;"> *</span></label>
                                <input type="text" class="form-control" id="firstname" name="name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">E-mail<span style="color:#ff0000;"> *</span></label>
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Telefone<span style="color:#ff0000;"> *</span></label>
                                <input type="tel" class="form-control" name="telefone" onkeyup="handlePhone(event)" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="userpassword" class="form-label">Cargo</label>
                                <input type="text" class="form-control" name="cargo">
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Perfil</label>
                                <select class="form-select" name="perfil" >
                                    <option value="Administrador">Administrador</option>
                                    <option value="Usuário">Usuário</option>
                                    
                                  </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="userpassword" class="form-label">Data de nascimento</label>
                                <input type="date" name="nascimento" class="form-control" placeholder=" " required />
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building me-1"></i> Endereço</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="companyname" class="form-label">CEP</label>
                                <input type="text" name="cep" onblur="pesquisacep(this.value);" onkeyup="this.value = formatCEP(this.value)" id="cep" class="form-control" placeholder=" " required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Logradouro</label>
                                <input type="text" name="logradouro" id="rua" class="form-control" placeholder=" " required />
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Bairro</label>
                                <input type="text" name="bairro" id="bairro" class="form-control" required />
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Cidade</label>
                                <input type="text" name="cidade" id="cidade" class="form-control" required />
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Estado</label>
                                <input type="text" name="estado" id="uf" class="form-control" required />
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Complemento</label>
                                <input type="text" name="complemento"" id="complemento" class="form-control"/>
                            </div>
                        </div> <!-- end col -->
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


                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Foto de perfil</h5>
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <input class="form-control" type="file" name="image">
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <br>
                    

                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Mídias sociais</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-fb" class="form-label">Facebook</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-facebook"></i></span>
                                    <input type="text" class="form-control" id="social-fb" placeholder="Url">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Instagram</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-instagram"></i></span>
                                    <input type="text" class="form-control" id="social-insta" placeholder="Url">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-sky" class="form-label">Skype</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-skype"></i></span>
                                    <input type="text" class="form-control" id="social-sky" placeholder="@username">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-lin" class="form-label">Linkedin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-linkedin"></i></span>
                                    <input type="text" class="form-control" id="social-lin" placeholder="Url">
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div><!-- end row -->
                    
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ url()->previous() }}"><button type="button" class="btn btn-secondary btn-sm">Voltar</button></a>
                            <button type="button" onclick="form.reset();" class="btn btn-warning btn-sm">Limpar</button>
                            <button type="button" class="btn btn-success btn-sm" id="submitFormEmployess">Cadastrar</button>
                        </div>
                    </div>
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div>
    
</div>
