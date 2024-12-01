@extends('layouts.app')

@section('title', 'Documentos')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Documentos</li>
                </ol>
            </div>
            <h3 class="page-title">Documentos</h3>
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
                    <h4 class="header-title">Outorgado</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Cadastrar</button>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($procs->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Endereço</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($procs as $doc)
                                <tr>
                                    <td>{{ $doc->nome_outorgado }}</td>
                                    <td>{{ $doc->cpf_outorgado }}</td>
                                    <td>{{ $doc->end_outorgado }}</td>
                                    <td>{{ Carbon\Carbon::parse($doc->create_at)->format('d/m') }}</td>
                                    <td class="table-action">

                                        <a href="#"
                                            class="action-icon"
                                            data-id="{{ $doc->id }}"
                                            onclick="openInfoModal(event)">
                                            <i class="mdi mdi-eye" title="Visualizar"></i>
                                        </a>

                                        <a href="{{ $doc->arquivo_doc }}" class="action-icon" target="blank"> <i
                                                class="mdi mdi-printer" title="Imprimir"></i></a>

                                        <a href="{{ route('documentos.destroy', $doc->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true" title="Excluir"></a>
                                            <a href="#" 
                                            class="action-icon mdi mdi-share-all" 
                                            data-id="{{ $doc->id }}" 
                                            title="Gerar procuração"
                                            onclick="openAddressModal(event)">
                                         </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($procs->total() == 0)
                        <div class="alert alert-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>

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
                    <h4 class="header-title">Testemunha</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Cadastrar</button>

                    </div>
                </div>
                @if ($procs->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Endereço</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($procs as $doc)
                                <tr>
                                    <td>{{ $doc->nome_testemunha }}</td>
                                    <td>{{ $doc->cpf_testemunha }}</td>
                                    <td>{{ $doc->end_testemunha }}</td>
                                    <td>{{ Carbon\Carbon::parse($doc->create_at)->format('d/m') }}</td>
                                    <td class="table-action">

                                        <a href="#"
                                            class="action-icon"
                                            data-id="{{ $doc->id }}"
                                            onclick="openInfoModal(event)">
                                            <i class="mdi mdi-eye" title="Visualizar"></i>
                                        </a>

                                        <a href="{{ $doc->arquivo_doc }}" class="action-icon" target="blank"> <i
                                                class="mdi mdi-printer" title="Imprimir"></i></a>

                                        <a href="{{ route('documentos.destroy', $doc->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true" title="Excluir"></a>
                                            <a href="#" 
                                            class="action-icon mdi mdi-share-all" 
                                            data-id="{{ $doc->id }}" 
                                            title="Gerar procuração"
                                            onclick="openAddressModal(event)">
                                         </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($procs->total() == 0)
                        <div class="alert alert-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>

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
                    <h4 class="header-title">Fins e Poderes</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Cadastrar</button>

                    </div>
                </div>
                @if ($procs->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Texto</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($procs as $doc)
                                <tr>
                                    <td>{{ $doc->texto_poderes }}</td>
                                    <td>{{ Carbon\Carbon::parse($doc->create_at)->format('d/m') }}</td>
                                    <td class="table-action">

                                        <a href="#"
                                            class="action-icon"
                                            data-id="{{ $doc->id }}"
                                            onclick="openInfoModal(event)">
                                            <i class="mdi mdi-eye" title="Visualizar"></i>
                                        </a>

                                        <a href="{{ $doc->arquivo_doc }}" class="action-icon" target="blank"> <i
                                                class="mdi mdi-printer" title="Imprimir"></i></a>

                                        <a href="{{ route('documentos.destroy', $doc->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true" title="Excluir"></a>
                                            <a href="#" 
                                            class="action-icon mdi mdi-share-all" 
                                            data-id="{{ $doc->id }}" 
                                            title="Gerar procuração"
                                            onclick="openAddressModal(event)">
                                         </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($procs->total() == 0)
                        <div class="alert alert-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>


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
                    <h4 class="header-title">Texto final</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Cadastrar</button>

                    </div>
                </div>
                @if ($procs->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Texto</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($procs as $doc)
                                <tr>
                                    <td>{{ $doc->texto_final }}</td>
                                    <td>{{ Carbon\Carbon::parse($doc->create_at)->format('d/m') }}</td>
                                    <td class="table-action">

                                        <a href="#"
                                            class="action-icon"
                                            data-id="{{ $doc->id }}"
                                            onclick="openInfoModal(event)">
                                            <i class="mdi mdi-eye" title="Visualizar"></i>
                                        </a>

                                        <a href="{{ $doc->arquivo_doc }}" class="action-icon" target="blank"> <i
                                                class="mdi mdi-printer" title="Imprimir"></i></a>

                                        <a href="{{ route('documentos.destroy', $doc->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true" title="Excluir"></a>
                                            <a href="#" 
                                            class="action-icon mdi mdi-share-all" 
                                            data-id="{{ $doc->id }}" 
                                            title="Gerar procuração"
                                            onclick="openAddressModal(event)">
                                         </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($procs->total() == 0)
                        <div class="alert alert-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>


<!-- Standard modal -->
<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Novo documento</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                @include('documentos.create')
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal para Digitar o Endereço -->
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Digite o Endereço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addressForm">
                    
                    <div class="form-group">
                        <label for="inputAddress">Endereço</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Digite o endereço aqui" required>
                    </div>
                    <input type="hidden" id="docId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submitAddress()">Gerar Procuração</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Visualizar Informações -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Informações do Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aqui as informações vão ser carregadas dinamicamente -->
                <p><strong>Marca:</strong> <span id="marca"></span></p>
                <p><strong>Placa:</strong> <span id="placa"></span></p>
                <p><strong>Chassi:</strong> <span id="chassi"></span></p>
                <p><strong>Cor:</strong> <span id="cor"></span></p>
                <p><strong>Ano:</strong> <span id="ano"></span></p>
                <p><strong>Renavam:</strong> <span id="renavam"></span></p>
                <p><strong>Nome:</strong> <span id="nome"></span></p>
                <p><strong>CPF:</strong> <span id="cpf"></span></p>
                <p><strong>Cidade:</strong> <span id="cidade"></span></p>
                <p><strong>CRV:</strong> <span id="crv"></span></p>
                <p><strong>Placa Anterior:</strong> <span id="placa_anterior"></span></p>
                <p><strong>Categoria:</strong> <span id="categoria"></span></p>
                <p><strong>Motor:</strong> <span id="motor"></span></p>
                <p><strong>Combustível:</strong> <span id="combustivel"></span></p>
                <p><strong>Observações do veículo:</strong> <span id="infos"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<script>

    function openAddressModal(event) {
    event.preventDefault(); // Evita o comportamento padrão do link

    // Obtém o ID do documento do atributo data-id
    const docId = event.target.getAttribute('data-id');
 
    // Define o ID do documento no campo oculto do formulário
    document.getElementById('docId').value = docId;

    // Abre o modal
    $('#addressModal').modal('show');
}


function openInfoModal(event) {
    event.preventDefault(); // Impede o comportamento padrão do link

    // Obtém o ID do documento do atributo 'data-id'
    //const docId = event.currentTarget.getAttribute('data-id');
    const docId = event.target.closest('a').getAttribute('data-id');
    //const url = `/documentos/gerarProc/${docId}/${encodeURIComponent(address)}`;
    //console.log("ID do Documento:", docId);  // Verifique se o ID está correto no console
    //console.log("ID do Documento:", docId);

    // Faz uma requisição AJAX para buscar as informações do documento
    $.ajax({
        url: `/documentos/${docId}`, // Substitua com a URL para pegar as informações do documento
        method: 'GET',
        success: function(response) {
            //console.log("Resposta do Servidor:", response);

            //console.log(response); // Verifique o que está retornando na resposta
            // Preenche o modal com as informações
            $('#marca').text(response.marca);
            $('#placa').text(response.placa);
            $('#chassi').text(response.chassi);
            $('#cor').text(response.cor);
            $('#ano').text(response.ano);
            $('#renavam').text(response.renavam);
            $('#nome').text(response.nome);
            $('#cpf').text(response.cpf);
            $('#cidade').text(response.cidade);
            $('#crv').text(response.crv);
            $('#placa_anterior').text(response.placaAnterior);
            $('#categoria').text(response.categoria);
            $('#motor').text(response.motor);
            $('#combustivel').text(response.combustivel);
            $('#infos').text(response.infos);

            // Exibe o modal
            $('#infoModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error("Erro ao carregar as informações:", error); // Para depuração
            alert('Erro ao carregar as informações.');
        }
    });
}


function submitAddress() {
    const address = document.getElementById('inputAddress').value;
    const docId = document.getElementById('docId').value;

    if (!address) {
        alert('Por favor, preencha o endereço.');
        return;
    }

    // Redireciona para a rota com os parâmetros
    const url = `/documentos/gerarProc/${docId}/${encodeURIComponent(address)}`;
    window.location.href = url;
}

</script>

    @endsection
