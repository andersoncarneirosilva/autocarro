@extends('layouts.app')

@section('title', 'Listagem do Usuário')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('veiculos.index') }}">Veículos</a></li>
                    <li class="breadcrumb-item active">{{ $user->marca }}</li>
                </ol>
            </div>
            <h3 class="page-title">Detalhes: {{ $user->marca }}</h3>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                {{-- @if($user->image)
                <img src="/storage/{{ $user->image }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                @else
                    <img src="{{ url('assets/img/icon_user.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                @endif--}}

                <h4 class="mb-0 mt-2">{{ $user->marca }}</h4>

                <div class="text-start mt-3">
                    {{-- <p class="text-muted mb-2 font-13"><strong>Marca:</strong><span class="ms-2">{{ $user->marca }}</span></p> --}}

                    <p class="text-muted mb-2 font-13"><strong>Placa:</strong><span class="ms-2">{{ $user->placa }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Cor:</strong><span class="ms-2 ">{{ $user->cor }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Ano/Modelo:</strong><span class="ms-2">{{ $user->ano }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Chassi:</strong><span class="ms-2">{{ $user->chassi }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Renavam:</strong><span class="ms-2">{{ $user->renavam }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Cidade:</strong><span class="ms-2">{{ $user->cidade }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>CRV:</strong><span class="ms-2">{{ $user->crv }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Categoria:</strong><span class="ms-2">{{ $user->categoria }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Motor:</strong><span class="ms-2">{{ $user->motor }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Combustível:</strong><span class="ms-2">{{ $user->combustivel }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Observações:</strong><span class="ms-2">{{ $user->infos }}</span></p>
                </div>
            </div> 
        </div> 
    </div>
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                <form>
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Procuração assinada</label>
                                <input class="form-control" type="file">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">ATPVe assinada</label>
                                <input class="form-control" type="file">
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">

                                @if (!empty($user->arquivo_proc))
                                <div class="card mb-1 shadow-none border">
                                    <div class="p-2">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-primary-lighten text-primary rounded">
                                                        .PDF
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <a href="{{ $user->arquivo_proc }}" target="_blank" class="text-muted fw-bold">{{ $user->placa }}.pdf</a>
                                                <p class="mb-0">2.3 MB</p>
                                            </div>
                                            <div class="col-auto">
                                                <!-- Button -->
                                                <a href="javascript:void(0);" class="btn btn-link btn-lg text-muted">
                                                    <i class="ri-download-2-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                               
                                @if (!empty($user->arquivo_atpve))
                                <div class="card mb-1 shadow-none border">
                                    <div class="p-2">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-primary-lighten text-primary rounded">
                                                        .ZIP
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <a href="{{ $user->arquivo_atpve }}" target="_blank" class="text-muted fw-bold">atpve_{{ $user->placa }}.pdf</a>
                                                <p class="mb-0">2.3 MB</p>
                                            </div>
                                            <div class="col-auto">
                                                <!-- Button -->
                                                <a href="{{ $user->arquivo_atpve }}" class="btn btn-link btn-lg text-muted">
                                                    <i class="ri-download-2-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif


                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="text-end">
                        <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                    </div>
                </form>
            </div> <!-- end card body -->
        </div>
    </div>
    
</div>

@endsection