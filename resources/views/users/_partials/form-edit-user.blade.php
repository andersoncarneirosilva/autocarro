<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                @if($user->image)
                <img src="/storage/{{ $user->image }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                @else
                    <img src="{{ url('assets/img/icon_user.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                @endif
                <h4 class="mb-0 mt-2">{{ $user->name }}</h4>
                <p class="text-muted font-14">{{ $user->cargo }}</p>

                <div class="text-start mt-3">
                    <p class="text-muted mb-2 font-13"><strong>Nome:</strong> <span class="ms-2">{{ $user->name }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Telefone:</strong><span class="ms-2">{{ $user->telefone }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Email:</strong> <span class="ms-2 ">{{ $user->email }}</span></p>

                    <p class="text-muted mb-1 font-13"><strong>Perfil:</strong> <span class="ms-2">{{ $user->perfil }}</span></p>
                </div>

                
            </div> 
        </div> 
    </div>
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> Informações pessoais</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="firstname" name="name" value="{{ $user->name ?? old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">E-mail:</label>
                                <input type="text" class="form-control" id="lastname" name="email" value="{{ $user->email ?? old('email') }}">
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Telefone:</label>
                                <input type="text" class="form-control" name="telefone" value="{{ $user->telefone ?? old('telefone') }}" onkeyup="handlePhone(event)" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Perfil:</label>
                                <select class="form-select" name="perfil" >
                                    @if($user->perfil == "Administrador")
                                    <option value="Administrador">Administrador</option>
                                    <option value="Usuário">Usuário</option>
                                    @else
                                    <option value="Usuário">Usuário</option>
                                    <option value="Administrador">Administrador</option>
                                    @endif
                                  </select>
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Acesso</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-fb" class="form-label">Senha:</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Confirmar senha:</label>
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
                    
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ url()->previous() }}"><button type="button" class="btn btn-secondary btn-sm">Voltar</button></a>
                        <button type="button" onclick="form.reset();" class="btn btn-warning btn-sm">Limpar</button>
                        <button type="submit" class="btn btn-success btn-sm">Atualizar</button>
                        </div>
                    </div>
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div>
    
</div>
