@extends('layouts.app')

@section('title', 'Editar fornecedor')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Fornecedores</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
            <h3 class="page-title">{{ $forne->name }}</h3>
        </div>
    </div>
</div>
<br>

@include('includes/validations-form')

<form action="{{ route('fornecedores.update', $forne->id) }}" method="POST" enctype="multipart/form-data" id="edit-user-form">
    @csrf
    @method('PUT')
    @include('fornecedores._partials.form-edit-fornecedores')
</form>


@endsection