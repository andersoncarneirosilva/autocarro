@extends('layouts.app')

@section('title', 'Editar veículo')

@section('content')
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

@include('includes/validations-form')

<form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST" enctype="multipart/form-data" id="edit-car-form">
    @csrf
    @method('PUT')
    @include('veiculos._partials.form-edit-veiculo')
</form>


@endsection