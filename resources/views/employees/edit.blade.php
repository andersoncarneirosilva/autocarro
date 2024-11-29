@extends('layouts.app')

@section('title', 'Editar usuário')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Usuários</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
            <h3 class="page-title">{{ $employee->name }}</h3>
        </div>
    </div>
</div>
<br>

@include('includes/validations-form')

<form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('employees._partials.form-edit-employees')
</form>
@endsection