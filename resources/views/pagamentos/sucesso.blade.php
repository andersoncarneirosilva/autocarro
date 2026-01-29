@extends('layouts.app')

@section('title', 'Proconline')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                </ol>
            </div>
        </div>
    </div>
</div>
<br>

<div class="row">
    <div class="col-sm-12">
        <div class="text-center">
            <h3 class="">Pagamento realizado com sucesso! <i class="mdi mdi-check text-success"></i></h3>
            <p class="text-muted mt-3">Sua assinatura foi confirmada e os recursos do plano já estão liberados.</p>

            <a href="{{ route('dashboard.index') }}" class="btn btn-success btn-sm mt-3 px-4 rounded-pill">
                <i class="mdi mdi-view-dashboard-outline me-1"></i> Ir para o Painel de Controle
            </a>
        </div>
    </div>
</div>


@endsection