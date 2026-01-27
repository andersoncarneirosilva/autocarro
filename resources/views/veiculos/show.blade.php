@extends('layouts.app')

@section('title', 'Detalhes do Veículo - ' . $veiculo->placa)

@section('content')

@include('veiculos._modals.editar-info-veiculo')

@include('veiculos._modals.editar-info-basicas')

@include('veiculos._modals.editar-precos')

@include('veiculos._modals.editar-opcionais')

@include('veiculos._modals.editar-modificacoes')

@include('veiculos._modals.editar-adicionais')

@include('veiculos._modals.editar-descricao')

@include('veiculos._modals.editar-fotos')

@include('veiculos._modals.gerar-documentos')

{{-- Toasts de sessão --}}
@if (session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        background: '#fff',
        color: '#313a46',
    });

    @if (session('success'))
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif

    @if (session('error'))
        Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
    @endif
});
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



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom">
    <ul class="nav nav-tabs nav-bordered border-0 mb-0">
    <li class="nav-item">
        <a href="#info-geral" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
            <i class="mdi mdi-car-info me-1"></i>
            <span class="d-none d-md-inline-block">Dados do Veículo</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#opcionais" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-check-all me-1"></i>
            <span class="d-none d-md-inline-block">Opcionais</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#valores" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-currency-usd me-1"></i>
            <span class="d-none d-md-inline-block">Valores</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#descricao" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
            <i class="mdi mdi-text-box-outline me-1"></i>
            <span class="d-none d-md-inline-block">Descrição</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#documentos" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-file-document-outline me-1"></i>
            <span class="d-none d-md-inline-block">Documentos</span>
        </a>
    </li>
</ul>
</div>

                <div class="tab-content tab-veiculo-container">
                    
                    <div class="tab-pane show active" id="info-geral">
                        @include('veiculos._tabs.tab-info-veiculo')
                    </div>

                    <div class="tab-pane" id="descricao">
                        @include('veiculos._tabs.tab-descricao')
                    </div>

                    <div class="tab-pane" id="opcionais">
                        @include('veiculos._tabs.tab-opcionais')
                    </div>

                    <div class="tab-pane" id="valores">
                        @include('veiculos._tabs.tab-valores')
                    </div>

                    <div class="tab-pane" id="documentos">
                        @include('veiculos._tabs.tab-documentos')
                    </div>

                </div> </div> </div> 
                <style>
    /* Define uma altura mínima para evitar que o card "encolha" demais */
    .tab-veiculo-container {
        min-height: 650px; /* Ajuste este valor conforme a sua maior aba */
        transition: min-height 0.3s ease; /* Transição suave opcional */
        padding: 15px 0;
    }

    /* Opcional: Adicionar uma transição de fade suave ao trocar de abas */
    .tab-pane.active {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
            

</div> </div>
@endsection