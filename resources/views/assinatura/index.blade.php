@extends('layouts.app')

@section('title', 'Proconline')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Minha assinatura</li>
                </ol>
            </div>
            <h3 class="page-title">Minha assinatura
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
                    <h4 class="header-title">Minhas assinaturas</h4>
                    <div class="dropdown">
                    
                    <a href="{{ route('planos.index')}}" class="btn btn-primary btn-sm">Adicionar créditos</a>
                    
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($assinaturas->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Plano</th>
                                <th>Valor</th>
                                <th>Data Início</th>
                                <th>Data Término</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($assinaturas as $assinatura)
                            <tr>
                                <td>{{ $assinatura->plano }}</td>
                                <td>R$ {{ number_format($assinatura->valor, 2, ',', '.') }}</td>
                                
                                <td>{{ \Carbon\Carbon::parse($assinatura->data_inicio)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($assinatura->data_fim)->format('d/m/Y') }}</td>
                                
                                @php
                                    $statusTraduzido = [
                                        'paid' => 'Aprovado',
                                        'pending' => 'Pendente',
                                        'approved' => 'Aprovado',
                                        'in_process' => 'Em Processamento',
                                        'rejected' => 'Rejeitado',
                                        'cancelled' => 'Cancelado',
                                        'refunded' => 'Reembolsado',
                                        'charged_back' => 'Estornado'
                                    ];
                                @endphp

                                <td>
                                    <span class="{{ $assinatura->class_status }}">
                                        {{ $statusTraduzido[$assinatura->status] ?? $assinatura->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($assinaturas->total() == 0)
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <br>
    
    </div>
</div>
<br>


@endsection