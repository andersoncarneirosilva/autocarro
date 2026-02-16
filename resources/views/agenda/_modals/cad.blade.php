<style>
/* Ajuste para o Modal Rolar */
#modalCadastrarAgenda .modal-body {
    max-height: 70vh; /* Limita a altura do corpo */
    overflow-y: auto; /* Ativa a rolagem interna */
    scrollbar-width: thin;
}

/* Carousel de Datas - Menores */
.date-carousel-container {
    display: flex;
    overflow-x: auto;
    gap: 8px;
    padding-bottom: 10px;
    scrollbar-width: none;
}
.date-carousel-container::-webkit-scrollbar { display: none; }

.date-card {
    min-width: 55px; /* Reduzido de 65px */
    height: 70px;    /* Reduzido de 85px */
    border: 1px solid #e9ecef;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background: #fff;
    transition: all 0.2s ease;
}

.date-card.active {
    background-color: #007bff !important;
    border-color: #007bff !important;
    color: #fff !important;
}

.date-card .dia-semana { font-size: 0.65rem; text-transform: uppercase; margin-bottom: 2px; opacity: 0.8; }
.date-card .dia-numero { font-size: 1rem; font-weight: 700; }

/* Grid de Horários - Mais compactos */
.btn-hora-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 8px 4px; /* Reduzido de 15px */
    text-align: center;
    font-size: 0.85rem; /* Fonte levemente menor */
    font-weight: 600;
    transition: all 0.2s;
    cursor: pointer;
    color: #333;
    display: block;
    width: 100%;
}
.nav-arrows button {
    width: 30px;
    height: 30px;
    padding: 0;
    line-height: 1;
    border-color: #eee;
}
.nav-arrows button:hover {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}
#data_carousel {
    scroll-behavior: smooth;
    display: flex;
    overflow-x: auto;
    gap: 8px;
}
.btn-hora-card:hover { border-color: #007bff; background: #f8fbff; }

.btn-hora-card.active {
    background-color: #007bff !important;
    color: #fff !important;
    border-color: #007bff !important;
    box-shadow: 0 2px 6px rgba(0, 123, 255, 0.3);
}
</style>
<style>
.btn-hora-card.btn-ocupado {
    background-color: #f2f2f2 !important;
    color: #bbb !important;
    border-color: #ddd !important;
    cursor: not-allowed !important;
    text-decoration: line-through;
    opacity: 0.6;
}
.btn-hora-card.btn-ocupado:hover {
    background-color: #f2f2f2 !important;
    border-color: #ddd !important;
}
</style>
<div class="modal fade" id="modalCadastrarAgenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-dark fw-bold">
                    <i class="mdi mdi-calendar-plus me-1"></i> Novo Agendamento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('agenda.store') }}" method="POST" style="overflow-y: auto;">
                @csrf
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Cliente <span class="text-danger">*</span></label>
                            <select id="cliente_nome_select" class="form-control select2" required>
                                <option value=""></option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" data-telefone="{{ $cliente->telefone }}">
                                        {{ $cliente->nome }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <input type="hidden" name="cliente_nome" id="cliente_nome_input">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Profissional <span class="text-danger">*</span></label>
                            <select name="profissional_id" id="profissional_select" class="form-control select2" required>
                                <option value=""></option>
                                @foreach($profissional as $func)
                                    <option value="{{ $func->id }}">{{ $func->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
    <label class="form-label fw-semibold">Serviço <span class="text-danger">*</span></label>
    <select name="servicos_ids" id="servicos_select" class="form-select" required>
        <option value="" selected disabled>Selecione um serviço...</option>
        @foreach($servicos as $serv)
            <option value="{{ $serv->id }}">{{ $serv->nome }} ({{ $serv->duracao }} min)</option>
        @endforeach
    </select>
</div>

                        <div class="col-md-12 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold m-0" id="mes_ano_display">Carregando...</h6>
        <div class="nav-arrows">
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" id="prev_date"><i class="mdi mdi-chevron-left"></i></button>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" id="next_date"><i class="mdi mdi-chevron-right"></i></button>
        </div>
    </div>
    <div class="date-carousel-container" id="data_carousel">
        </div>
    <input type="hidden" name="data_agendamento" id="agendamento_data" required>
    <input type="hidden" name="hora_selecionada" id="hora_selecionada" required>
</div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Horários Disponíveis</label>
                            <div id="container_horarios" class="row g-2">
                                </div>
                        </div>

                        
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4">Confirmar Agendamento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    // 1. CONFIGURAÇÕES E CONSTANTES
    const mesesExtenso = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    const diasSemanaReduzido = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
    const diasSemanaFull = {0:'domingo', 1:'segunda', 2:'terça', 3:'quarta', 4:'quinta', 5:'sexta', 6:'sábado'};
    const carousel = document.getElementById('data_carousel');

    // 2. INICIALIZAÇÃO DO SELECT2 (Uma única vez)
    function initSelect2() {
        // Clientes
        $('#cliente_nome_select').select2({
        dropdownParent: $('#modalCadastrarAgenda'),
        width: '100%',
        tags: true, // Permite digitar nomes novos
        placeholder: "Procure ou digite o nome do cliente..."
    }).on('select2:select select2:change', function (e) {
        // Captura o TEXTO da opção selecionada (o Nome)
        var data = $('#cliente_nome_select').select2('data')[0];
        var nomeSelecionado = data ? data.text : '';
        
        // Atualiza o input oculto que será enviado ao Controller
        $('#cliente_nome_input').val(nomeSelecionado);

        // Se o cliente já existir, preenche o telefone automaticamente
        var elemento = $(e.params?.data?.element);
        var telefone = elemento.data('telefone');
        if(telefone) {
            $('input[name="cliente_telefone"]').val(telefone);
        }
    });

        // Profissional
        $('#profissional_select').select2({
            dropdownParent: $('#modalCadastrarAgenda'),
            width: '100%',
            placeholder: "Selecione o profissional..."
        });
    }

    // 3. FUNÇÕES DO CALENDÁRIO E HORÁRIOS
    function carregarCalendarioAnual() {
    let html = '';
    let hoje = new Date();
    
    for (let i = 0; i < 365; i++) {
        let data = new Date();
        data.setDate(hoje.getDate() + i);
        // Usar local date string para evitar problemas de fuso horário/ontem
        let ano = data.getFullYear();
        let mes = String(data.getMonth() + 1).padStart(2, '0');
        let dia = String(data.getDate()).padStart(2, '0');
        let iso = `${ano}-${mes}-${dia}`;
        
        let mesNome = mesesExtenso[data.getMonth()];

        html += `
            <div class="date-card" data-date="${iso}" data-mesano="${mesNome} ${ano}">
                <span class="dia-semana">${diasSemanaReduzido[data.getDay()]}</span>
                <span class="dia-numero">${data.getDate()}</span>
            </div>`;
    }
    $('#data_carousel').html(html);
    // REMOVEMOS O RESET DE INPUTS DAQUI
}

    function atualizarHorarios() {
    let profId = $('#profissional_select').val();
    let dataSel = $('#agendamento_data').val();
    let servicoId = $('#servicos_select').val(); // Pega apenas um ID agora
    
    // Só dispara a busca se tiver o Profissional E o Serviço selecionados
    if (!profId || !dataSel || !servicoId) {
        $('#container_horarios').html('<div class="col-12 text-center py-4 bg-light rounded"><p class="text-muted m-0 small">Selecione o profissional e o serviço para ver horários.</p></div>');
        return;
    }

    $('#container_horarios').html('<div class="col-12 text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div></div>');

    $.get(`/profissional/${profId}/horarios`, { 
        data: dataSel, 
        servicos_ids: [servicoId] // Enviamos como array para manter compatibilidade com o Controller que já fizemos
    })
    .done(function(response) {
        let container = $('#container_horarios');
        container.empty();

        if (response.error) {
            container.html(`<div class="col-12 text-center py-4 bg-light rounded"><p class="text-danger m-0 fw-bold">${response.error}</p></div>`);
            return;
        }

        if (response.grade && response.grade.length > 0) {
            response.grade.forEach(item => {
                container.append(`
                    <div class="col-3 col-md-2">
                        <div class="btn-hora-card ${item.ocupado ? 'btn-ocupado' : ''}" 
                             data-hora="${item.hora}">
                            ${item.hora}
                        </div>
                    </div>
                `);
            });
        } else {
            container.html('<div class="col-12 text-center py-4 bg-light rounded"><p class="text-warning m-0 fw-bold">Nenhum horário disponível para este serviço.</p></div>');
        }
    });
}

// Evento de mudança no select de serviço único
$('#servicos_select').on('change', atualizarHorarios);

    function renderizarHorariosGrid(config) {
    let container = $('#container_horarios');
    container.empty();

    if (!config || config.trabalha == "0") {
        container.html('<div class="col-12 text-center py-4 bg-light rounded"><p class="text-danger m-0 font-weight-bold">Não trabalha neste dia.</p></div>');
        return;
    }

    // Pega a lista de horários ocupados (vinda da sua API)
    // Se a sua API ainda não envia, garantimos que seja um array vazio para não quebrar
    let ocupados = config.ocupados || []; 

    let atual = config.inicio;
    while (atual <= config.fim) {
        // Verifica se o horário atual está na lista de ocupados
        let estaOcupado = ocupados.includes(atual);
        
        container.append(`
            <div class="col-3 col-md-2">
                <div class="btn-hora-card ${estaOcupado ? 'btn-ocupado' : ''}" 
                     data-hora="${atual}" 
                     ${estaOcupado ? 'title="Horário já reservado"' : ''}>
                    ${atual}
                </div>
            </div>
        `);

        let [h, m] = atual.split(':').map(Number);
        m += 30; if (m >= 60) { h++; m = 0; }
        atual = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
        if (atual > config.fim) break;
    }
}

    // 4. EVENTOS (DELEGADOS)
    $(document).on('click', '.date-card', function() {
        $('.date-card').removeClass('active');
        $(this).addClass('active');
        $('#mes_ano_display').text($(this).data('mesano'));
        $('#agendamento_data').val($(this).data('date'));
        atualizarHorarios();
    });

    $(document).on('click', '.btn-hora-card', function() {
    if ($(this).hasClass('btn-ocupado')) {
        return; // Não faz nada se estiver ocupado
    }
    $('.btn-hora-card').removeClass('active');
    $(this).addClass('active');
    $('#hora_selecionada').val($(this).data('hora'));
});

    $('#profissional_select').on('change', atualizarHorarios);

    $('#next_date').on('click', () => carousel.scrollBy({ left: 250, behavior: 'smooth' }));
    $('#prev_date').on('click', () => carousel.scrollBy({ left: -250, behavior: 'smooth' }));

    if(carousel) {
        carousel.addEventListener('scroll', () => {
            const cards = document.querySelectorAll('.date-card');
            for (let card of cards) {
                let rect = card.getBoundingClientRect();
                if (rect.left >= carousel.getBoundingClientRect().left) {
                    $('#mes_ano_display').text(card.getAttribute('data-mesano'));
                    break;
                }
            }
        });
    }

    // 5. EXECUÇÃO INICIAL
    initSelect2();
    carregarCalendarioAnual();

    // Lógica de seleção inicial inteligente
let inputData = $('#agendamento_data');
if (inputData.val()) {
    // Se já tem data (clique no FullCalendar), ativa o card correspondente
    let dataJaDefinida = inputData.val();
    let card = $(`.date-card[data-date="${dataJaDefinida}"]`);
    if (card.length > 0) {
        card.addClass('active');
        $('#mes_ano_display').text(card.data('mesano'));
        // Faz o scroll até ele
        card[0].scrollIntoView({ behavior: 'auto', inline: 'center' });
    }
} else {
    // Se está vazio (abriu pelo botão Novo), marca o primeiro (Hoje)
    const primeiroCard = $('.date-card').first();
    primeiroCard.addClass('active');
    inputData.val(primeiroCard.data('date'));
    $('#mes_ano_display').text(primeiroCard.data('mesano'));
}
});
</script>