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
                <p class="text-muted font-14">{{ auth()->user()->perfil }}</p>
              
                <div class="text-start mt-3">
                    <p class="text-muted mb-2 font-13"><strong>Nome: :</strong> <span class="ms-2">{{ auth()->user()->name }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Telefone:</strong><span class="ms-2">{{ auth()->user()->telefone }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Email:</strong> <span class="ms-2 ">{{ auth()->user()->email }}</span></p>
                    
                </div>
                <div class="text-start mt-3">
                    <h4><span class="badge rounded-pill p-1 px-2 badge-success-lighten text-uppercase">PLANO {{ auth()->user()->plano }}</span></h4>
                </div>
            </div> <!-- end card-body -->
        </div> <!-- end card -->

    </div> <!-- end col-->

    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('perfil.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data" >
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
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Foto do perfil</label>
                                <input class="form-control" type="file" name="image">
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                    </div>
                </form>
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div> <!-- end col -->
</div>

@endsection