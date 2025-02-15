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
                    @if(auth()->user()->plano == "Premium")
                        Plano
                    @else
                        Crédito
                    @endif
                </h6>
                <h4 class="my-1" id="active-views-count">
                    @if(auth()->user()->plano == "Premium")
                        <span class="link">Premium</span>
                    @elseif(auth()->user()->credito <= 2)
                        <span class="link-danger">R${{ auth()->user()->credito }},00</span>
                        <h4 class="m-0 fw-normal cta-box-title">
                            <a href="{{ url('planos') }}" style="color: #0fb14a;">
                            Adicionar créditos
                        </a></h4>
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
                    {{ number_format($usedSpaceInMB, 0) }} MB usados ({{ number_format($percentUsed, 0) }}%) de {{ $limitInMB }} MB
                </p>
                <div class="progress mb-3">
                    <div class="progress-bar {{ $percentUsed >= 80 ? 'bg-danger' : '' }}" 
                        role="progressbar" 
                        style="width: {{ $percentUsed }}%" 
                        aria-valuenow="{{ $percentUsed }}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        {{ number_format($percentUsed, 0) }}%
                    </div>
                </div>
                
                
            </div>
        </div>
        {{-- <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="m-0 fw-normal cta-box-title">Precisa de suporte?</h4>
                        <h4 class="m-0 fw-normal cta-box-title"><a href="https://api.whatsapp.com/send/?phone=51999047299&text&type=phone_number&app_absent=0" target="_blank" style="color: #0fb14a;">
                            <i class="uil uil-whatsapp"></i> Chame no whats
                        </a></h4>
                    </div>
                    <img class="ms-3 float-end" src="assets/images/svg/email-campaign.svg" width="92" alt="Generic placeholder image">
                </div>
            </div>
            <!-- end card-body -->
        </div> --}}
    </div> <!-- end col -->

    <div class="col-xl-9 col-lg-8">
        <div class="card card-h-100">
            <div class="card-body">
                <h4 class="header-title mb-3">Veículos cadastrados</h4>

                <div dir="ltr">
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
    <div class="col-xl-7 col-lg-12 order-lg-2 order-xl-1">
        <div class="card">
            <div class="d-flex card-header justify-content-between align-items-center">
                <h4 class="header-title">Últimos veículos cadastrados</h4>
            </div>
            @if ($emprestimos->count() != 0)
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <tbody>
                            
                            @foreach ($emprestimos as $emp)
                            <tr>
                                <td>
                                    <span class="text-muted font-13">MARCA</span>
                                    <h5 class="font-14 my-0"><a href="#" class="text-body">{{ $emp->marca }}</a></h5>
                                </td>
                                <td>
                                    <span class="text-muted font-13">Placa</span> <br>
                                    <span class="font-14 mt-0 fw-normal">{{ $emp->placa }}</span>
                                </td>
                                <td>
                                    <span class="text-muted font-13">Cor</span>
                                    <h5 class="font-14 mt-0 fw-normal">{{ $emp->cor }}</h5>
                                </td>
                                <td>
                                    <span class="text-muted font-13">Ano/Modelo</span>
                                    <h5 class="font-14 mt-0 fw-normal">{{ $emp->ano }}</h5>
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
                <div class="alert alert-danger bg-transparent text-danger" role="alert">
                    NENHUM RESULTADO ENCONTRADO!
                </div>
            @endif
        </div> <!-- end card-->
    </div> <!-- end col-->
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title">Agenda</h4>

            </div>

            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-md-7">
                        <div class="calendar-widget"></div>
                    </div>
                    
                    <div class="col-md-5">
                        <ul class="list-unstyled mt-1">
                            @foreach($events as $event)
                            <li class="mb-4">
                                <p class="text-muted mb-1 font-13">
                                    <i class="mdi mdi-calendar"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y - H:i') }}

                                </p>
                                <h5>{{ $event->title }}</h5>
                            </li>
                            @endforeach
                        </ul>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div>
    

</div>