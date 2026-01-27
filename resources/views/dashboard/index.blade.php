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
            timer: 6000,
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
<br>


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
                    <span class="text-success me-2"><i class="mdi mdi-check-circle-outline"></i> Ativo</span>
                    <span class="text-nowrap">Disponíveis</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-lg-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-account-group widget-icon bg-info-lighten text-info"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Total de clientes">Clientes</h5>
                <h3 class="mt-3 mb-3">{{ $totalClientes }}</h3>
                <p class="mb-0 text-muted">
                    <span class="text-info me-2"><i class="mdi mdi-account-plus"></i> Base</span>
                    <span class="text-nowrap">Cadastros totais</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-lg-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-archive-outline widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Veículos arquivados">Arquivados</h5>
                <h3 class="mt-3 mb-3">{{ $totalArquivados }}</h3>
                <p class="mb-0 text-muted">
                    <span class="text-warning me-2"><i class="mdi mdi-history"></i> Histórico</span>
                    <span class="text-nowrap">Fora de estoque</span>
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
                    <span class="text-nowrap">Valor de mercado</span>
                </p>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title">Gestão de Frota</h4>
                    <a href="{{ route('veiculos.index') }}" class="btn btn-sm btn-primary">Ver todos</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Veículo / Placa</th>
                                <th>Proprietário / CPF</th>
                                <th>Combustível</th>
                                <th>Ano</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th style="width: 100px;" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosVeiculos as $veiculo)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php $images = json_decode($veiculo->images); @endphp
                                        <img src="{{ isset($images[0]) ? asset('storage/' . $images[0]) : asset('assets/images/no-image.png') }}" 
                                             alt="veiculo" class="me-3 rounded-circle" height="40" width="40" style="object-fit: cover;">
                                        <div>
                                            <h5 class="font-14 my-1 fw-medium">{{ $veiculo->marca }} {{ $veiculo->modelo }}</h5>
                                            <span class="badge badge-outline-secondary font-11">{{ $veiculo->placa }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted font-13">{{ $veiculo->nome }}</div>
                                    <div class="font-12"><b>CPF:</b> {{ $veiculo->cpf }}</div>
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
                                <td>{{ $veiculo->ano }}</td>
                                <td>
                                    <span class="fw-bold">R$ {{ number_format($veiculo->valor ?? 0, 2, ',', '.') }}</span>
                                </td>
                                <td>
                                    @if($veiculo->status == 'Ativo')
                                        <span class="badge bg-success-lighten text-success"><i class="mdi mdi-circle font-10"></i> Ativo</span>
                                    @else
                                        <span class="badge bg-secondary-lighten text-secondary">Arquivado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('veiculos.show', $veiculo->id) }}" class="action-icon text-info" title="Visualizar"> 
                                        <i class="mdi mdi-eye-outline"></i>
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
                </div> 
            </div> 
        </div> 
    </div> 
</div>



        <!-- Para Mobile -->
        <div class="card ribbon-box d-block d-md-none">
          <div class="card-body">
              <div class="ribbon ribbon-success float-end"><i class="mdi mdi-access-point me-1"></i> 05.03.2025</div>
              <h5 class="text-success float-start mt-0">Novidades no App!</h5>
              <div class="ribbon-content">
                  <ul>
                    <li>Página assinaturas adicionada ao menu do perfil</li>
                    <li>Adicionada a página ajuda</li>
                    <li>Agora é possível gerenciar pastas de documentos na página <a href="{{ route('perfil.index') }}">Perfil</a> do usuário.</li>
                  </ul>
              </div>
          </div> <!-- end card-body -->
      </div> <!-- end card-->
      
      
{{-- @can('access-lojista')

@endcan --}}

<!-- Bootstrap -->

@endsection