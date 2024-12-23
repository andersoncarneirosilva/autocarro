@extends('layouts.app')

@section('title', 'Clientes')

@section('content')



<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Novo Cliente</li>
                </ol>
            </div>
            <h3 class="page-title">Cadastrar cliente</h3>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Atenção - </strong>Todos os campos são obrigatórios.
    </div>
@endif

{{-- Form para o cadastrar os clientes do sistema --}}
<form action="{{ route('clientes.store') }}" id="form-cadastro" method="POST" enctype="multipart/form-data">
    @csrf
    @include('clientes._partials.form-cad-cliente')
</form>



@endsection