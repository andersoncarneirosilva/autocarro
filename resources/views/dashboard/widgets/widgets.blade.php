<div class="row">
    <div class="col-xl-3 col-lg-4">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class="mdi mdi-robot-happy-outline float-end"></i>
                <h6 class="text-uppercase mt-0">Bem-vindo</h6>
                <h4 class="my-2" id="">{{ explode(' ', auth()->user()->name)[0] }}</h4>
            </div>
        </div>
        <!--end card-->

        <div class="card tilebox-one">
            <div class="card-body">
                <i class="uil uil-window-restore float-end"></i>
                <h6 class="text-uppercase mt-0">
                    @if (auth()->user()->plano == 'Premium')
                        Plano
                    @else
                        Crédito
                    @endif
                </h6>
                <h4 class="my-1" id="active-views-count">
                    @if (auth()->user()->plano == 'Premium')
                        <span class="link">Premium</span>
                    @elseif(auth()->user()->credito <= 2)
                        <span class="link-danger">R${{ auth()->user()->credito }},00</span>
                        <h4 class="m-0 fw-normal cta-box-title">
                            <a href="{{ url('planos') }}" style="color: #0fb14a;">
                                Adicionar créditos
                            </a>
                        </h4>
                    @else
                        <span class="link">R${{ auth()->user()->credito }},00</span>
                    @endif
                </h4>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->

        <div class="card tilebox-one">
            <div class="card-body">
                <i class="mdi mdi-harddisk float-end"></i>
                <h6 class="text-uppercase mt-0">Espaço em disco</h6>
                <p class="text-muted font-12 mb-0">
                    {{ number_format($usedSpaceInMB, 0) }} MB usados ({{ number_format($percentUsed, 0) }}%) de
                    {{ $limitInMB }} MB
                </p>
                <div class="progress mb-3">
                    <div class="progress-bar {{ $percentUsed >= 80 ? 'bg-danger' : '' }}" role="progressbar"
                        style="width: {{ $percentUsed }}%" aria-valuenow="{{ $percentUsed }}" aria-valuemin="0"
                        aria-valuemax="100">
                        {{ number_format($percentUsed, 0) }}%
                    </div>
                </div>


            </div>
        </div>

    </div> <!-- end col -->

    <div class="col-xl-9 col-lg-8">
        <div class="card card-h-100">
            <div class="card-body">
                <h4 class="header-title mb-3">Veículos cadastrados</h4>

                <div dir="ltr">
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
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
                                series: [{
                                    name: 'Veículos',
                                    data: countDocs // Usando o array com as contagens mensais
                                }],
                                xaxis: {
                                    categories: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
                                        'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                                    ]
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
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>

{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
<div class="row">
    
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title">Últimos veículos</h4>
            </div>
            @if ($emprestimos->count() != 0)
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-hover table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Placa</th>
                                    <th scope="col">Ano/Modelo</th>
                                    <th scope="col">Cor</th>
                                    <th scope="col">Doc</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($emprestimos as $emp)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="rounded-circle" src="{{ url("$emp->image") }}"
                                                        alt="" width="31">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    {{ $emp->marca }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $emp->placa }}</td>
                                        <td>{{ $emp->ano }}</td>
                                        <td>
                                            {{ $emp->cor }}
                                        </td>
                                        <td>
                                            @if ($emp->crv === '***')
                                                <span class="badge badge-outline-danger">FÍSICO</span>
                                            @else
                                                <!-- Mostre uma mensagem ou deixe em branco -->
                                                <span class="badge badge-outline-success">DIGITAL</span>
                                            @endif
                                        </td>
                                    </tr> <!-- end tr -->
                                @endforeach

                            </tbody>
                        </table>
                        @else
                            <div class="alert alert-danger bg-transparent text-danger" role="alert">
                                NENHUM RESULTADO ENCONTRADO!
                            </div>
                        @endif
                    </div>
                </div>
            </div> <!-- end col -->
    </div>
    <div class="col-md-6 col-xxl-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title">Documentos</h4>
            </div>

            <div class="card-body pt-2">
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <i class="mdi mdi-car widget-icon bg-primary-lighten text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h5 class="my-0 fw-semibold">Veículos</h5>
                        </div>
                        <h5 class="my-0">{{ $veiculosCount }}</h5>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <i class="mdi mdi-file-document-outline widget-icon bg-warning-lighten text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h5 class="my-0 fw-semibold">CRLV</h5>
                        </div>
                        <h5 class="my-0">{{ $crlvCount }}</h5>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <i class="mdi mdi-file-sign widget-icon bg-success-lighten text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h5 class="my-0 fw-semibold">Procurações assinadas</h5>
                        </div>
                        <h5 class="my-0">{{ $procCount }}</h5>
                    </div>

                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <i class="mdi mdi-file-sign widget-icon bg-danger-lighten text-danger"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h5 class="my-0 fw-semibold">ATPVe assinada</h5>
                        </div>
                        <h5 class="my-0">{{ $atpveCount }}</h5>
                    </div>

                </div>

                <div class="">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <i class="mdi mdi-account-group widget-icon bg-info-lighten text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h5 class="my-0 fw-semibold">Clientes</h5>
                        </div>
                        <h5 class="my-0">{{ $clientesCount }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->

    <div class="col-md-6 col-xxl-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title">Calendário</h4>
            </div>
            <div class="card-body px-2 pb-2 pt-0 mt-n2">
                <div class="calendar-widget"></div>
            </div>
        </div>
    </div> <!-- end col -->
</div>
