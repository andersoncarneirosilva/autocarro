
<div class="row">
    <div class="col-xl-5 col-lg-6">
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
                <h4 class="header-title">Veículos cadastrados</h4>
                
            </div>
            <div class="card-body pt-0">
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var countDocs = @json($countDocs); // Agora isso será um array com contagens por mês
                
                        var options = {
                            chart: {
                                type: 'bar',
                                height: 230,
                            },
                            plotOptions: {
                                bar: {
                                    barHeight: '70%', // Proporção da altura do gráfico
                                    columnWidth: '30%', // Define a largura das barras como porcentagem
                                }
                            },
                            series: [
                                {
                                    name: 'Veículos',
                                    data: countDocs // Usando o array com as contagens mensais
                                }
                            ],
                            xaxis: {
                                categories: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
                            },
                            title: {
                                text: 'Lançamento anual de veículos',
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
</div> <!-- end row principal -->

<div class="row">
    <div class="col-xl-12 col-lg-12 order-lg-2 order-xl-1">
        <div class="card">
            <div class="d-flex card-header justify-content-between align-items-center">
                <h4 class="header-title">Últimos veículos cadastrados</h4>
            </div>
            @if ($emprestimos)
            <div class="card-body pt-0">
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
                                <td>
                                    @if($emp->crv === "***")
                                    <span class="badge badge-outline-danger">FÍSICO</span>
                                    @else
                                        <!-- Mostre uma mensagem ou deixe em branco -->
                                        <span class="badge badge-outline-success">DIGITAL</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->
            </div> <!-- end card-body-->
            @else
                <div class="alert alert-warning" role="alert">
                    NENHUM RESULTADO ENCONTRADO!
                </div>
            @endif
        </div> <!-- end card-->
    </div> <!-- end col-->

    

</div>