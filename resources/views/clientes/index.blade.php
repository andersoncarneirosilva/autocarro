@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Clientes</li>
                </ol>
            </div>
            <h3 class="page-title">Clientes</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Clientes cadastrados</h4>
                    <div class="dropdown">
                        <a href="{{ route('clientes.create')}}" class="btn btn-primary btn-sm">Cadastrar</a>
                        <a href="{{ route('relatorio-clientes')}}" target="_blank" class="btn btn-danger btn-sm">Relatório</a>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($clientes->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Whatsapp</th>
                                <th>Endereço</th>
                                <th>Cidade</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($clientes as $cli)
                            <?php 
                        $fone = $cli->fone;
                        // Formatar o telefone
                        $fone_formatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2.$3', $fone);
                        // Gerar o link com o número sem formatação
                        $link_whatsapp = "https://wa.me/" . preg_replace('/\D/', '', $fone); 
                        ?>
                                <tr>
                                    <td>{{ $cli->id }}</td>
                                    <td>{{ $cli->nome }}</td>
                                    <td>{{ $cli->cpf }}</td>
                                    <td><a href="<?= $link_whatsapp ?>" target="_blank" style="color: #0b8638;">
                                        <i class="uil uil-whatsapp"></i> <?= $fone_formatado ?>
                                    </a></td>
                                    <td>{{ $cli->endereco }}</td>
                                    <td>{{ $cli->cidade }}</td>
                                    <td>{{ Carbon\Carbon::parse($cli->created_at)->format('d/m') }}</td>
                                    <td class="table-action">

                                        <a href="{{ route('clientes.edit', $cli->id) }}" class="action-icon" data-id="{{ $cli->id }}" onclick="openEditTextModal(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>

                                        <a href="{{ route('clientes.destroy', $cli->id) }}"
                                            class="action-icon mdi mdi-delete text-danger" data-confirm-delete="true" title="Excluir"></a>
                                            
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($clientes->total() == 0)
                        <div class="alert alert-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        {{ $clientes->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
    </div>
</div>



    @endsection
