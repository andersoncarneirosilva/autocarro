@extends('layouts.app')

@section('title', 'Veículos')

@section('content')


<form action="{{ route('veiculos.store-proc-manual') }}" method="POST" enctype="multipart/form-data" id="formDoc">
    @csrf
    @include('veiculos._partials.form-cad-proc-manual')
</form>



@endsection