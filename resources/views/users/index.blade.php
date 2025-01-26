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
        <div class="row">
            {{-- @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach
                </ul>
            @endif --}}
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Usuários cadastradas</h4>
                    <div class="dropdown">
                        @can('access-admin') 
                    <a href="{{ route('users.create')}}" class="btn btn-primary btn-sm">Cadastrar</a>
                    @endcan
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($users->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>Nícel de acesso</th>
                                <th>Perfil</th>
                                <th>Plano</th>
                                <th>Status</th>
                                <th>Crédito</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($users as $user)
                            <tr data-user-id="{{ $user->id }}">
                                <td class="table-user">
                                    @if($user->image)
                                        <img src="{{ url("storage/{$user->image}") }}" class="me-2 rounded-circle">
                                    @else
                                    <img src="{{ url("assets/img/icon_user.png") }}" class="me-2 rounded-circle">
                                    @endif
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->telefone }}</td>
                                <td>{{ $user->nivel_acesso }}</td>
                                <td>{{ $user->perfil }}</td>
                                <td>{{ $user->plano }}</td>
                                <td><span class="{{ $user->classe }}">{{ $user->status }}</span></td>
                                <td>R${{ $user->credito }},00</td>
                                <td class="table-action">
                                    
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-target="#standard-modal-edit"
                                        class="font-18 text-secondary me-2"
                                        data-bs-placement="top"
                                        aria-label="Edit"
                                        data-bs-original-title="Editar"><i class="uil uil-pen"></i></a>
                                       
                                    <a href="{{ route('users.destroy', $user->id) }}"
                                        class="mdi mdi-delete font-18 text-danger" 
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        aria-label="Delete"
                                        data-bs-original-title="Excluír" data-confirm-delete="true"></a>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($users->total() == 0)
                        <div class="alert alert-warning bg-transparent text-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <br>
    
    </div>
</div>
<br>


@endsection