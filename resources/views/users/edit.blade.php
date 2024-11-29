@extends('layouts.app')

@section('title', 'Editar usuário')

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
            <h3 class="page-title">{{ $user->name }}</h3>
        </div>
    </div>
</div>
<br>

@include('includes/validations-form')

<form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="edit-user-form">
    @csrf
    @method('PUT')
    @include('users._partials.form-edit-user')
</form>


@endsection