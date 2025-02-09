@extends('layouts.app')

@section('title', 'Detalhes do veículo')

@section('content')

@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('veiculos.index') }}">Veículos</a></li>
                    <li class="breadcrumb-item active">Detalhes</li>
                </ol>
            </div>
            <h3 class="page-title">Detalhes do veículo</h3>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-12">
        <!-- Profile -->
        <div class="card border border-secondary shadow">
            <div class="card-body profile-user-box">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar-lg">
                                        <img src="{{ url("$veiculo->image") }}" alt="" class="rounded-circle img-thumbnail border border-secondary">
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <h4 class="mt-1 mb-1 ">Marca</h4>
                                    <p class="font-13">{{ $veiculo->marca }}</p>

                                    <ul class="mb-0 list-inline">
                                        <li class="list-inline-item me-3">
                                            <h5 class="mb-1 ">Placa</h5>
                                            <p class="mb-0 font-13 ">{{ $veiculo->placa }}</p>
                                            
                                        </li>
                                        <li class="list-inline-item">
                                            <h5 class="mb-1 ">Ano</h5>
                                            <p class="mb-0 font-13 ">{{ $veiculo->ano }}</p>
                                        </li>
                                        <li class="list-inline-item">
                                            <h5 class="mb-1">Cor</h5>
                                            <p class="mb-0 font-13 ">{{ $veiculo->cor }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-sm-4">
                        <div class="text-center mt-sm-0 mt-3 text-sm-end">
                            {{-- <button type="button" class="btn btn-light">
                                <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                            </button> --}}
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row -->

            </div> <!-- end card-body/ profile-user-box-->
        </div><!--end profile/ card -->
    </div> <!-- end col-->
</div>

<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-body">
                {{-- @if($veiculo->image)
                <img src="/storage/{{ $veiculo->image }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                @else
                    <img src="{{ url('assets/img/icon_user.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                @endif --}}
            
                {{-- <h4 class="mb-0 mt-2">{{ $veiculo->marca }}</h4> --}}
            
                <div class="row" style="text-align: left;">
                    <p class="text-muted mb-2 font-13"><strong>DOCUMENTOS GERADOS</strong></p>
                    @if (!empty($veiculo->arquivo_doc))
                        <div class="col-12">
                            <div class="shadow-none border rounded p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-reset rounded">
                                                <i class="mdi mdi-file-pdf-box font-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col ps-0" style="text-align: left;">
                                        <a href="{{ $veiculo->arquivo_doc }}" target="_blank" class="text-muted fw-bold">CRLV</a>
                                        <p class="mb-0 font-13">{{ number_format($veiculo->size_doc / 1024, 2, ',', '.') }} KB</p>
                                    </div>
                                    <div class="col-auto">
                                        <form action="{{ route('veiculos.excluir_doc', $veiculo->id) }}" method="POST" id="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="text-secondary font-20" id="deleteIcon">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </a>
                                        </form>
                                        <script>
                                            document.getElementById('deleteIcon').addEventListener('click', function(event) {
                                                event.preventDefault(); // Impede o envio do formulário inicialmente
                                            
                                                Swal.fire({
                                                    title: 'Atenção',
                                                    text: "Deseja excluir este documento?",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Sim, excluir!',
                                                    cancelButtonText: 'Cancelar',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('deleteForm').submit(); // Envia o formulário se o usuário confirmar
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div> <!-- end row -->
                            </div> <!-- end shadow-none border rounded -->
                        </div> <!-- end col-12 -->
                    @endif
                </div> <!-- end row -->
                <br>
                <div class="row">
                    @if (!empty($veiculo->arquivo_proc))
                        <div class="col-12">
                            <div class="shadow-none border rounded p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-reset rounded">
                                                <i class="mdi mdi-file-pdf-box font-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col ps-0" style="text-align: left;">
                                        <a href="{{ $veiculo->arquivo_proc }}" target="_blank" class="text-muted fw-bold">Procuração</a>
                                        <p class="mb-0 font-13">{{ number_format($veiculo->size_proc / 1024, 2, ',', '.') }} KB</p>
                                    </div>
                                    <div class="col-auto">
                                        <form action="{{ route('veiculos.excluir_proc', $veiculo->id) }}" method="POST" id="deleteProcForm">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="text-secondary font-20" id="deleteProcIcon">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </a>
                                        </form>
                                        <script>
                                            document.getElementById('deleteProcIcon').addEventListener('click', function(event) {
                                                event.preventDefault(); // Impede o envio do formulário inicialmente
                                            
                                                Swal.fire({
                                                    title: 'Atenção',
                                                    text: "Deseja excluir esta procuração?",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Sim, excluir!',
                                                    cancelButtonText: 'Cancelar',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('deleteProcForm').submit(); // Envia o formulário se o usuário confirmar
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div> <!-- end row -->
                            </div> <!-- end shadow-none border rounded -->
                        </div> <!-- end col-12 -->
                    @endif
                </div> <!-- end row -->
                <br>
                <div class="row">
                    @if (!empty($veiculo->arquivo_atpve))
                        <div class="col-12">
                            <div class="shadow-none border rounded p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-reset rounded">
                                                <i class="mdi mdi-file-pdf-box font-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col ps-0" style="text-align: left;">
                                        <a href="{{ $veiculo->arquivo_atpve }}" target="_blank" class="text-muted fw-bold">ATPVe</a>
                                        <p class="mb-0 font-13">{{ number_format($veiculo->size_atpve / 1024, 2, ',', '.') }} KB</p>
                                    </div>
                                    <div class="col-auto">
                                        <form action="{{ route('veiculos.excluir_atpve', $veiculo->id) }}" method="POST" id="deleteAtpveForm">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="text-secondary font-20" id="deleteAtpveIcon">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </a>
                                        </form>
                                        <script>
                                            document.getElementById('deleteAtpveIcon').addEventListener('click', function(event) {
                                                event.preventDefault(); // Impede o envio do formulário inicialmente
                                            
                                                Swal.fire({
                                                    title: 'Atenção',
                                                    text: "Deseja excluir esta solicitação ATPVe?",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Sim, excluir!',
                                                    cancelButtonText: 'Cancelar',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('deleteAtpveForm').submit(); // Envia o formulário se o usuário confirmar
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div> <!-- end row -->
                            </div> <!-- end shadow-none border rounded -->
                        </div> <!-- end col-12 -->
                    @endif

                </div> <!-- end row -->
                <br>
                <div class="row" style="text-align: left;">
                    <p class="text-muted mb-2 font-13"><strong>DOCUMENTOS ASSINADOS</strong></p>
                    @if (!empty($veiculo->arquivo_proc_assinado))
                        <div class="col-12">
                            <div class="shadow-none border rounded p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-reset rounded">
                                                <i class="mdi mdi-file-pdf-box font-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col ps-0" style="text-align: left;">
                                        <a href="{{ $veiculo->arquivo_proc_assinado }}" target="_blank" class="text-muted fw-bold">Procuração Assinada</a>
                                        <p class="mb-0 font-13">{{ number_format($veiculo->size_proc_pdf / 1024, 2, ',', '.') }} KB</p>
                                    </div>
                                    <div class="col-auto">
                                        <form action="{{ route('veiculos.excluir_proc_assinado', $veiculo->id) }}" method="POST" id="deleteProcAssinadoForm">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="text-secondary font-20" id="deleteProcAssinadoIcon">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </a>
                                        </form>
                                        <script>
                                            document.getElementById('deleteProcAssinadoIcon').addEventListener('click', function(event) {
                                                event.preventDefault(); // Impede o envio do formulário inicialmente
                                        
                                                Swal.fire({
                                                    title: 'Atenção',
                                                    text: "Deseja excluir esta procuração?",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Sim, excluir!',
                                                    cancelButtonText: 'Cancelar',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('deleteProcAssinadoForm').submit(); // Envia o formulário se o usuário confirmar
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div> <!-- end row -->
                            </div> <!-- end shadow-none border rounded -->
                        </div> <!-- end col-12 -->
                    @endif
                </div>  <!-- end row -->

                <br>
                <div class="row">
                    @if (!empty($veiculo->arquivo_atpve_assinado))
                        <div class="col-12">
                            <div class="shadow-none border rounded p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-reset rounded">
                                                <i class="mdi mdi-file-pdf-box font-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col ps-0" style="text-align: left;">
                                        <a href="{{ $veiculo->arquivo_atpve_assinado }}" target="_blank" class="text-muted fw-bold">Solicitação de ATPVe Assinada</a>
                                        <p class="mb-0 font-13">{{ number_format($veiculo->size_atpve_pdf / 1024, 2, ',', '.') }} KB</p>
                                    </div>
                                    <div class="col-auto">
                                        <form action="{{ route('veiculos.excluir_atpve_assinado', $veiculo->id) }}" method="POST" id="deleteAtpveAssinadoForm">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="text-secondary font-20" id="deleteAtpveAssinadoIcon">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </a>
                                        </form>
                                        <script>
                                            document.getElementById('deleteAtpveAssinadoIcon').addEventListener('click', function(event) {
                                                event.preventDefault(); // Impede o envio do formulário inicialmente
                                        
                                                Swal.fire({
                                                    title: 'Atenção',
                                                    text: "Deseja excluir esta solicitação ATPVe?",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Sim, excluir!',
                                                    cancelButtonText: 'Cancelar',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('deleteAtpveAssinadoForm').submit(); // Envia o formulário se o usuário confirmar
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div> <!-- end row -->
                            </div> <!-- end shadow-none border rounded -->
                        </div> <!-- end col-12 -->
                    @endif
                    
                </div> <!-- end row -->
                <div class="row">
                    <div class="col-12">
                    @if(empty($veiculo->arquivo_atpve_assinado || $veiculo->arquivo_proc_assinado))
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
                    </div>
                </div>
            </div> <!-- end card-body -->
             
        </div> 
    </div>
    
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('veiculos.update', $veiculo->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-file me-1"></i> Enviar documentos</h5>
                    <div class="row">
                        @if ($veiculo->arquivo_doc === "0")
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">CRLV</label>
                                <input class="form-control" type="file" name="arquivo_doc">
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Procuração assinada</label>
                                <input class="form-control" type="file" name="arquivo_proc_assinado">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">ATPVe assinada</label>
                                <input class="form-control" type="file" name="arquivo_atpve_assinado">
                            </div>
                        </div>
                    </div> <!-- end row -->
                    @if ($veiculo->crv === "***")
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">CRV:</label>
                                <input class="form-control" type="text" name="crv" value="{{ $veiculo->crv ?? old('crv') }}">
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="text-end">
                        <a href="{{ route('veiculos.index')}}" class="btn btn-secondary btn-sm">Voltar</a>
                        <button type="submit" class="btn btn-success btn-sm">Enviar</button>
                    </div>
                </form>
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div>

    
</div>

@endsection