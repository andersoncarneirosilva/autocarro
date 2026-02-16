<div class="container-fluid footer position-relative bg-dark text-white-50 py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-6 pe-lg-5">
                <a href="#" class="navbar-brand">
                    <h1 class="display-5 text-primary mb-0 text-capitalize">
    <i class="bi bi-scissors"></i> {{ $empresa->razao_social }}
</h1>
                </a>
                <p class="mt-4">Proporcionando beleza e bem-estar com excelência. Agende seu horário e venha viver uma experiência única em nosso salão.</p>
                
                <p class="mb-2"><i class="fa fa-map-marker-alt me-2"></i>{{ $empresa->endereco ?? 'Endereço a consultar' }}</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-2"></i>{{ $empresa->whatsapp }}</p>
                
                @if($empresa->cnpj)
                    <p class="mb-2 small"><i class="fa fa-id-card me-2"></i>CNPJ: {{ $empresa->cnpj }}</p>
                @endif

                @if($empresa->whatsapp || (isset($empresa->configuracoes['instagram']) && $empresa->configuracoes['instagram']) || (isset($empresa->configuracoes['facebook']) && $empresa->configuracoes['facebook']))
                    <div class="d-flex justify-content-start mt-4">
                        
                        {{-- Instagram --}}
                        @if(isset($empresa->configuracoes['instagram']) && $empresa->configuracoes['instagram'])
                            <a class="btn btn-sm-square btn-primary me-3" href="https://instagram.com/{{ $empresa->configuracoes['instagram'] }}" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif

                        {{-- Facebook --}}
                        @if(isset($empresa->configuracoes['facebook']) && $empresa->configuracoes['facebook'])
                            <a class="btn btn-sm-square btn-primary me-3" href="https://facebook.com/{{ $empresa->configuracoes['facebook'] }}" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif

                        {{-- WhatsApp --}}
                        @if($empresa->whatsapp)
                            <a class="btn btn-sm-square btn-primary me-3" href="https://wa.me/55{{ preg_replace('/\D/', '', $empresa->whatsapp) }}" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif

                    </div>
                @endif
            </div>
            <div class="col-lg-6 ps-lg-5">
    <div class="row g-4">
        <div class="col-sm-6">
            <h5 class="text-primary mb-4">Acesso Rápido</h5>
            <a class="btn btn-link" href="#pagina-inicial">Sobre Nós</a>
            <a class="btn btn-link" href="#servicos">Serviços</a>
            <a class="btn btn-link" href="#valores">Valores</a>
            <a class="btn btn-link" href="#equipe">Nossa Equipe</a>
        </div>
        
        <div class="col-sm-6">
            <h5 class="text-primary mb-4">Horário de Atendimento</h5>
            @php
                // Pegamos o primeiro profissional ou a média de horários da empresa
                $profissional = $empresa->profissionais->first(); 
                $horarios = is_string($profissional->horarios) ? json_decode($profissional->horarios, true) : $profissional->horarios;
                
                // Dias da semana para ordenação
                $diasOrdem = ['segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado', 'domingo'];
            @endphp

            @if($horarios)
                <ul class="list-unstyled">
                    @foreach($diasOrdem as $dia)
                        @if(isset($horarios[$dia]) && $horarios[$dia]['trabalha'] == "1")
                            <li class="d-flex justify-content-between mb-1">
                                <span class="text-white text-capitalize">{{ $dia }}:</span>
                                <span class="text-muted">{{ $horarios[$dia]['inicio'] }} - {{ $horarios[$dia]['fim'] }}</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Consulte disponibilidade ao agendar.</p>
            @endif
        </div>

        <div class="col-sm-12">
            <h5 class="text-primary mb-4">Agendamento Online</h5>
            <div class="d-flex align-items-center bg-dark p-3 rounded border border-secondary">
                <div class="flex-shrink-0 btn-lg-square bg-primary rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fa fa-calendar-check text-dark"></i>
                </div>
                <div class="ms-3">
                    <p class="mb-2 text-white-50 small">Disponível 24h para marcações</p>
                    <button class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#modalAgendamento">
                        Agendar Agora
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
<div class="container-fluid bg-dark text-white border-top border-secondary py-4 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                &copy; {{ date('Y') }}
                Desenvolvido por <a class="" href="https://pixdesign.com.br" target="_blank">Pix Design</a> <i class="fa fa-heart text-danger"></i> 
            </div>
            <div class="col-md-6 text-center text-md-end">
                
            </div>
        </div>
    </div>
</div>