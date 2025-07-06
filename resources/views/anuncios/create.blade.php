@extends('layouts.app')

@section('title', 'Anuncios')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('anuncios.index') }}">Anúncios</a></li>
                    <li class="breadcrumb-item active">Novo Anúncio</li>
                </ol>
            </div>
            <h3 class="page-title">Novo veículo</h3>
        </div>
    </div>
</div>
<br>
{{-- Form para o cadastrar os usuarios do sistema --}}
<form action="{{ route('anuncios.store') }}" method="POST" enctype="multipart/form-data" id="idFormUser" class="form-horizontal">
    @csrf
    @include('anuncios._partials.cad-anuncio')
</form>

@endsection