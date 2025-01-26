<div class="row">
    <div class="col-xl-3 col-lg-4">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class="mdi mdi-robot-happy-outline float-end"></i>
                <h6 class="text-uppercase mt-0">Bem-vindo</h6>
                <h3 class="my-2" id="">{{ auth()->user()->name }}</h3>
            </div>
        </div>
        <!--end card-->

        <div class="card tilebox-one">
            <div class="card-body">
                <i class="uil uil-window-restore float-end"></i>
                <h6 class="text-uppercase mt-0">
                    @if(auth()->user()->plano == "Mensal")
                    Plano
                    @else
                    Saldo
                    @endif
                </h6>
                <h3 class="my-2" id="active-views-count">
                    @if(auth()->user()->plano == "Mensal")
                        <span class="link">Premium</span>
                    @elseif(auth()->user()->credito <= 2)
                        <span class="link-danger">R${{ auth()->user()->credito }},00</span>
                        <h4 class="m-0 fw-normal cta-box-title">
                            <a href="https://api.whatsapp.com/send/?phone=51999047299&text&type=phone_number&app_absent=0" target="_blank" style="color: #0fb14a;">
                            Chame no whats
                        </a></h4>
                    @else
                        <span class="link">R${{ auth()->user()->credito }},00</span>
                    @endif
                </h3>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->

        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="m-0 fw-normal cta-box-title">Precisa de suporte?</h4>
                        <h4 class="m-0 fw-normal cta-box-title"><a href="https://api.whatsapp.com/send/?phone=51999047299&text&type=phone_number&app_absent=0" target="_blank" style="color: #0fb14a;">
                            <i class="uil uil-whatsapp"></i> Chame no whats
                        </a></h4>
                    </div>
                    <img class="ms-3" src="assets/images/svg/email-campaign.svg" width="92" alt="Generic placeholder image">
                </div>
            </div>
            <!-- end card-body -->
        </div>
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