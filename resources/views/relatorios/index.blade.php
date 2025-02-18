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


<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title mb-3">Gerar Relatório</h5>
        <form id="formRel" action="{{ route('relatorio.gerar') }}" method="POST">
            @csrf
            <div class="row row-cols-1 row-cols-md-4 g-3 align-items-end">
                <div class="col">
                    <label for="tipo-relatorio" class="form-label fw-semibold">Tipo de relatório</label>
                    <select class="form-select" id="tipo-relatorio" name="tipo-relatorio" required>
                        <option value="" selected>-- Selecione --</option>
                        <option value="Clientes">Clientes</option>
                        <option value="Veículos">Veículos</option>
                    </select>
                </div>
                <div class="col">
                    <label for="data-inicial" class="form-label fw-semibold">Data Inicial</label>
                    <input class="form-control" id="data-inicial" name="data-inicial" type="date" required>
                </div>
                <div class="col">
                    <label for="data-final" class="form-label fw-semibold">Data Final</label>
                    <input class="form-control" id="data-final" name="data-final" type="date" required>
                </div>
                <div class="col text-md-end text-center mt-2 mt-md-0">
                    <button type="submit" class="btn btn-primary px-4">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>
</div>




    @endsection
