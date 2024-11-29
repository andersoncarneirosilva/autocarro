@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Meu perfil</li>
                </ol>
            </div>
            <h3 class="page-title">Meu perfil</h3>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                @if(auth()->user()->image)
                <img src="storage/{{ auth()->user()->image }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                @else
                <img src="{{ url("assets/img/icon_user.png") }}" alt="" class="rounded-circle avatar-lg img-thumbnail">
                @endif
                <h4 class="mb-0 mt-2">{{ auth()->user()->name }}</h4>
                <p class="text-muted font-14">{{ auth()->user()->cargo }}</p>
              
                <div class="text-start mt-3">
                    <p class="text-muted mb-2 font-13"><strong>Nome: :</strong> <span class="ms-2">{{ auth()->user()->name }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Telefone:</strong><span class="ms-2">{{ auth()->user()->telefone }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Email:</strong> <span class="ms-2 ">{{ auth()->user()->email }}</span></p>

                    <p class="text-muted mb-1 font-13"><strong>Endereço:</strong> <span class="ms-2">{{ auth()->user()->logradouro }} - {{ auth()->user()->bairro }}/{{ auth()->user()->cidade }}</span></p>
                    
                </div>
                <ul class="social-list list-inline mt-3 mb-0">
                    @if(auth()->user()->facebook == "#")
                    
                    @else
                    <li class="list-inline-item">
                        <a href="{{ auth()->user()->facebook }}" target="_blank" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                    </li>
                    @endif
                    @if(auth()->user()->instagram == "#")
                    
                    @else
                    <li class="list-inline-item">
                        <a href="{{ auth()->user()->instagram }}" target="_blank"  class="social-list-item border-danger text-danger"><i class="mdi mdi-instagram"></i></a>
                    </li>
                    @endif
                    @if(auth()->user()->skype == "#")
                    
                    @else
                    <li class="list-inline-item">
                        <a href="{{ auth()->user()->skype }}" target="_blank"  class="social-list-item border-info text-info"><i class="mdi mdi-skype"></i></a>
                    </li>
                    @endif
                    @if(auth()->user()->linkedin == "#")
                    
                    @else
                    <li class="list-inline-item">
                        <a href="{{ auth()->user()->linkedin }}" target="_blank"  class="social-list-item border-secondary text-secondary"><i class="mdi mdi-linkedin"></i></a>
                    </li>
                    @endif
                    <li class="list-inline-item">
                        <a href="mailto:{{ auth()->user()->email }}" target="_blank"  class="social-list-item border-success text-success"><i class="mdi mdi-mail"></i></a>
                    </li>
                </ul>
            </div> <!-- end card-body -->
        </div> <!-- end card -->

    </div> <!-- end col-->

    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('perfil.update', auth()->user()->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                <h5 class="mb-3 text-uppercase p-2"><i class="mdi mdi-account-circle me-1"></i> Informações pessoais</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="userpassword" class="form-label">Confirmar senha</label>
                                <input type="password" class="form-control" name="password_confirm">
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                    </div>
                </form>
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div> <!-- end col -->
</div>

@endsection