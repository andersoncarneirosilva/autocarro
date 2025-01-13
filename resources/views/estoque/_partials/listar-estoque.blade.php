<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Controle de Estoque</h4>
                    <div class="dropdown">
                        @if(auth()->user()->credito > 0)
                        <a href="{{ route('estoque.create')}}" class="btn btn-primary btn-sm">Cadastrar</a>
                            @endif
                            <a href="{{ route('relatorio-veiculos') }}" target="_blank" class="btn btn-danger btn-sm">Relatório</a>
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
                                <th>CRV</th>
                                <th>CRLV</th>
                                <th>Procuração</th>
                                <th>ATPVe</th>
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
                                    <td>{{ $doc->crv }}</td>
                                    <td><a href="{{ $doc->arquivo_doc }}" target="blank">{{ $doc->placa }}</a>
                                    <td><a href="{{ $doc->arquivo_proc }}" target="blank">PROC</a>
                                    <td>
                                        @if(!empty($doc->arquivo_atpve))
                                            <a href="{{ $doc->arquivo_atpve }}" target="_blank">ATPVe</a>
                                        @else
                                            <!-- Mostre uma mensagem ou deixe em branco -->
                                            <span>Sem ATPVe</span>
                                        @endif
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($doc->created_at)->format('d/m') }}</td>
                                    <td class="table-action">
                                        <div class="dropdown btn-group">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Ações
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">
                                                <a href="javascript:void(0);" 
                                                class="dropdown-item">
                                                Visualizar
                                                </a>
                                                <a href="{{ $doc->arquivo_doc }}" 
                                                class="dropdown-item"
                                                target="_blank">
                                                CRLV
                                                </a>
                                                <a href="{{ $doc->arquivo_proc }}" 
                                                class="dropdown-item"
                                                target="_blank">
                                                Procuração
                                                </a>
                                                <a href="{{ route('estoque.create-atpve') }}?id={{ $doc->id }}" 
                                                    class="dropdown-item {{ !empty($doc->arquivo_atpve) ? 'disabled' : '' }}"
                                                    {{ !empty($doc->arquivo_atpve) ? 'aria-disabled=true' : '' }}>
                                                    Gerar APTVe
                                                 </a>
                                                 
                                                <a href="{{ route('estoque.destroy', $doc->id) }}" 
                                                data-confirm-delete="true"
                                                class="dropdown-item">
                                                Excluir
                                                </a>
                                            </div>
                                        </div>

                                        {{-- <a href="#"
                                            class="action-icon"
                                            data-id="{{ $doc->id }}"
                                            onclick="openInfoModal(event)">
                                            <i class="mdi mdi-eye" title="Visualizar"></i>
                                        </a>
                                        @if(auth()->user()->credito > 0)
                                        <a href="{{ $doc->arquivo_doc }}" class="action-icon" target="blank"> <i
                                                class="mdi mdi-printer" title="Imprimir"></i></a>
                                        @endif

                                        @if($doc->crv === "***")
                                        
                                        @else
                                        <a href="#" 
                                        class="action-icon mdi mdi-share-all" 
                                        title="Gerar APTVe"
                                        data-id="{{ $doc->id }}"
                                        onclick="openAddressModal(event, '{{ $doc->id }}')">
                                        </a>
                                        @endif
                                             

                                        <a href="{{ route('estoque.destroy', $doc->id) }}"
                                            class="action-icon mdi mdi-delete text-danger" data-confirm-delete="true" title="Excluir"></a>
                                             --}}

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