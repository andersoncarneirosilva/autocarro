
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Proc Online</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.min.js"></script>
        
        <!-- Theme Config Js -->
        <script src="assets/js/hyper-config.js"></script>


        <!-- App css -->
        <link href="assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Topbar Start ========== -->
            @include('components.navbar')
            <!-- ========== Topbar End ========== -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('components.sidebar')
            <!-- ========== Left Sidebar End ========== -->

                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- ========== Left Sidebar End ========== -->
            

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                        <div class="col-xl-5 col-lg-6">
                            <div id="notifications"></div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-robot-happy-outline widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Bem-vindo,<br>{{ auth()->user()->name }}</h5>
                                            <h4 class="mt-3 mb-3">
                                                {{ $today }}
                                            </h4>
                                            <p class="mb-0 text-muted">
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-sm-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-credit-card-plus widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Saldo</h5>
                                            <h4 class="mt-3 mb-3">
                                                @if(auth()->user()->credito <= 2)
                                                    <span class="link-danger">R${{ auth()->user()->credito }},00</span>
                                                @else
                                                    <span class="link">R${{ auth()->user()->credito }},00</span>
                                                @endif
                                            </h4>
                                                
                                            <p class="mb-0 text-muted">
                                                @if(auth()->user()->credito <= 2)
                                                <a href="https://api.whatsapp.com/send/?phone=51994867806" target="_blank" style="color: #0b8638;">
                                                    <i class="uil uil-whatsapp"></i> Solicitar créditos
                                                </a>
                                                @endif
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-currency-usd widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Receita</h5>
                                            <h3 class="mt-3 mb-3">R$ {{ number_format($totalOrdensAtual, 0, ',', '.') }}</h3>
                                            <p class="mb-0 text-muted">
                                                @if($totalOrdensAtual > $totalOrdensAnterior)
                                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i>{{ $porcentagem }}%</span>
                                                <span class="text-nowrap">desde mês passado</span>
                                                @else
                                                <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i>{{ $porcentagem }}%</span>
                                                <span class="text-nowrap">desde mês passado</span>
                                                @endif
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-sm-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-cart-arrow-down widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Growth">Despesas</h5>
                                            <h3 class="mt-3 mb-3">R$ 760</h3>
                                            <p class="mb-0 text-muted">
                                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                                                <span class="text-nowrap">Desde último mês</span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div> <!-- end row -->

                        </div> <!-- end col -->

                        <div class="col-xl-7 col-lg-6">
                            <div class="card card-h-100">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <h4 class="header-title">Ordens lançadas</h4>
                                    
                                </div>
                                <div class="card-body pt-0">
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            var countDocs = @json($countDocs);
                                            var countProcs = @json($countProcs);
                                            var countCnh = @json($countCnh);

                                          var options = {
                                            chart: {
                                              type: 'bar',
                                              height: 280,
                                            },
                                            plotOptions: {
                                                bar: {
                                                    barHeight: '70%', // Proporção da altura do gráfico
                                                    columnWidth: '30%', // Define a largura das barras como porcentagem
                                                }
                                                },
                                            series: [
                                              {
                                                name: 'Ordens',
                                                data: [countDocs, 15, 25,19, 35, 20, 30,10,15,34,23, 40]
                                              }
                                            ],
                                            xaxis: {
                                              categories: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto','Setembro', 'Outubro', 'Novembro', 'Dezembro']
                                            },
                                            title: {
                                              text: 'Lancamento anual',
                                              align: 'center'
                                            },
                                            
                                            colors: ['#008FFB']
                                          };
                                    
                                          var chart = new ApexCharts(document.querySelector("#chart"), options);
                                          chart.render();
                                        });
                                      </script>
                                      <div id="chart" class="apex-charts" style="width: 100%; height: 200px; margin: auto;"></div>
                                    

                                    

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->

                        </div> <!-- end col -->
                    </div>
                    
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="card">
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
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col-->
    
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="header-title">Últimas procurações</h4>
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
                        </div>
                        <!-- end row-->


                        
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                @include('components.footer')
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->
<!-- Modal para Visualizar Informações -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aqui as informações vão ser carregadas dinamicamente -->
                <p><strong><u>Informações do Proprietário</u></strong></p>
                <p><strong>Nome:</strong> <span id="nome"></span></p>
                <p><strong>CPF:</strong> <span id="cpf"></span></p>

                <p><strong><u>Informações do Veículo</u></strong></p>
                
                <p><strong>Marca:</strong> <span id="marca"></span></p>
                <p><strong>Placa:</strong> <span id="placa"></span></p>
                
                <p><strong>Cor:</strong> <span id="cor"></span></p>
                <p><strong>Ano:</strong> <span id="ano"></span></p>
                <p><strong>Renavam:</strong> <span id="renavam"></span></p>
                <p><strong>Chassi:</strong> <span id="chassi"></span></p>
                <p><strong>Cidade:</strong> <span id="cidade"></span></p>
                <p><strong>CRV:</strong> <span id="crv"></span></p>
                <p><strong>Placa Anterior:</strong> <span id="placa_anterior"></span></p>
                <p><strong>Categoria:</strong> <span id="categoria"></span></p>
                <p><strong>Motor:</strong> <span id="motor"></span></p>
                <p><strong>Combustível:</strong> <span id="combustivel"></span></p>
                <p><strong>Observações do veículo:</strong> <span id="infos"></span></p>
                
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>



<script>

function openInfoModal(event) {
    event.preventDefault(); // Impede o comportamento padrão do link

    // Obtém o ID do documento do atributo 'data-id'
    //const docId = event.currentTarget.getAttribute('data-id');
    const docId = event.target.closest('a').getAttribute('data-id');
    //const url = `/documentos/gerarProc/${docId}/${encodeURIComponent(address)}`;
    //console.log("ID do Documento:", docId);  // Verifique se o ID está correto no console
    //console.log("ID do Documento:", docId);

    // Faz uma requisição AJAX para buscar as informações do documento
    $.ajax({
        url: `/documentos/${docId}`, // Substitua com a URL para pegar as informações do documento
        method: 'GET',
        success: function(response) {
            //console.log("Resposta do Servidor:", response);

            //console.log(response); // Verifique o que está retornando na resposta
            // Preenche o modal com as informações
            $('#marca').text(response.marca);
            $('#placa').text(response.placa);
            $('#chassi').text(response.chassi);
            $('#cor').text(response.cor);
            $('#ano').text(response.ano);
            $('#renavam').text(response.renavam);
            $('#nome').text(response.nome);
            $('#cpf').text(response.cpf);
            $('#cidade').text(response.cidade);
            $('#crv').text(response.crv);
            $('#placa_anterior').text(response.placaAnterior);
            $('#categoria').text(response.categoria);
            $('#motor').text(response.motor);
            $('#combustivel').text(response.combustivel);
            $('#infos').text(response.infos);

            // Exibe o modal
            $('#infoModal').modal('show');
        },
        error: function(xhr, status, error) {
            alert('Erro ao carregar as informações.');
        }
    });
}

</script> 
<script>
    document.addEventListener("DOMContentLoaded", function() {
      var chartsPie = document.querySelectorAll(".chart-pie");
    
      chartsPie.forEach(function(chart) {
        if (!chart.getAttribute('data-chart-initialized')) {
            new Chart(chart, {
            type: "pie",
              data: {
                labels: ["Chrome", "Firefox", "IE"],
                datasets: [{
                  data: [4306, 3801, 1689],
                  backgroundColor: [
                    window.theme?.primary || "#007bff",
                    window.theme?.warning || "#ffc107",
                    window.theme?.danger || "#dc3545"
                  ],
                  borderWidth: 5
                }]
              },
              options: {
                responsive: !window.MSInputMethodContext,
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
    
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Vendor js -->
        <script src="{{ url('assets/js/vendor.min.js') }}"></script>
        <!-- Apex  Charts js -->

        <!-- App js -->
        <script src="{{ url('assets/js/app.min.js') }}"></script>
        <!-- Apex Charts js -->
        <script src="{{ url('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    </body>
</html>
