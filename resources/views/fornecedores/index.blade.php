@extends('layouts.app')

@section('title', 'Fornecedor')

@section('content')

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}");
</script>
@endif

@if (session('error'))
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
                    <li class="breadcrumb-item active">Clientes</li>
                </ol>
            </div>
            <h3 class="page-title">Clientes</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Clientes cadastrados</h4>
                    <div class="dropdown">
                        <a href="{{ route('fornecedores.create')}}" class="btn btn-primary btn-sm">Cadastrar</a>
                        {{-- <a href="{{ route('relatorio-clientes')}}" target="_blank" class="btn btn-danger btn-sm">Relatório</a> --}}
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                
            </div>
        </div>
    </div>
   
</div>



    @endsection
