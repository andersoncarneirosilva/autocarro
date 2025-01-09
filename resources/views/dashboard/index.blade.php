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

@include('dashboard.widgets.widgets')

                    
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
</div><!-- end row-->
                        

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
@endsection
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Vendor js -->
        <script src="{{ url('assets/js/vendor.min.js') }}"></script>
        <!-- Apex  Charts js -->

        <!-- App js -->
        <script src="{{ url('assets/js/app.min.js') }}"></script>
        <!-- Apex Charts js -->
        <script src="{{ url('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    </body>
</html> --}}
