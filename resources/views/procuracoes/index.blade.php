@extends('layouts.app')

@section('title', 'Procurações')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Procurações</li>
                </ol>
            </div>
            <h3 class="page-title">Procurações</h3>
        </div>
    </div>
</div>
<br>
{{-- <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('clientes.index') }}" method="GET">
                    <div class="filter-select-container">
                        <select class="select2 form-control select2" name="cliente[]" id="idCliente" data-toggle="select2">
                            <option value="" selected>Cliente</option>
                            @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->nome }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                        
                            <input type="text" class="form-control" id="" data-toggle="date-picker" data-single-date-picker="true" placeholder="Date and Time">
                         
                    </div>
            </div>

            <div class="col-md-6 text-end">
                <button type="submit" class="filter-btn btn-light">Filtrar</button>
            </div>
            </form>
        </div>
    </div>
</div> --}}
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
                    <h4 class="header-title">Procurações cadastradas</h4>
                    <div class="dropdown">
                        <a href="{{ route('procuracoes.create')}}" class="btn btn-primary btn-sm">Cadastro manual</a>
                        <a href="{{ route('relatorio-procuracoes')}}" target="_blank" class="btn btn-danger btn-sm">Relatório</a>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($procs->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Veículo</th>
                                <th>Placa</th>
                                <th>Ano/Modelo</th>
                                <th>Renavam</th>
                                <th>Gerado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($procs as $doc)
                                <tr>
                                    <td>{{ $doc->nome }}</td>
                                    <td>{{ $doc->cpf }}</td>
                                    <td>{{ $doc->marca }}</td>
                                    <td>{{ $doc->placa }}</td>
                                    <td>{{ $doc->ano }}</td>
                                    <td>{{ $doc->renavam }}</td>
                                    <td>{{ Carbon\Carbon::parse($doc->created_at)->format('d/m/Y') }}</td>
                                    <td class="table-action">
                                                <a href="{{ $doc->arquivo_doc }}" class="action-icon" target="blank">
                                                    <i class="mdi mdi-printer"></i>
                                                </a>
                                                
                                        <a href="{{ route('procuracoes.destroy', $doc->id) }}"
                                            class="action-icon mdi mdi-delete text-danger" data-confirm-delete="true"></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($procs->total() == 0)
                        <div class="alert alert-warning bg-transparent text-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        {{ $procs->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
    </div>
    <!-- Single Select -->

    
    

    
   
    


                                                

</div>
<div class="modal fade" id="modalID" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar procuração</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('procuracoes.store') }}" method="POST" enctype="multipart/form-data" id="formProc">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Cliente: <span style="color: red;">*</span></label>
                                {{-- <input class="form-control" type="text" name="endereco" id="idEndereco"> --}}
                                {{-- <select id="select-timezone" class="form-control select2" data-toggle="select2"> --}}
                                    {{-- <select id="select-timezone" class="form-control select2" data-toggle="select2" style="width: 100%;"> --}}
                                        <select class="select2 form-control select2-multiple" name="cliente[]" id="idCliente" data-toggle="select2" multiple="multiple" >
                                        <option value="">Selecione um cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->endereco }}">{{ $cliente->nome }}</option>
                                        @endforeach
                                    </select>
                                    
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="inputAddress">Documento: <span style="color: red;">*</span></label>
                                <div class="col-lg">
                                    <input class="form-control" type="file" name="arquivo_doc" id="arquivo_doc">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    
  $(document).ready(function() {
    $('#select-timezone').select2({
        placeholder: "Digite para buscar clientes",
        allowClear: true,
        ajax: {
            url: '/buscar-clientes',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term // Termo digitado
                };
            },
            processResults: function(data) {
                return {
                    results: data // [{id: '1', text: 'Cliente 1'}, {id: '2', text: 'Cliente 2'}]
                };
            },
            cache: true
        }
    });
});


</script>
<script>




    // Obtenha o formulário
    const form = document.getElementById('formProc');

    // Obtenha os inputs do arquivo e do endereço
    const arquivoInput = document.getElementById('arquivo_doc');
    const cliente = document.getElementById('idCliente');
    
    // Adicionando um evento de submit para o formulário
    form.addEventListener('submit', function(event) {
        // Impede o comportamento padrão do formulário
        event.preventDefault();

        // Verifica se o endereço foi preenchido
         const endereco = cliente.value.trim();
         if (!endereco) {
             Swal.fire({
                 title: 'Erro!',
                 text: 'Por favor, selecione o cliente.',
                 icon: 'error',
                 confirmButtonText: 'OK'
             });
             return;  // Impede o envio do formulário
         }
        
        // Obtém o arquivo
        const arquivo = arquivoInput.files[0]; 

        // Verifica se o arquivo foi selecionado
        if (!arquivo) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, selecione um arquivo.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;  // Impede o envio do formulário
        }

        

        // Se o arquivo e o endereço estiverem presentes, envie o formulário
        form.submit();
    });

    



</script>

    @endsection
