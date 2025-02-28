<div class="card">
    <div class="card-body">
        <div class="row">
            @if ($cidades->total() != 0)
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Cidade da procuração</h4>
                    <div class="dropdown">
                        @if ($cidades->total() < 1)
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalCadastroCidade">Cadastrar</button>
                        @endif

                    </div>
                </div>
                
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Cidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($cidades as $cidade)
                                <tr>
                                    <td >{{ $cidade->cidade }}</td>
                                    <td >

                                        <a href="#" class="action-icon" data-id="{{ $cidade->id }}" onclick="openEditCidadeModal(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>
                                        </a>
                                        {{-- <a href="{{ route('cidades.destroy', $cidade->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true"></a> --}}

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($cidades->total() == 0)
                <div class="col-sm-12">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Cidade da procuração</h4>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalCadastroCidade">Cadastrar</button>
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