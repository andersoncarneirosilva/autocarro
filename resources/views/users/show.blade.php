@extends('layouts.app')

@section('title', 'Listagem do Usuário')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </div>
            <h3 class="page-title">{{ $user->name }}</h3>
        </div>
    </div>
</div>
<br>
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
                    <p class="text-muted mb-2 font-13"><strong>Nome :</strong> <span class="ms-2">{{ $user->name }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Telefone :</strong><span class="ms-2">{{ $user->telefone }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{ $user->email }}</span></p>

                    <p class="text-muted mb-1 font-13"><strong>Perfil :</strong> <span class="ms-2">{{ $user->perfil }}</span></p>
                </div>

                <ul class="social-list list-inline mt-3 mb-0">
                    @if($user->facebook == "#")
                    
                    @else
                    <li class="list-inline-item">
                        <a href="{{ $user->facebook }}" target="_blank" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                    </li>
                    @endif
                    @if($user->instagram == "#")
                    
                    @else
                    <li class="list-inline-item">
                        <a href="{{ $user->instagram }}" target="_blank"  class="social-list-item border-danger text-danger"><i class="mdi mdi-instagram"></i></a>
                    </li>
                    @endif
                    @if($user->skype == "#")
                    
                    @else
                    <li class="list-inline-item">
                        <a href="{{ $user->skype }}" target="_blank"  class="social-list-item border-info text-info"><i class="mdi mdi-skype"></i></a>
                    </li>
                    @endif
                    @if($user->linkedin == "#")
                    
                    @else
                    <li class="list-inline-item">
                        <a href="{{ $user->linkedin }}" target="_blank"  class="social-list-item border-secondary text-secondary"><i class="mdi mdi-linkedin"></i></a>
                    </li>
                    @endif
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
                                <label for="firstname" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="firstname" name="name" value="{{ $user->name ?? old('name') }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">E-mail</label>
                                <input type="text" class="form-control" id="lastname" name="email" value="{{ $user->email ?? old('email') }}" disabled>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="useremail" name="telefone" value="{{ $user->telefone ?? old('telefone') }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="userpassword" class="form-label">Cargo</label>
                                <input type="text" class="form-control" id="cargo" name="cargo" value="{{ $user->cargo ?? old('cargo') }}" disabled>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Perfil</label>
                                <select class="form-select" name="perfil" disabled>
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="userpassword" class="form-label">Data de nascimento</label>
                                <input type="date" name="nascimento" value="{{ $user->nascimento ?? old('nascimento') }}" class="form-control" disabled />
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building me-1"></i> Endereço</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="companyname" class="form-label">CEP</label>
                                <input type="text" name="cep" onblur="pesquisacep(this.value);" onkeyup="this.value = formatCEP(this.value)" value="{{ $user->cep ?? old('cep') }}" id="cep" class="form-control" disabled />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Logradouro</label>
                                <input type="text" name="logradouro" value="{{ $user->logradouro ?? old('logradouro') }}" id="rua" class="form-control" disabled />
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Bairro</label>
                                <input type="text" name="cidade" value="{{ $user->bairro ?? old('bairro') }}" id="bairro" class="form-control" disabled />
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Cidade</label>
                                <input type="text" name="cidade" value="{{ $user->cidade ?? old('cidade') }}" id="cidade" class="form-control" disabled />
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Estado</label>
                                <input type="text" name="estado" value="{{ $user->estado ?? old('estado') }}" id="uf" class="form-control" disabled />
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cwebsite" class="form-label">Complemento</label>
                                <input type="text" name="complemento" value="{{ $user->complemento ?? old('complemento') }}" id="complemento" class="form-control" disabled/>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                    

                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Mídias sociais</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-fb" class="form-label">Facebook</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-facebook"></i></span>
                                    <input type="text" class="form-control" id="social-fb" placeholder="Url" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Instagram</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-instagram"></i></span>
                                    <input type="text" class="form-control" id="social-insta" placeholder="Url" disabled>
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
                                    <input type="text" class="form-control" id="social-sky" placeholder="@username" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-lin" class="form-label">Linkedin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-linkedin"></i></span>
                                    <input type="text" class="form-control" id="social-lin" placeholder="Url" disabled>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div><!-- end row -->
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div>
    
</div>

@endsection