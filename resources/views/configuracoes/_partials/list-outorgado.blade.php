<div class="card">
    <div class="card-body">
        <div class="row">
            @if ($outs->total() != 0)
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Outorgado</h4>
                    <div class="dropdown">
                        @if ($outs->total() < 3)
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalCadastroOut">Cadastrar</button> 
                        @endif
                    </div>
                </div>
                
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Endereço</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($outs as $out)
                                <tr>
                                    <td>{{ $out->nome_outorgado }}</td>
                                    <td>{{ $out->cpf_outorgado }}</td>
                                    <td>{{ $out->end_outorgado }}</td>
                                    <td class="table-action">

                                        <a href="#" class="action-icon" data-id="{{ $out->id }}" onclick="openEditModalOutorgado(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>
                                        </a>
                                        <a href="{{ route('outorgados.destroy', $out->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($outs->total() == 0)
                    <div class="col-sm-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Outorgado</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalCadastroOut">Cadastrar</button>
                    </div>
                        </div>
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    </div>
                        
                    @endif
                
            </div>
        </div>
    </div>
</div>