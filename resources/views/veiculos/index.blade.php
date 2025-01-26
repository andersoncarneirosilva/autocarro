@extends('layouts.app')

@section('title', 'Veículos')

@section('content')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectElement = document.getElementById('idCliente');
        const choices = new Choices(selectElement, {
            searchEnabled: true, // Ativa a busca
            itemSelectText: '', // Remove o texto de seleção padrão
            removeItemButton: true, // Permite remover itens da seleção
            noResultsText: 'Nenhuma opção encontrada', // Texto ao não encontrar resultados na busca
            noChoicesText: 'Nenhum cliente cadastrado', // Texto quando não há opções
        });
    });
</script>

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Veículos</li>
                </ol>
            </div>
            <h3 class="page-title">Veículos</h3>
        </div>
    </div>
</div>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Veículos cadastrados</h4>
                    <div class="dropdown">
                        
                        @if(auth()->user()->plano == "Premium")
                        <div class="dropdown btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" 
                                    type="button" 
                                    data-bs-toggle="dropdown" 
                                    aria-haspopup="true" 
                                    aria-expanded="false" 
                                    @if($percentUsed > 100) disabled @endif>
                                Cadastrar
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#standard-modal" class="dropdown-item">
                                    Cadastro automático
                                </a>
                            <a href="{{ route('veiculos.create-proc-manual')}}" class="dropdown-item">Cadastro manual</a>
                            </div>
                        </div>
                        @endif
                        @if(auth()->user()->plano == "Básico" || auth()->user()->plano == "Intermediário" || auth()->user()->credito < 0)
                        <div class="dropdown btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" 
                                    type="button" 
                                    data-bs-toggle="dropdown" 
                                    aria-haspopup="true" 
                                    aria-expanded="false" 
                                    @if($percentUsed > 100) disabled @endif>
                                Cadastrar
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#standard-modal" class="dropdown-item">
                                    Cadastro automático
                                </a>
                            <a href="{{ route('veiculos.create-proc-manual')}}" class="dropdown-item">Cadastro manual</a>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
                @if ($veiculos->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Placa</th>
                                <th>Veículo</th>
                                <th>Ano/Modelo</th>
                                <th>DOC</th>
                                <th>Proc. Assinada</th>
                                <th>ATPVe Assinada</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($veiculos as $doc)
                                <tr>
                                    <td>{{ $doc->id }}</td>
                                    <td>{{ $doc->placa }}</td>
                                    <td>{{ $doc->marca }}</td>
                                    <td>{{ $doc->ano }}</td>
                                    <td>
                                        @if($doc->crv === "***")
                                        <span class="badge badge-outline-danger">FÍSICO</span>
                                        @else
                                            <!-- Mostre uma mensagem ou deixe em branco -->
                                            <span class="badge badge-outline-success">DIGITAL</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($doc->arquivo_proc_assinado))
                                            <a href="{{ $doc->arquivo_proc_assinado }}" target="_blank">PROC</a>
                                        @else
                                            <!-- Mostre uma mensagem ou deixe em branco -->
                                            <span>Não consta</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($doc->arquivo_atpve_assinado))
                                            <a href="{{ $doc->arquivo_atpve_assinado }}" target="_blank">ATPVe</a>
                                        @else
                                            <!-- Mostre uma mensagem ou deixe em branco -->
                                            <span>Não consta</span>
                                        @endif
                                    </td>
                                    
                                    <td class="table-action">
                                        <div class="dropdown btn-group">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Ações
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">

                                                <a href="{{ route('veiculos.edit', $doc->id) }}" class="dropdown-item">Editar</a>

                                                <a href="{{ $doc->arquivo_doc }}" 
                                                    class="dropdown-item {{ $doc->arquivo_doc === 'Não consta' ? 'disabled' : '' }}"
                                                    target="_blank">
                                                    Baixar CRLV
                                                </a>
                                                <a href="{{ $doc->arquivo_proc }}" 
                                                    class="dropdown-item"
                                                    target="_blank">
                                                    Baixar Procuração
                                                </a>
                                                @if(!empty($doc->arquivo_atpve))
                                                    <a href="{{ $doc->arquivo_atpve }}" 
                                                    class="dropdown-item" 
                                                    target="_blank">
                                                    Baixar ATPVe
                                                    </a>
                                                @else
                                                    <a href="#" 
                                                    class="dropdown-item disabled" 
                                                    tabindex="-1" 
                                                    aria-disabled="true">
                                                    Baixar ATPVe
                                                    </a>
                                                @endif


                                                <a href="javascript:void(0);"
                                                    class="dropdown-item {{ $doc->crv === '***' ? 'disabled' : '' }}"
                                                    onclick="{{ $doc->crv === '***' ? 'return false;' : "openAddressModal(event, $doc->id)" }}">
                                                    Gerar ATPVe
                                                </a>


                                                <a href="{{ route('veiculos.destroy', $doc->id) }}" 
                                                    data-confirm-delete="true"
                                                    class="dropdown-item">
                                                    Excluir
                                                </a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($veiculos->total() == 0)
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        {{ $veiculos->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
    </div>
                                                

</div>

<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Nova procuração</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                @include('veiculos.create')
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Gerar solicitação ATPVe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="addressForm" method="POST">
                    @csrf <!-- Necessário para o Laravel validar a requisição -->
                    <div class="form-group">
                        <label>Selecione o cliente: <span style="color: red;">*</span></label>
                        <select id="idCliente" name="cliente[]" placeholder="Selecione o cliente">
                            <option value="">Selecione o cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    <br>
                    <!-- Campo adicional para valor -->
                    <div class="form-group">
                        <label for="valor">Valor: <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="valor" name="valor" placeholder="Insira o valor" required>
                    </div>
                    <input type="hidden" id="docId" name="docId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="submitAddress()">Gerar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // Máscara para o campo de valor: formato R$ 1.000,00
        $('#valor').mask('000.000.000.000.000,00', {reverse: true});
    });
</script>
<script>
    function openAddressModal(event, docId) {
        // Armazena o ID do documento globalmente
        window.selectedDocId = docId;
    
        // Atualiza o campo oculto no formulário com o ID do documento
        document.getElementById('docId').value = docId;
    
        // Exibe o modal
        $('#addressModal').modal('show');
    }
    
    function submitAddress() {
        const selectedClient = $('#idCliente').val(); // Corrigido para o id correto do select
    
        if (!selectedClient || selectedClient.length === 0) {
            Swal.fire('Erro', 'Você precisa selecionar um cliente antes de continuar.', 'error');
            return;
        }
    
        const docId = window.selectedDocId;
    
        // Atualiza a ação do formulário para incluir o ID do documento na rota
        const form = document.getElementById('addressForm');
        form.action = `{{ secure_url('veiculos/store-atpve') }}/${docId}`; //secure_url
    
        // Envia o formulário
        form.submit();
    }
</script>

    

@endsection