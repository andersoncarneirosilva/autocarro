@extends('layouts.app')

@section('title', 'Veículos')

@section('content')

@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

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
            <h3 class="page-title">Veículos 
                {{-- <button type="button" 
                    class="btn btn-warning btn-sm opacity-75 text-dark" 
                    data-bs-toggle="modal" 
                    data-bs-target="#dicas">
                    <i class="mdi mdi-lightbulb-on-outline"></i>
                </button> --}}
            </h3>
        </div>
    </div>
</div>

{{-- <div id="dicas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Dica</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <h5>Gerando uma procuração</h5>
                <li>Clique no botão cadastrar e selecione o cadastro automático.</li>
                <li>Insira o endereço do outorgado e o documento em pdf.</li>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal --> --}}
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Veículos cadastrados</h4>
                    <div class="dropdown">
                        @php
                            $isPremium = auth()->user()->plano == "Premium";
                            $isBasicOrIntermediate = in_array(auth()->user()->plano, ["Padrão", "Pro", "Teste"]);
                            $isButtonDisabled = ($isPremium && $percentUsed > 1000) || 
                                                ($isBasicOrIntermediate && (auth()->user()->credito < 1 || $percentUsed > 100));
                        @endphp

                        <div class="dropdown btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" 
                                    type="button" 
                                    data-bs-toggle="dropdown" 
                                    aria-haspopup="true" 
                                    aria-expanded="false" 
                                    @if($isButtonDisabled) disabled @endif>
                                Cadastrar
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#standard-modal" class="dropdown-item">
                                    Cadastro automático
                                </a>
                                <a href="{{ route('veiculos.create-proc-manual') }}" class="dropdown-item">
                                    Cadastro manual
                                </a>
                            </div>
                        </div>

                        {{-- @if(auth()->user()->plano == "Premium")
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
                        @endif --}}

                    </div>
                </div>
                @if ($veiculos->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Ver</th>
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
                                    <td><a href="{{ route('veiculos.show', $doc->id) }}" title="Visualizar" style="text-decoration: none;" class="">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </td>
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

                                                {{-- <a href="{{ $doc->arquivo_doc }}" 
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
                                                "v=DMARC1; p=reject; sp=reject; adkim=s; aspf=s;"
                                                 --}}
                                                
                                                <a href="{{ $doc->arquivo_proc }}" 
                                                    class="dropdown-item"
                                                    target="_blank">
                                                    Baixar Procuração
                                                </a>
                                                <a href="{{ $doc->arquivo_atpve ?? '#' }}" 
                                                    class="dropdown-item {{ empty($doc->arquivo_atpve) ? 'disabled' : '' }}" 
                                                    target="_blank">
                                                     Baixar ATPVe
                                                 </a>
                                                 
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item"
                                                    onclick="openProcModal(event, {{ $doc->id }})">
                                                    Gerar procuração
                                                </a>

                                                <a href="javascript:void(0);"
                                                    class="dropdown-item {{ $doc->crv === '***' ? 'disabled' : '' }}"
                                                    onclick="{{ $doc->crv === '***' ? 'return false;' : "openAddressModal(event, $doc->id)" }}">
                                                    Gerar Solicitação ATPVe
                                                </a>

                                                <!-- Formulário Oculto para Arquivar -->
                                                <form action="{{ route('veiculos.arquivar', $doc->id) }}" method="POST" style="display: none;" id="form-arquivar-{{ $doc->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                </form>

                                                <!-- Link para Arquivar com SweetAlert -->
                                                <a href="#" onclick="confirmArchive({{ $doc->id }});" class="dropdown-item">
                                                    Arquivar
                                                </a>

                                                <!-- SweetAlert2 -->
                                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                                                <script>
                                                    function confirmArchive(id) {
                                                        Swal.fire({
                                                            title: "Arquivar Veículo",
                                                            text: "Tem certeza que deseja arquivar este veículo?",
                                                            icon: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonText: "Sim, arquivar!",
                                                            cancelButtonText: "Cancelar"
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                document.getElementById('form-arquivar-' + id).submit();
                                                            }
                                                        });
                                                    }
                                                </script>

                                                

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
                    @if(!$modeloProc) 
                        <div class="alert alert-light text-bg-light border-0" role="alert">
                            Acesse a página <a href="{{ route('outorgados.index')}}">Outorgados</a> e <a href="{{ route('configuracoes.index')}}">Procuração</a> para configurar o modelo de textos.
                        </div>
                    @endif

            </div>

            <br><br>
            


        </div>
        
        

    </div>
    
    <div class="row">
        <!-- Mensagem de quantidade exibida -->
        <div class="col-sm-12 col-md-5 d-flex align-items-center">
            <p class="mb-0">Exibindo {{ $quantidadePaginaAtual }} de {{ $quantidadeTotal }} veículos cadastrados</p>
        </div>
    
        <!-- Paginação alinhada à direita -->
        <div class="col-sm-12 col-md-7 d-flex justify-content-end align-items-center">
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
                <h4 class="modal-title" id="standard-modalLabel">Novo veículo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                @include('veiculos.create')
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="procModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gerar procuração</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="procForm" method="POST">
                    @csrf <!-- Necessário para o Laravel validar a requisição -->
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Endereço: <span style="color: red;">*</span></label>
                            <div class="col-lg">
                                <input class="form-control" type="text" name="endereco" required>
                            </div>
                        </div>
                    </div>
                    <br>

                    <input type="hidden" id="docId" name="docId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="submitProc()">Gerar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Gerar solicitação ATPVe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="addressForm" method="POST" class="needs-validation" novalidate>
                    @csrf <!-- Necessário para o Laravel validar a requisição -->
                    <div class="form-group">
                        <label for="outorgado">Selecione o outorgado: <span style="color: red;">*</span></label>
                        <select id="outorgado" name="outorgado" class="form-control" placeholder="Selecione o outorgado">
                            <option value="">Selecione o outorgado</option>
                            @foreach ($outorgados as $outorgado)
                            <option value="{{ $outorgado->id }}" data-nome="{{ $outorgado->nome_outorgado }}" data-cpf="{{ $outorgado->cpf_outorgado }}" data-email="{{ $outorgado->email_outorgado }}">
                                {{ $outorgado->nome_outorgado }}
                            </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="nome_outorgado" name="nome_outorgado" value="">
                        <input type="hidden" id="email_outorgado" name="email_outorgado" value="">
                        <input type="hidden" id="cpf_outorgado" name="cpf_outorgado" value="">
                        <script>
                            document.getElementById('outorgado').addEventListener('change', function () {
                                const selectedOption = this.options[this.selectedIndex];
                                document.getElementById('nome_outorgado').value = selectedOption.getAttribute('data-nome') || '';
                                document.getElementById('email_outorgado').value = selectedOption.getAttribute('data-email') || '';
                                document.getElementById('cpf_outorgado').value = selectedOption.getAttribute('data-cpf') || '';
                            });
                        </script>

                    </div>
                    <br>
                    <div class="form-group">
                        <label for="idCliente">Selecione o cliente: <span style="color: red;">*</span></label>
                        <select id="idCliente" name="cliente[]" class="form-control" placeholder="Selecione o cliente">
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
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            <input type="text" class="form-control" id="valor" name="valor" placeholder="Insira o valor" required>
                        </div>
                        
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

    function openProcModal(event, docId) {
        // Armazena o ID do documento globalmente
        window.selectedDocId = docId;
    
        // Atualiza o campo oculto no formulário com o ID do documento
        document.getElementById('docId').value = docId;
    
        // Exibe o modal
        $('#procModal').modal('show');
    }

    function submitProc() {
    
        const docId = window.selectedDocId;
        //console.log(docId);
        // Atualiza a ação do formulário para incluir o ID do documento na rota
        const form = document.getElementById('procForm');
        form.action = `{{ url('veiculos/store-proc') }}/${docId}`; //secure_url
    
        // Envia o formulário
        form.submit();
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
        form.action = `{{ url('veiculos/store-atpve') }}/${docId}`; //secure_url
    
        // Envia o formulário
        form.submit();
    }
</script>

    

@endsection