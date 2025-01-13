@extends('layouts.app')

@section('title', 'Veículos')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Estoque</li>
                </ol>
            </div>
            <h3 class="page-title">Estoque</h3>
        </div>
    </div>
</div>
<br>

@include('estoque._partials.listar-estoque')


@include('estoque._partials.modal-gerar-atpve')

@include('estoque._partials.visualizar-doc')

@endsection
