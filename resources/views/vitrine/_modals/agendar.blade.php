<style>
    /* Estilo do Carrossel de Datas */
.date-carousel-container {
    display: flex;
    overflow-x: auto;
    gap: 10px;
    padding: 10px 0;
    scrollbar-width: none;
}
.date-carousel-container::-webkit-scrollbar { display: none; }

.date-card {
    min-width: 65px;
    height: 80px;
    border: 1px solid #eee;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background: #f8f9fa;
    transition: 0.3s;
}
.date-card.active {
    background: #BF9456 !important;
    color: white !important;
    border-color: #BF9456;
}
.date-card .dia-semana { font-size: 12px; text-transform: uppercase; color: #666; }
.date-card.active .dia-semana { color: #eee; }
.date-card .dia-numero { font-size: 20px; font-weight: bold; }

/* Estilo Seleção de Profissional (Avatar) */
.profissional-item {
    display: inline-block;
    text-align: center;
    margin-right: 15px;
    cursor: pointer;
}
.profissional-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid transparent;
    transition: 0.3s;
    padding: 2px;
}
.profissional-item.active .profissional-avatar {
    border-color: #BF9456;
}
.profissional-name {
    font-size: 12px;
    font-weight: bold;
    color: #BF9456;
    margin-top: 5px;
    display: block;
}
/* Força o scroll interno caso o conteúdo ultrapasse a tela */
#modalAgendamento .modal-body {
    max-height: 70vh; /* Ocupa no máximo 70% da altura da tela */
    overflow-y: auto;
    overflow-x: hidden;
}

/* Personalização da barra de rolagem para ficar mais elegante no Alcecar */
#modalAgendamento .modal-body::-webkit-scrollbar {
    width: 6px;
}
#modalAgendamento .modal-body::-webkit-scrollbar-thumb {
    background-color: #eee;
    border-radius: 10px;
}
/* Horários */
.btn-hora-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    font-weight: 500;
    transition: 0.2s;
}
.btn-hora-card:hover { background: #f0f0f0; }
.btn-hora-card.active { background: #BF9456; color: white; border-color: #BF9456; }
.btn-ocupado { background: #eee; color: #bbb; cursor: not-allowed; border: none; }
</style>

<div class="modal fade" id="modalAgendamento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <div class="w-100 text-center position-relative">
                    <small class="text-uppercase tracking-widest text-muted fw-bold" id="mes_ano_display" style="font-size: 10px;">Fevereiro 2026</small>
                    <button type="button" class="btn-close position-absolute top-0 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            
            <form action="{{ route('agendamento.publico.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="position-relative mb-4">
                        <button type="button" class="btn btn-sm btn-light rounded-circle position-absolute start-0 top-50 translate-middle-y shadow-sm" id="prev_date" style="z-index: 10;"><i class="fa fa-chevron-left"></i></button>
                        <div class="date-carousel-container mx-4" id="data_carousel"></div>
                        <button type="button" class="btn btn-sm btn-light rounded-circle position-absolute end-0 top-50 translate-middle-y shadow-sm" id="next_date" style="z-index: 10;"><i class="fa fa-chevron-right"></i></button>
                    </div>

                    <div class="mb-4 text-center">
                        <label class="form-label fw-bold d-block mb-3 text-start">Com quem você deseja agendar?</label>
                        <div class="d-flex justify-content-start overflow-auto pb-2" id="container_profissionais">
                            @foreach($empresa->profissionais as $func)
    <div class="profissional-item" data-id="{{ $func->id }}">
        @if($func->foto)
            <img src="{{ asset('storage/' . $func->foto) }}" 
                 class="profissional-avatar shadow-sm">
        @else
            <div class="profissional-avatar shadow-sm d-flex align-items-center justify-content-center bg-muted text-primary fw-bold" 
                 style="width: 50px; height: 50px; border-radius: 50%; font-size: 1.2rem; text-transform: uppercase;">
                {{ mb_substr($func->nome, 0, 1) }}
            </div>
        @endif
        <span class="profissional-name text-truncate" style="max-width: 80px;">
            {{ explode(' ', $func->nome)[0] }}
        </span>
    </div>
@endforeach
                        </div>
                        <input type="hidden" name="profissional_id" id="profissional_id_input" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">O que vamos fazer hoje?</label>
                        <select name="servico_id" id="servicos_select" class="form-select border-0 bg-light py-2" required style="border-radius: 10px;">
                            <option value="" selected disabled>Escolha um serviço...</option>
                            @foreach($empresa->servicos as $serv)
                                <option value="{{ $serv->id }}">{{ $serv->nome }} ({{ $serv->duracao }} min)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Horários disponíveis</label>
                        <div id="container_horarios" class="row g-2">
                            <div class="col-12 text-center py-3 bg-light rounded-3">
                                <small class="text-muted">Selecione o profissional e o serviço acima.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 border-top pt-3">
                        <div class="col-md-12 mb-2">
                            <input type="text" name="cliente_nome" class="form-control border-0 bg-light" placeholder="Seu nome completo" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="cliente_whatsapp" class="form-control border-0 bg-light" placeholder="Seu WhatsApp (00) 00000-0000" data-mask="(00) 00000-0000" required style="border-radius: 10px;">
                        </div>
                    </div>

                    <input type="hidden" name="data_agendamento" id="agendamento_data" required>
                    <input type="hidden" name="hora_selecionada" id="hora_selecionada" required>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow" style="border-radius: 15px; font-size: 16px;">
                        Finalizar Agendamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
  
  $(document).ready(function() {
    if ($('#modalSucessoAgendamento').length > 0) {
            var modalSucesso = new bootstrap.Modal(document.getElementById('modalSucessoAgendamento'));
            modalSucesso.show();
        }

    const mesesExtenso = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    const diasSemanaReduzido = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

    // 1. GERA AS DATAS NO TOPO
    function carregarCalendarioAnual() {
        let html = '';
        let hoje = new Date();
        for (let i = 0; i < 60; i++) {
            let data = new Date();
            data.setDate(hoje.getDate() + i);
            let ano = data.getFullYear();
            let mes = String(data.getMonth() + 1).padStart(2, '0');
            let dia = String(data.getDate()).padStart(2, '0');
            let iso = `${ano}-${mes}-${dia}`;
            html += `
                <div class="date-card" data-date="${iso}" data-mesano="${mesesExtenso[data.getMonth()]} ${ano}">
                    <span class="dia-semana">${diasSemanaReduzido[data.getDay()]}</span>
                    <span class="dia-numero">${data.getDate()}</span>
                </div>`;
        }
        $('#data_carousel').html(html);
        const primeiroCard = $('.date-card').first();
        primeiroCard.addClass('active');
        $('#agendamento_data').val(primeiroCard.data('date'));
        $('#mes_ano_display').text(primeiroCard.data('mesano'));
    }

    carregarCalendarioAnual();

    // 2. FUNÇÃO PRINCIPAL DE BUSCA DE HORÁRIOS
    function atualizarGradeHorarios() {
        const profId = $('#profissional_id_input').val();
        const dataSel = $('#agendamento_data').val();
        const servId = $('#servicos_select').val();

        if (!profId || !dataSel || !servId) return;

        $('#container_horarios').html('<div class="col-12 text-center py-4"><div class="spinner-border text-primary spinner-border-sm"></div></div>');

        // USANDO A ROTA CORRETA: profissional/{id}/horarios
        $.get(`/profissional/${profId}/horarios`, { 
            data: dataSel, 
            servicos_ids: [servId] // Enviado como array para compatibilidade
        })
        .done(function(response) {
            let html = '';
            if (response.grade && response.grade.length > 0) {
                response.grade.forEach(item => {
                    html += `
                        <div class="col-3">
                            <div class="btn-hora-card ${item.ocupado ? 'btn-ocupado' : ''}" data-hora="${item.hora}">
                                ${item.hora}
                            </div>
                        </div>`;
                });
                $('#container_horarios').html(html);
            } else {
                $('#container_horarios').html('<div class="col-12 text-center py-4 bg-light rounded"><p class="text-muted m-0 small">Nenhum horário disponível para este dia.</p></div>');
            }
        })
        .fail(function() {
            $('#container_horarios').html('<div class="col-12 text-center py-4"><p class="text-danger small">Erro ao carregar horários.</p></div>');
        });
    }

    // 3. EVENTOS DE CLIQUE E MUDANÇA
    $(document).on('click', '.date-card', function() {
        $('.date-card').removeClass('active');
        $(this).addClass('active');
        $('#mes_ano_display').text($(this).data('mesano'));
        $('#agendamento_data').val($(this).data('date'));
        atualizarGradeHorarios();
    });

    $(document).on('click', '.profissional-item', function() {
        $('.profissional-item').removeClass('active');
        $(this).addClass('active');
        $('#profissional_id_input').val($(this).data('id'));
        atualizarGradeHorarios();
    });

    $('#servicos_select').on('change', atualizarGradeHorarios);

    $(document).on('click', '.btn-hora-card:not(.btn-ocupado)', function() {
        $('.btn-hora-card').removeClass('active');
        $(this).addClass('active');
        $('#hora_selecionada').val($(this).data('hora'));
    });

    // SETAS DO CARROSSEL
    const carousel = document.getElementById('data_carousel');
    $('#next_date').on('click', () => carousel.scrollBy({ left: 200, behavior: 'smooth' }));
    $('#prev_date').on('click', () => carousel.scrollBy({ left: -200, behavior: 'smooth' }));
});

</script>
@endpush