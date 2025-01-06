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
            @if ($texts_starts->total() != 0)
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Texto Inicial</h4>
                    <div class="dropdown">
                        @if ($texts_starts->total() <= 1)
                            <button type="button" class="btn btn-primary btn-sm" onclick="verificarLimiteTexto()">Cadastrar</button>
                        @else
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCadTextoInicial">Cadastrar</button>
                        @endif
                    </div>
                </div>
        
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Texto</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
        
                        <tbody>
                            @foreach ($texts_starts as $texts_start)
                                <tr>
                                    <td>{{ $texts_start->texto_inicio }}</td> <!-- Exibe o texto renderizado -->
                                    <td>
                                        <a href="#" class="action-icon" data-id="{{ $texts_start->id }}" onclick="openEditTextoInicial(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>
                                        </a>
                                        <a href="{{ route('textoinicial.destroy', $texts_start->id) }}" class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                {{ $texts->links() }}
            </div>
            @else
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Texto</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCadTextoInicial">Cadastrar</button>
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