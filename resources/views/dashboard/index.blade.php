@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@include('components.toast')

<div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <form class="d-flex" id="filter-form" action="{{ route('dashboard.index') }}" method="GET">
    <div class="input-group">
        <input type="text" 
       class="form-control form-control-light" 
       id="dash-daterange" 
       name="date" 
       value="{{ $rangeSelecionado ?? '' }}">
        <span class="input-group-text bg-primary border-primary text-white">
            <i class="mdi mdi-calendar-range font-13"></i>
        </span>
    </div>
    <button type="submit" class="btn btn-primary ms-2">
        <i class="mdi mdi-autorenew"></i>
    </button>
</form>
                                </div>
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>

<div class="row">
    <div class="col-xl-5 col-lg-6">
        <div class="row">
            <div class="col-sm-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-currency-usd widget-icon bg-success-lighten text-success"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Receita Mensal">Receitas</h5>
                        <h3 class="mt-3 mb-3">R$ {{ number_format($receitasMes, 2, ',', '.') }}</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 12.5%</span>
                            <span class="text-nowrap">vs. mês anterior</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-cash-minus widget-icon bg-danger-lighten text-danger"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Despesas Mensais">Despesas</h5>
                        <h3 class="mt-3 mb-3">R$ {{ number_format($despesasMes, 2, ',', '.') }}</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-danger me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.2%</span>
                            <span class="text-nowrap">Aumento em custos</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-package-variant-closed widget-icon bg-warning-lighten text-warning"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Itens com estoque baixo">Estoque Crítico</h5>
                        <h3 class="mt-3 mb-3">{{ $estoqueBaixo }} Itens</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-warning">Reposição necessária</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-pulse widget-icon bg-info-lighten text-info"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Balanço Líquido">Lucro Líquido</h5>
                        <h3 class="mt-3 mb-3">R$ {{ number_format($receitasMes - $despesasMes, 2, ',', '.') }}</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-success"><i class="mdi mdi-check"></i> Saudável</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-7 col-lg-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="header-title">Faturamento vs Projeção</h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item">Ver Relatório</a>
                            <a href="javascript:void(0);" class="dropdown-item">Exportar PDF</a>
                        </div>
                    </div>
                </div>
                <div dir="ltr">
                    <div id="high-performing-product" class="apex-charts" data-colors="#727cf5,#e3eaef"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-9 col-lg-8">
        <div class="card">
            <div class="d-flex card-header justify-content-between align-items-center">
                <h4 class="header-title">Receita Mensal</h4>
                </div>

            <div class="card-body p-0">
                <div class="bg-light bg-opacity-25 border-top border-bottom border-light border-dashed">
                    <div class="row text-center">
                        <div class="col-sm-6">
                            <p class="text-muted mb-0 mt-3">Semana Atual</p>
                            <h2 class="fw-normal mb-3">
                                <small class="mdi mdi-checkbox-blank-circle text-primary align-middle me-1"></small>
                                <span>R$ {{ number_format($totalSemanaAtual, 2, ',', '.') }}</span>
                            </h2>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted mb-0 mt-3">Semana Anterior</p>
                            <h2 class="fw-normal mb-3">
                                <small class="mdi mdi-checkbox-blank-circle text-success align-middle me-1"></small>
                                <span>R$ {{ number_format($totalSemanaPassada, 2, ',', '.') }}</span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dash-item-overlay d-none d-md-block" dir="ltr">
                    <h5>Ganhos de Hoje: R$ {{ number_format($ganhoHoje ?? 0, 2, ',', '.') }}</h5>
                    <p class="text-muted font-13 mb-3 mt-2">Dados processados pelo Alcecar.</p>
                </div>
                <div dir="ltr">
                    <div id="revenue-chart" class="apex-charts mt-3" style="min-height: 370px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-4">
        <div class="card">
            <div class="d-flex card-header justify-content-between align-items-center">
                <h4 class="header-title">Últimos Agendamentos</h4>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ route('agenda.index') }}" class="dropdown-item">Ver Todos</a>
                    </div>
                </div>
            </div>

            <div class="card-body py-0 mb-3" data-simplebar style="max-height: 403px;">
                <div class="timeline-alt py-0">
                    @foreach($agendamentos as $agendamento)
<div class="timeline-item">
    <i class="mdi {{ $agendamento->status == 'Confirmado' ? 'mdi-check-circle bg-success-lighten text-success' : 'mdi-calendar-clock bg-info-lighten text-info' }} timeline-icon"></i>
    
    <div class="timeline-item-info">
        <a href="#" class="text-info fw-bold mb-1 d-block">
            {{ $agendamento->cliente_nome ?? 'Cliente Avulso' }}
        </a>

        <small>
            @if(is_array($agendamento->servicos_json))
                {{ $agendamento->servicos_json[0]['nome'] ?? 'Serviço' }}
            @else
                Agendamento
            @endif
            - <strong>R$ {{ number_format($agendamento->valor_total, 2, ',', '.') }}</strong>
        </small>

        <p class="mb-0 pb-2">
            <small class="text-muted">
                {{-- Verifica se a data não é nula antes de chamar a função --}}
                {{ $agendamento->data_hora_inicio ? $agendamento->data_hora_inicio->diffForHumans() : 'Horário não definido' }}
            </small>
        </p>
    </div>
</div>
@endforeach
                </div>
            </div> 
        </div> 
    </div>
</div>


<script>
    $(document).ready(function() {
        // Inicialização do Calendário
        $('#dash-daterange').daterangepicker({
            startDate: "{{ $startDate->format('d/m/Y') }}",
            endDate: "{{ $endDate->format('d/m/Y') }}",
            locale: { 
                format: 'DD/MM/YYYY',
                applyLabel: "Filtrar Mês"
            }
        });

        $('#dash-daterange').on('apply.daterangepicker', function(ev, picker) {
            let range = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
            window.location.href = "{{ route('dashboard.index') }}?date=" + range;
        });

        // Gráfico Agrupado por Mês
        var options = {
            chart: { 
                height: 226, 
                type: "bar", 
                toolbar: { show: false } 
            },
            // --- ESTA É A LINHA QUE REMOVE O VALOR DE DENTRO DA BARRA ---
            dataLabels: { 
                enabled: false 
            }, 
            // -----------------------------------------------------------
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "45%",
                    borderRadius: 4
                }
            },
            series: [{
                name: "Receitas",
                data: {!! json_encode($dataReceitas) !!}
            }, {
                name: "Despesas",
                data: {!! json_encode($dataDespesas) !!}
            }],
            colors: ["#727cf5", "#fa5c7c"],
            xaxis: {
                categories: {!! json_encode($labels) !!},
                axisBorder: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function(val) { 
                        return "R$ " + (val/1000).toFixed(1) + "k"; 
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "R$ " + val.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                    }
                }
            },
            grid: { borderColor: '#f1f3fa' },
            legend: { 
                show: true, 
                position: 'top', 
                horizontalAlign: 'right' 
            }
        };

        new ApexCharts(document.querySelector("#high-performing-product"), options).render();
    });
</script>

<script>
    $(document).ready(function() {
        var options = {
            chart: {
                height: 370,
                type: 'area',
                toolbar: { show: false }
            },
            stroke: { curve: 'smooth', width: 4 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: { enabled: false },
            colors: ['#727cf5', '#0acf97'],
            series: [{
                name: 'Semana Atual',
                data: {!! json_encode($dadosSemanaAtual ?? []) !!}
            }, {
                name: 'Semana Anterior',
                data: {!! json_encode($dadosSemanaPassada ?? []) !!}
            }],
            xaxis: {
                categories: {!! json_encode($labelsSemana ?? []) !!},
                axisBorder: { show: false }
            },
            legend: { show: false },
            grid: { borderColor: '#f1f3fa', strokeDashArray: 7 },
            yaxis: {
                labels: {
                    formatter: function (val) { return "R$ " + (val / 1000).toFixed(1) + "k"; }
                }
            }
        };

        new ApexCharts(document.querySelector("#revenue-chart"), options).render();
    });
</script>
@endsection