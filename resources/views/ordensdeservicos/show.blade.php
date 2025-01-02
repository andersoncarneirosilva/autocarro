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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- Invoice Logo-->
                <div class="clearfix">
                    <div class="float-start mb-3">
                        <br>
                        <img src="{{ url('assets/images/logo-dark.png') }}" alt="dark logo" height="22">
                    </div>
                    <div class="float-end">
                        <h4 class="d-print-none">OS: 195{{ $order->id }}</h4>
                    </div>
                </div>

                <!-- Invoice Detail-->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="float-start mt-3">
                            <p><b>Serviço: </b>
                                @php
                                $tiposServico = ''; // Inicializa uma variável para acumular os tipos
                                foreach ($valoresServicos as $index => $servico) {
                                    $tiposServico .= $servico['tipo'] . ' - '; // Adiciona o tipo com o traço
                                }
                                echo rtrim($tiposServico, ' - '); // Remove o último traço
                            @endphp
                            </p>
                            
                            <p class="text-muted font-13">Descrição: {{ $ordens->descricao }} </p>
                        </div>

                    </div><!-- end col -->
                    <div class="col-sm-4 offset-sm-2">
                        <div class="mt-3 float-sm-end">
                            <p class="font-13"><strong>Ordem: </strong> <span class="float-end">OS: 195{{ $order->id }}</span></p>
                            <p class="font-13"><strong>Data: </strong> {{ Carbon\Carbon::parse($order->created_at)->format('d/m') }}
                                as {{ Carbon\Carbon::parse($order->created_at)->format('H:i') }}</p>
                            <p class="font-13"><strong>Status: </strong><span class="{{ $order->classe_status }} float-end">{{ $order->status }}</span></p>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

                <div class="row mt-4">
                    <div class="col-sm-4">
                        <h4>Cliente</h4>
                        <address>
                            <b>Nome: </b>{{ $ordens->cliente->nome }}<br>
                            <b>CPF: </b>{{ $ordens->cliente->cpf }}<br>
                            <b>Fone: </b>{{ $ordens->cliente->fone }}<br>
                            <b>Endereço: </b>{{ $ordens->cliente->endereco }}, {{ $ordens->cliente->numero }} - {{ $ordens->cliente->cidade }}/{{ $ordens->cliente->estado }}
                        </address>
                    </div> <!-- end col-->

                    <div class="col-sm-4">
                        <h4>Veículo</h4>
                        <address>
                            <b>Veículo: </b>{{ $veiculo->documento->marca }}<br>
                            <b>Placa: </b>{{ $veiculo->documento->placa }}<br>
                            <b>Ano/Modelo: </b>{{ $veiculo->documento->ano }}<br>
                            <b>Cor: </b>{{ $veiculo->documento->cor }}
                        </address>
                    </div> <!-- end col-->


                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Valor</th>
                                        <th>Taxa</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($valoresServicos) && is_array($valoresServicos))
                                        @foreach ($valoresServicos as $index => $servico)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $servico['tipo'] }}</td> <!-- Exibe o nome do tipo de serviço -->
                                            <td>R$ {{ number_format($servico['valor_servico'], 2, ',', '.') }}</td> <!-- Exibe o valor do serviço -->
                                            <td>R$ {{ number_format($servico['taxa_administrativa'], 2, ',', '.') }}</td> <!-- Exibe a taxa administrativa -->
                                            <td class="text-end">R$ {{ number_format($servico['valor_total'], 2, ',', '.') }}</td> <!-- Exibe o valor total -->
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Nenhum serviço encontrado.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->
                    </div> <!-- end col -->
                </div>
                
                
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-6">
                        <div class="clearfix pt-3">
                            <h6 class="text-muted">Notes:</h6>
                            <small>
                                All accounts are to be paid within 7 days from receipt of
                                invoice. To be paid by cheque or credit card or direct payment
                                online. If account is not paid within 7 days the credits details
                                supplied as confirmation of work undertaken will be charged the
                                agreed quoted fee noted above.
                            </small>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-sm-6">
                        <div class="float-end mt-3 mt-sm-0">
                            <h3>R$ {{ number_format($ordens->valor_total, 2, ',', '.') }}</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div> <!-- end col -->
                </div>
                <!-- end row-->

                <div class="d-print-none mt-4">
                    <div class="text-end">
                        <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Print</a>
                        <a href="javascript: void(0);" class="btn btn-info">Submit</a>
                    </div>
                </div>
                <!-- end buttons -->

            </div> <!-- end card-body-->
        </div> <!-- end card -->
    </div> <!-- end col-->
</div>

<div class="d-print-none mt-4">
    <div class="text-end">
        <a href="javascript:void(0);" class="btn btn-primary" onclick="window.print();"><i class="mdi mdi-printer"></i> Print</a>
        <a href="javascript: void(0);" class="btn btn-info">Submit</a>
    </div>
</div>

@endsection