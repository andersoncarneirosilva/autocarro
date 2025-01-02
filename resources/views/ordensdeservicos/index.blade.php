@extends('layouts.app')

@section('title', 'Ordens de serviços')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Ordens de serviços</li>
                </ol>
            </div>
            <h3 class="page-title">Ordens de serviços</h3>
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
                    <h4 class="header-title">Ordens cadastradas</h4>
                    <div class="dropdown">
                        <a href="{{ route('ordensdeservicos.create')}}" class="btn btn-primary btn-sm">Cadastrar Ordem</a>
                        <a href="{{ route('relatorio-ordens')}}" target="_blank" class="btn btn-danger btn-sm">Relatório</a>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($ordens->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Serviços</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Gerado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ordens as $orden)
                                <tr>
                                    <td><a href="{{ route('ordensdeservicos.show', $orden->id) }}"
                                            class="">{{ $orden->id }}
                                        </a>
                                    </td>
                                    <td>{{ $orden->cliente->nome }}</td>
                                    <td>
                                        @if(is_array($orden->tipo_servico))
                                            {{ implode(' / ', $orden->tipo_servico) }}
                                        @else
                                            {{ $orden->tipo_servico }}
                                        @endif
                                    </td>
                                    
                                    <td>R$ {{ number_format($orden->valor_total, 2, ',', '.') }}</td>
                                    <td><span class="{{ $orden->classe_status }}">{{ $orden->status }}</span></td>

                                    <td>{{ Carbon\Carbon::parse($orden->created_at)->format('d/m/Y') }}</td>
                                    <td class="table-action">
                                        <a href="{{ route('ordensdeservicos.show', $orden->id) }}" class="action-icon">
                                            <i class="mdi mdi-eye" title="Visualizar"></i>
                                        </a>
                                        <a href="{{ route('rel-ordem', $orden->id) }}" class="action-icon" target="_blank"/>
                                            <i class="mdi mdi-printer"></i>
                                        </a>
                                                
                                        <a href="{{ route('ordensdeservicos.destroy', $orden->id) }}"
                                            class="action-icon mdi mdi-delete text-danger" data-confirm-delete="true"></a>

                                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" style="">
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                                </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($ordens->total() == 0)
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        {{ $ordens->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
    </div>
    <!-- Single Select -->

    {{-- <form action="{{ url('upload-image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="image">Escolha uma imagem (JPG, PNG):</label>
        <input type="file" name="image" id="image" required>
        <button type="submit">Enviar</button>
    </form> --}}
       
    
    
    
   
    


                                                

</div>

    @endsection
