@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuários</a></li>
                    <li class="breadcrumb-item active">Novo usuário</li>
                </ol>
            </div>
            {{-- <h3 class="page-title">{{ $user->name }}</h3> --}}
        </div>
    </div>
</div>
<br>
{{-- Form para o cadastrar os usuarios do sistema --}}
<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="idFormUser" class="form-horizontal">
    @csrf
    @include('users._partials.form-cad-user')
</form>

@endsection