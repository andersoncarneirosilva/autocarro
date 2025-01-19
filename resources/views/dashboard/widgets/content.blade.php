<div class="row">
    <div class="col-lg-5">
        <div class="card mb-md-0 mb-3">
            <div class="card-body">
                <div class="card-widgets">
                    {{-- <a href="javascript:;" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                    <a data-bs-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                    <a href="#" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a> --}}
                </div>
                <h5 class="card-title mb-0">Atualizações 19.01.2025</h5>                
                <div id="cardCollpase1" class="collapse pt-3 show">
                    <li>Correção na validação no cadastro de outorgados.</li>
                    <li>Cada usuário tem um espaço limitado para armazenamento de arquivos.</li>
                    <li>Correção no campo busca para smartphone.</li>
                </div>
            </div>
        </div> <!-- end card-->
        {{-- <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title">Visão geral</h4>
                <div class="dropdown">
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="card flex-fill w-100 draggable">
                    <canvas id="chartjs-dashboard-pie" width="856" 
                    height="400" style="display: block; height: 200px; width: 428px;" 
                    class="chart-pie chartjs-render-monitor"></canvas>
                </div>
                
                <script>
                    // Dados recebidos da controller
                    const data = [{{ $countProcs }}, {{ $countDocs }}, {{ $countOrder }}];
                    const labels = ["Procurações", "Documentos", "Ordens"];
                
                    // Inicializar o gráfico
                    document.addEventListener("DOMContentLoaded", function() {
                        var chartsPie = document.querySelectorAll(".chart-pie");
                
                        chartsPie.forEach(function(chart) {
                            if (!chart.getAttribute('data-chart-initialized')) {
                                new Chart(chart, {
                                    type: "pie",
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            data: data,
                                            backgroundColor: [
                                                window.theme?.primary || "#007bff",
                                                window.theme?.warning || "#ffc107",
                                                window.theme?.warning || "#00ff99"
                                            ],
                                            borderWidth: 5
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                display: false
                                            }
                                        }
                                    }
                                });
                                chart.setAttribute("data-chart-initialized", "true");
                            }
                        });
                    });
                </script>
                

                <div class="row text-center mt-3">
                    <div class="col-sm-4">
                        <i class="mdi mdi-file-account widget-icon rounded-circle bg-warning-lighten text-warning"></i>
                        <h3 class="fw-normal mt-3">
                            <span>{{ $countDocs }}</span>
                        </h3>
                        <p class="text-muted mb-0 mb-2"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> Documentos</p>
                    </div>
                    <div class="col-sm-4">
                        <i class="mdi mdi-file-document-outline widget-icon rounded-circle bg-primary-lighten text-primary"></i>
                        <h3 class="fw-normal mt-3">
                            <span>{{ $countProcs }}</span>
                        </h3>
                        <p class="text-muted mb-0 mb-2"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> Procurações</p>
                    </div>
                    <div class="col-sm-4">
                        <i class="mdi mdi-card-account-details widget-icon rounded-circle bg-success-lighten text-success"></i>
                        <h3 class="fw-normal mt-3">
                            <span>{{ $countOrder }}</span>
                        </h3>
                        <p class="text-muted mb-0 mb-2"><i class="mdi mdi-checkbox-blank-circle text-success"></i> Ordens</p>
                    </div>
                </div>
            </div>
            <!-- end card body-->
        </div> --}}
        <!-- end card -->
    </div>
    <!-- end col-->

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title">Últimos veículos</h4>
            </div>
            @if ($emprestimos)
            <div class="card-body pt-2">
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <tbody>
                            @foreach ($emprestimos as $emp)
                            <tr>
                                <td>
                                    <h5 class="font-14 my-1"><a href="#" class="text-body">{{ $emp->nome }}</a></h5>
                                    <span class="text-muted font-13">{{ $emp->marca }}</span>
                                </td>
                                <td>
                                    <span class="text-muted font-13">Placa</span> <br>
                                    <span class="font-14 mt-1 fw-normal">{{ $emp->placa }}</span>
                                </td>
                                <td>
                                    <span class="text-muted font-13">Cor</span>
                                    <h5 class="font-14 mt-1 fw-normal">{{ $emp->cor }}</h5>
                                </td>
                                <td>
                                    <span class="text-muted font-13">Ano/Modelo</span>
                                    <h5 class="font-14 mt-1 fw-normal">{{ $emp->ano }}</h5>
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->

            </div> <!-- end card body-->
            
            @else
                <div class="alert alert-warning" role="alert">
                    NENHUM RESULTADO ENCONTRADO!
                </div>
            @endif
        </div> <!-- end card -->
        <!-- end card -->
    </div>
    <!-- end col-->
</div><!-- end row-->