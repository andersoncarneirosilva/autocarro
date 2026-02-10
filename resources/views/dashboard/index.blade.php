@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Toasts de sessão --}}
@if (session('success') || session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({ 
                icon: 'success', 
                title: '{{ session('success') }}' 
            });
        @endif

        @if (session('error'))
            Toast.fire({ 
                icon: 'error', 
                title: '{{ session('error') }}' 
            });
        @endif
    });
</script>
@endif

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <h3 class="page-title">Dashboard</h3>
        </div>
    </div>
</div>
@php
    $userLogado = auth()->user();
    $dono = $userLogado->empresa_id ? \App\Models\User::find($userLogado->empresa_id) : $userLogado;
    
    // --- LÓGICA 1: PERÍODO DE TESTE ---
    $exibirAvisoTeste = false;
    if ($dono && $dono->plano === 'Teste') {
        $dataExpiracaoTeste = $dono->created_at->addDays(7);
        $diasRestantesTeste = ceil(now()->diffInDays($dataExpiracaoTeste, false));
        $exibirAvisoTeste = true;
    }

    // --- LÓGICA 2: ASSINATURA PAGA ---
    $exibirAvisoVencimento = false;
    $assinaturaAtiva = \DB::table('assinaturas')
        ->where('user_id', $dono->id)
        ->where('status', 'paid')
        ->orderBy('data_fim', 'desc')
        ->first();

    if ($assinaturaAtiva) {
        $dataFim = \Carbon\Carbon::parse($assinaturaAtiva->data_fim);
        $diasParaVencer = ceil(now()->diffInDays($dataFim, false));

        // REGRA: Se menor que zero (Vencido), redireciona imediatamente
        if ($diasParaVencer < 0) {
            header("Location: " . route('assinatura.expirada'));
            exit;
        }
        
        // REGRA: Mostrar aviso se faltar 7 dias ou menos
        if ($diasParaVencer <= 7) {
            $exibirAvisoVencimento = true;
            $exibirAvisoTeste = false; 
        }
    }
@endphp

{{-- Aviso de Teste --}}
@if($exibirAvisoTeste && $diasRestantesTeste >= 0)
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
        <i class="uil uil-clock-three me-2 fs-4"></i> 
        <div class="flex-grow-1">
            Você tem mais <strong>{{ $diasRestantesTeste }} dias</strong> de teste gratuito.
        </div>
        <a href="{{ route('planos.index') }}" class="btn btn-info btn-sm ms-auto rounded-pill">Assinar Agora</a>
    </div>
@endif

{{-- Aviso de Vencimento (Pago) --}}
@if($exibirAvisoVencimento)
    <div class="alert {{ $diasParaVencer == 0 ? 'alert-danger shadow' : 'alert-warning' }} border-0 shadow-sm d-flex align-items-center">
        <i class="mdi {{ $diasParaVencer == 0 ? 'mdi-alert-octagon' : 'mdi-alert-outline' }} me-2 fs-4"></i> 
        <div class="flex-grow-1">
            @if($diasParaVencer > 0)
                Sua assinatura vence em <strong>{{ $diasParaVencer }} {{ $diasParaVencer > 1 ? 'dias' : 'dia' }}</strong>.
            @else
                {{-- REGRA: Se igual a 0 --}}
                <span class="fw-bold">Sua assinatura vencerá hoje!</span> Regularize para evitar o bloqueio amanhã.
            @endif
        </div>
        <a href="{{ route('planos.index') }}" class="btn {{ $diasParaVencer == 0 ? 'btn-danger' : 'btn-warning' }} btn-sm ms-auto rounded-pill shadow-sm">
            {{ $diasParaVencer == 0 ? 'Pagar Hoje' : 'Renovar' }}
        </a>
    </div>
@endif
<!-- Para Mobile -->
<div class="card ribbon-box d-block d-md-none">
    <div class="card-body">
        <div class="ribbon ribbon-success float-end"><i class="mdi mdi-access-point me-1"></i> 27.01.2026</div>
        <h5 class="text-success float-start mt-0">Novidades no App!</h5>
        <div class="ribbon-content">
            <ul>
            <li class="mb-1">
                <strong>Gestão de Multas:</strong> Novo módulo para controle de infrações e recursos.
            </li>
            <li class="mb-1">
                <strong>Alertas Inteligentes:</strong> Avisos visuais de multas vencidas ou próximas do vencimento.
            </li>
            <li class="mb-1">
                <strong>Baixa Rápida:</strong> Marque multas como pagas com um clique.
            </li>
            <li class="mb-1">
                <strong>Interface Responsiva:</strong> Tabelas otimizadas com scroll horizontal para dispositivos móveis.
            </li>
            </ul>
            <div class="text-center mt-2">
        <a href="#" class="btn btn-sm btn-soft-success">Conferir Multas</a>
    </div>
        </div>
    </div>
</div> 


<div class="row">
    <div class="col-xxl-3 col-lg-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-car-multiple widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Veículos disponíveis">Estoque Ativo</h5>
                <h3 class="mt-3 mb-3">{{ $totalAtivos }}</h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="mdi mdi-check-circle-outline"></i> Disponível</span>
                    {{-- <span class="text-nowrap">Disponíveis</span> --}}
                </p>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-lg-6">
    <div class="card widget-flat">
        <div class="card-body">
            <div class="float-end">
                {{-- Ícone de carrinho ou dinheiro para simbolizar venda --}}
                <i class="mdi mdi-cart-check widget-icon bg-warning-lighten text-warning"></i>
            </div>
            <h5 class="text-muted fw-normal mt-0" title="Total de veículos vendidos">Veículos Vendidos</h5>
            <h3 class="mt-3 mb-3">{{ $totalVendidos }}</h3>
            <p class="mb-0 text-muted">
                <span class="text-warning me-2">
                    <i class="mdi mdi-currency-usd"></i> 
                    R$ {{ number_format($receitaVendas, 2, ',', '.') }}
                </span>
                <span class="text-nowrap font-12">em receita</span>
            </p>
        </div>
    </div>
</div>

    <div class="col-xxl-3 col-lg-6">
    <div class="card widget-flat">
        <div class="card-body">
            <div class="float-end">
                <i class="mdi mdi-cash-multiple widget-icon bg-danger-lighten text-danger"></i>
            </div>
            
            <h5 class="text-muted fw-normal mt-0" title="Total que ainda precisa ser pago">Contas a Pagar</h5>
            
            <h3 class="mt-3 mb-3 {{ $contasAPagar > 0 ? 'text-danger' : 'text-dark' }}">
                R$ {{ number_format($contasAPagar, 2, ',', '.') }}
            </h3>
            
            <p class="mb-0 text-muted">

                <small>
                    @if($contasAPagar > 0)
                        <i class="mdi mdi-information-outline"></i> {{ $quantidadePendente }} lançamento(s) pendente(s)
                    @else
                        <i class="mdi mdi-check-all text-success"></i> Fluxo em dia
                    @endif
                </small>
            </p>
        </div>
    </div>
</div>

    

    <div class="col-xxl-3 col-lg-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-currency-usd widget-icon bg-success-lighten text-success"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Soma dos preços ativos">Valor em Estoque</h5>
                <h3 class="mt-3 mb-3">R$ {{ number_format($valorEstoque, 2, ',', '.') }}</h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="mdi mdi-trending-up"></i> Patrimônio</span>
                    {{-- <span class="text-nowrap">Valor de mercado</span> --}}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-2"> {{-- Padding reduzido para alinhar com o container --}}
                <div class="d-flex justify-content-between align-items-center mb-3 p-2">
                    <h4 class="header-title mb-0 text-dark fw-bold">Gestão de Frota</h4>
                    <a href="{{ route('veiculos.index') }}" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-arrow-right me-1"></i>Ver todos
                    </a>
                </div>

                {{-- Substituído table-responsive por table-custom-container --}}
                <div class="table-custom-container">
                    <table class="table table-custom table-nowrap table-hover mb-0">
                        <thead class="table-dark"> {{-- Cabeçalho escuro para padronizar --}}
                            <tr>
                                <th>Veículo</th>
                                <th>Placa</th>
                                <th>Combustível</th>
                                <th>Ano/Modelo</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th style="width: 80px;" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosVeiculos as $veiculo)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php 
                                            $images = json_decode($veiculo->images); 
                                            $inicialPlaca = substr($veiculo->placa, 0, 1);
                                        @endphp

                                        <a href="{{ route('veiculos.show', $veiculo->id) }}" class="me-3 transition-all hover-scale">
                                            @if(isset($images[0]))
                                                <img src="{{ asset('storage/' . $images[0]) }}" 
                                                     alt="veiculo" class="rounded-circle border" height="40" width="40" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white fw-bold" 
                                                     style="width: 40px; height: 40px; min-width: 40px; font-size: 16px;">
                                                    {{ strtoupper($inicialPlaca) }}
                                                </div>
                                            @endif
                                        </a>

                                        <div>
                                            <h5 class="font-14 my-1 fw-bold text-dark">
                                                <a href="{{ route('veiculos.show', $veiculo->id) }}" class="text-dark">{{ $veiculo->marca }}</a>
                                            </h5>
                                            <p class="mb-0 font-12 text-muted">{{ $veiculo->modelo }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-outline-secondary font-12 tracking-wider">{{ $veiculo->placa }}</span>
                                </td>
                                <td>
                                    @php
                                        $badgeColor = match(strtolower($veiculo->combustivel)) {
                                            'gasolina' => 'bg-info',
                                            'flex' => 'bg-primary',
                                            'diesel' => 'bg-warning',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeColor }}">{{ strtoupper($veiculo->combustivel ?? 'N/A') }}</span>
                                </td>
                                <td>{{ $veiculo->ano_fabricacao }}/{{ $veiculo->ano_modelo }}</td>
                                <td class="align-middle">
                                    @if($veiculo->valor_oferta > 0)
                                        <small class="text-muted d-block" style="text-decoration: line-through; font-size: 0.75rem;">
                                            R$ {{ number_format($veiculo->valor, 2, ',', '.') }}
                                        </small>
                                        <span class="fw-bold text-danger">
                                            R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="fw-bold text-dark">
                                            R$ {{ number_format($veiculo->valor ?? 0, 2, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($veiculo->status == 'Disponível')
                                        <span class="badge bg-success-lighten text-success">Disponível</span>
                                    @else
                                        <span class="badge bg-secondary-lighten text-secondary">Arquivado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('veiculos.show', $veiculo->id) }}" class="btn btn-sm btn-soft-info" title="Visualizar"> 
                                        <i class="mdi mdi-eye-outline font-16"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center p-4 text-muted">Nenhum registro encontrado no Alcecar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> {{-- Fim table-custom-container --}}
            </div> 
        </div> 
    </div> 
</div>

<style>
    /* Estilos preservados para o Dashboard */
    .hover-scale:hover { transform: scale(1.1); }
    .transition-all { transition: all 0.2s ease-in-out; }
    .bg-primary-lighten { background-color: rgba(114, 124, 245, 0.15) !important; }
    .font-10 { font-size: 10px; }
</style>


        
      

@endsection