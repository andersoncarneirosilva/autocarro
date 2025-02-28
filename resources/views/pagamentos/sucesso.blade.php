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
            <p class="text-muted mt-3">O crédito foi adicionado a sua conta.</p>

            <a href="{{ route('dashboard.index') }}" class="btn btn-success btn-sm mt-2">
                <i class="mdi mdi-view-dashboard-outline me-1"></i> Ir para Dashboard
            </a>
        </div>
    </div><!-- end col -->
</div>


@endsection