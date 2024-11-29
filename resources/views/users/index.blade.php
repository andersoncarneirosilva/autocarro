@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Usuários</li>
                </ol>
            </div>
            <h3 class="page-title">Usuários</h3>
        </div>
    </div>
</div>
<br>

<div class="card">
    <div class="card-body">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="header-title">Lista de usuários</h4>
        <div class="dropdown">
            <a href="{{ route('users.create')}}" class="btn btn-primary btn-sm">Cadastrar</a>
        </div>
    </div>
    @include('users._partials.list-usuarios')
    </div>
</div>
<br>



@endsection