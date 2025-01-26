@extends('layouts.app')

@section('title', 'Fornecedores')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Fornecedores</li>
                </ol>
            </div>
            <h3 class="page-title">Fornecedores</h3>
        </div>
    </div>
</div>
<br>

<div class="card">
    <div class="card-body">
        <!-- resources/views/resultado.blade.php -->
        <h1>Texto Extraído da Imagem</h1>
        <p>{{ $text }}</p>
        <a href="{{ route('ocr.form') }}">Voltar</a>

    </div>
</div>
    @endsection
