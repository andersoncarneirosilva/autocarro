@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

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
                <h3 class="mt-3 mb-3">{{ $totalEstoque }}</h3>
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
                <h3 class="mt-3 mb-3">R$ {{ number_format($valorTotal, 2, ',', '.') }}</h3>
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
                <h3 class="mt-3 mb-3">{{ number_format($totalVisitas, 0, ',', '.') }}</h3>
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
                <h3 class="mt-3 mb-3">{{ $totalOfertas }}</h3>
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
                    <a href="{{ route('anuncios.index') }}" class="btn btn-sm btn-light">Ver todos</a>
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
                            @foreach($maisVistos as $item)
                                @php
                                    $fotos = json_decode($item->images, true) ?? [];
                                    $capa = (count($fotos) > 0) ? asset('storage/' . $fotos[0]) : asset('frontend/images/placeholder.png');
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $capa }}" alt="car-img" class="rounded me-2" height="32">
                                            <p class="m-0 d-inline-block">
                                                <a href="{{ route('anuncios.show', $item->slug) }}" class="text-body fw-semibold" style="font-size: 0.85rem;">{{ $item->marca_real }} {{ $item->modelo_real }}</a>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->valor_oferta > 0)
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-danger">
                                                    R$ {{ number_format($item->valor_oferta, 2, ',', '.') }}
                                                </span>
                                                <small class="text-muted text-decoration-line-through" style="font-size: 0.75rem;">
                                                    R$ {{ number_format($item->valor, 2, ',', '.') }}
                                                </small>
                                            </div>
                                        @else
                                            <span class="fw-bold text-dark">
                                                R$ {{ number_format($item->valor, 2, ',', '.') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center" style="min-width: 80px;">
                                            <span class="me-2 small fw-semibold">{{ $item->visitas }}</span>
                                            <div class="progress progress-sm w-100" style="height: 4px;">
                                                @php $percentual = ($maxVisitas > 0) ? ($item->visitas / $maxVisitas) * 100 : 0; @endphp
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentual }}%; background-color: #ff4a17 !important;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $item->status_anuncio == 'Publicado' ? 'badge-success-lighten' : 'badge-warning-lighten' }}">
                                            {{ $item->status_anuncio }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('anuncios.edit', $item->id) }}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> </div> </div> </div> <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Distribuição por Combustível</h4>
                
                <div id="donut-combustivel" class="apex-charts" style="min-height: 320px;"></div>
                
                <div class="mt-3 text-center">
                    <p class="text-muted font-13 mb-0">Total de variedades: <strong>{{ count($distribuicao) }}</strong></p>
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

<script>
    var options = {
        chart: {
            height: 320,
            type: 'donut',
        },
        // Cores: Laranja Alcecar, Azul Hyper, Verde, Amarelo, etc.
        colors: ['#ff4a17', '#727cf5', '#0acf97', '#ffbc00', '#39afd1'],
        series: {!! json_encode($distribuicao->pluck('total')) !!},
        labels: {!! json_encode($distribuicao->pluck('combustivel')) !!},
        legend: {
            show: true,
            position: 'bottom'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: 'bottom' }
            }
        }],
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                            }
                        }
                    }
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#donut-combustivel"), options);
    chart.render();
</script>
@endsection