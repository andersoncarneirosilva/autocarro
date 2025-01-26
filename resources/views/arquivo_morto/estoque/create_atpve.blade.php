@extends('layouts.app')

@section('title', 'Veículos')

@section('content')



<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Veículos</a></li>
                    <li class="breadcrumb-item active">Novo Veículo</li>
                </ol>
            </div>
            <h3 class="page-title">Cadastrar Veículo</h3>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger bg-transparent text-danger" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Atenção - </strong>Todos os campos são obrigatórios.
    </div>
@endif

{{-- Form para o cadastrar os clientes do sistema --}}
<form action="{{ route('estoque.store_atpve', ['id' => request()->query('id')]) }}" id="form-cadastro" method="POST" enctype="multipart/form-data">
    @csrf
    @include('estoque._partials.form-cad-atpve')
</form>



@endsection