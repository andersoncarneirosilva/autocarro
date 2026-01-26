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
            timerProgressBar: true
        });

        @if (session('success'))
            Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif

        @if (session('error'))
            Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
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
                    <i class="mdi mdi-car widget-icon bg-primary-lighten text-primary"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Total de Veículos Ativos">Estoque Ativo</h5>
                <h3 class="mt-3 mb-3">#</h3>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                    <span class="text-nowrap">Desde o último mês</span>
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
                <h5 class="text-muted fw-normal mt-0" title="Soma total dos valores">Valor do Estoque</h5>
                <h3 class="mt-3 mb-3">R$ #</h3>
                <p class="mb-0 text-muted">
                    <span class="text-nowrap">Capital investido</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-lg-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-eye-outline widget-icon bg-info-lighten text-info"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Total de visitas em todos os anúncios">Visualizações</h5>
                <h3 class="mt-3 mb-3">#</h3>
                <p class="mb-0 text-muted">
                    <span class="text-primary me-2" style="color: #ff4a17 !important;"><i class="mdi mdi-fire"></i> Engajamento</span>
                    <span class="text-nowrap">Cliques em anúncios</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-lg-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-tag-outline widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Veículos com valor de oferta preenchido">Em Promoção</h5>
                <h3 class="mt-3 mb-3">#</h3>
                <p class="mb-0 text-muted">
                    <span class="text-danger me-2"><i class="mdi mdi-trending-down"></i> Preço baixo</span>
                    <span class="text-nowrap">Veículos com desconto</span>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title">Veículos Mais Vistos (Top Performance)</h4>
                    <a href="{{ route('veiculos.index') }}" class="btn btn-sm btn-light">Ver todos</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Veículo</th>
                                <th>Preço</th>
                                <th>Visitas</th>
                                <th>Status</th>
                                <th style="width: 80px;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div> </div> </div> </div> <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Distribuição por Combustível</h4>
                
                <div id="donut-combustivel" class="apex-charts" style="min-height: 320px;"></div>
                
                <div class="mt-3 text-center">
                    <p class="text-muted font-13 mb-0">Total de variedades: <strong>/strong></p>
                </div>
            </div> </div> </div> </div>



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