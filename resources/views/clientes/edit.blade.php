@extends('layouts.app')

@section('title', 'Editar cliente')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
            <h3 class="page-title">{{ $cliente->name }}</h3>
        </div>
    </div>
</div>
<br>

@include('includes/validations-form')

<form action="{{ route('clientes.update', $cliente->id) }}" method="POST" enctype="multipart/form-data" id="edit-user-form">
    @csrf
    @method('PUT')
    @include('clientes._partials.form-edit-cliente')
</form>


@endsection