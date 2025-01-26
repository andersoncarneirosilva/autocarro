@extends('layouts.app')

@section('title', 'Emprestimos')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <form action="{{ route('users.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" placeholder="Pesquisar" class="form-control">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>    
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3 text-end">
            <a href="{{ route('emprestimos.create') }}" class="btn btn-success ">Cadastrar</a>
           <!-- <a href="#" class="btn btn-danger" id="deleteAllSelectedRecord">Excluir</a> -->
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-12">
        <H1>Parcelas</H1>
       
<table class="table table-striped">
    <thead>
        <tr>
            <th>Parcela</th>
            <th>Valor da parcela</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    
    <tbody>
        @php
            $conta = 1;
        @endphp
        @foreach ($data as $dat)
        <tr>
            <td>{{ $conta }}</td>
            <td>R${{ $dat->parcela }}</td>
            <td><span class="{{ $dat->class_status }}">{{ $dat->status }}</span></td>
            <td class="table-action">
                <a href="#" class="action-icon"> <i class="fa-solid fa-check"></i></a>
                <a href="{{ route('parcelas.destroy', $dat->id) }}" class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>
            </td>
        </tr>
        @php
            $conta++;
        @endphp
        @endforeach
        
    </tbody>
    
</table>
@endsection