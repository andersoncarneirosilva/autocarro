@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('servicos.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Relatórios</li>
                </ol>
            </div>
            <h3 class="page-title">Relatórios</h3>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
       
        <form id="formRel" action="{{ route('relatorio.gerar') }}" method="POST">
            @csrf
            <div class="row align-items-end gy-3">
                <div class="col-sm-3">
                    <label for="tipo-relatorio" class="form-label">Tipo de relatório</label>
                    <select class="form-select" id="tipo-relatorio" name="tipo-relatorio" required>
                        <option value="" selected>-- Selecione o tipo --</option>
                        <option value="Clientes">Clientes</option>
                        <option value="Procurações">Procurações</option>
                        <option value="Veículos">Veículos</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="data-inicial" class="form-label">Data Inicial</label>
                    <input class="form-control" id="data-inicial" name="data-inicial" type="date" required>
                </div>
                <div class="col-sm-3">
                    <label for="data-final" class="form-label">Data Final</label>
                    <input class="form-control" id="data-final" name="data-final" type="date" required>
                </div>
                <div class="col-sm-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
                </div>
            </div>
        </form>
        
    </div>
</div>



    @endsection
