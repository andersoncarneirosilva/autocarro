@extends('layouts.app')

@section('title', 'Veículos')

@section('content')

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
            {{-- @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach
                </ul>
            @endif --}}
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Veículos cadastrados</h4>
                    <div class="dropdown">
                        @if(auth()->user()->credito > 0)
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Cadastrar</button>
                            @endif
                            <a href="{{ route('relatorio-veiculos') }}" target="_blank" class="btn btn-danger btn-sm">Relatório</a>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($docs->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Veículo</th>
                                <th>Placa</th>
                                <th>Ano/Modelo</th>
                                <th>Cor</th>
                                <th>Proprietário</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($docs as $doc)
                                <tr>
                                    <td>{{ $doc->id }}</td>
                                    <td>{{ $doc->marca }}</td>
                                    <td>{{ $doc->placa }}</td>
                                    <td>{{ $doc->ano }}</td>
                                    <td>{{ $doc->cor }}</td>
                                    <td>{{ $doc->nome }}</td>
                                    <td>{{ Carbon\Carbon::parse($doc->created_at)->format('d/m') }}</td>
                                    <td class="table-action">

                                        <a href="#"
                                            class="action-icon"
                                            data-id="{{ $doc->id }}"
                                            onclick="openInfoModal(event)">
                                            <i class="mdi mdi-eye" title="Visualizar"></i>
                                        </a>
                                        @if(auth()->user()->credito > 0)
                                        <a href="{{ $doc->arquivo_doc }}" class="action-icon" target="blank"> <i
                                                class="mdi mdi-printer" title="Imprimir"></i></a>

                                                <a href="#" 
                                                class="action-icon mdi mdi-share-all" 
                                                title="Gerar procuração"
                                                data-id="{{ $doc->id }}" 
                                                onclick="openAddressModal(event, '{{ $doc->id }}')">
                                        </a>
                                        @endif
                                             

                                        <a href="{{ route('documentos.destroy', $doc->id) }}"
                                            class="action-icon mdi mdi-delete text-danger" data-confirm-delete="true" title="Excluir"></a>
                                            

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($docs->total() == 0)
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        {{ $docs->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
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

<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Gerar procuração</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="addressForm" method="POST">
                    @csrf <!-- Necessário para o Laravel validar a requisição -->
                    <div class="form-group">
                        <label>Selecione o cliente: <span style="color: red;">*</span></label>
                        <select class="select2 form-control select2-multiple" name="cliente[]" id="inputAddress" data-toggle="select2" multiple="multiple">
                            <option value="">Selecione um cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" id="docId" name="docId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="submitAddress()">Gerar Procuração</button>
            </div>
        </div>
    </div>
</div>

@include('documentos._partials.visualizar-doc')
<!-- Modal para Visualizar Informações -->



<script>
    function openAddressModal(event, docId) {
    // Armazene o ID do documento globalmente ou dentro do modal
    window.selectedDocId = docId;  // Salva o docId globalmente

    $('#addressModal').modal('show');
}

</script>



<script>
 function submitAddress() {
    const selectedClient = $('#inputAddress').val(); // Retorna um array para múltiplos valores

    if (!selectedClient || selectedClient.length === 0) {
        Swal.fire('Erro', 'Você precisa selecionar um cliente antes de continuar.', 'error');
        return;
    }

    // Usando o doc_id armazenado globalmente
    const doc_id = window.selectedDocId;

    console.log('Doc ID:', doc_id);  // Exibe o ID do documento
    console.log('Selected Client:', selectedClient);  // Exibe o ID do cliente

    // Atualiza a rota do formulário com o ID do cliente e o ID do documento
    const form = document.getElementById('addressForm');
    form.action = `{{ url('documentos/gerarProc') }}/${selectedClient}/${doc_id}`;

    // Enviar o formulário
    form.submit();
}

</script>







<script>
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
            alert('Erro ao carregar as informações.');
        }
    });
}
</script>

    @endsection
