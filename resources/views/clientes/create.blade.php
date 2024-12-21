@extends('layouts.app')

@section('title', 'Usuários')

@section('content')



<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active">Novo Cliente</li>
                </ol>
            </div>
            {{-- <h3 class="page-title">{{ $user->name }}</h3> --}}
        </div>
    </div>
</div>
<br>
{{-- Form para o cadastrar os clientes do sistema --}}
<form action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('clientes._partials.form-cad-cliente')
</form>

@endsection