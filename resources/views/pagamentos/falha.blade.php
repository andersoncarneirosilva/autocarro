@extends('layouts.app')

@section('title', 'Proconline')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <h3 class="page-title">Dashboard</h3>
        </div>
    </div>
</div>
<br>

<div class="row">
    <div class="col-sm-12">
        <div class="text-center">
            <h3 class="">Ocorreu um erro no seu pagamento!</h3>
            <p class="text-muted mt-3">Infelizmente, não conseguimos processar o pagamento. Tente novamente ou entre em contato com o suporte.</p>

            <a href="{{ route('dashboard.index') }}" class="btn btn-success btn-sm mt-2">
                <i class="mdi mdi-view-dashboard-outline me-1"></i> Ir para Dashboard
            </a>
        </div>
    </div><!-- end col -->
</div>


@endsection