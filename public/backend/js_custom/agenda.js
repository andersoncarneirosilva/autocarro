document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    // 1. SÓ EXECUTA SE O CALENDÁRIO EXISTIR
    if (!calendarEl) return;

    // 2. BUSCA O ELEMENTO DO MODAL COM SEGURANÇA
    var modalCadEl = document.getElementById('modalCadastrarAgenda');
    // Usamos getOrCreateInstance para evitar conflitos de backdrop
    var modalCad = modalCadEl ? bootstrap.Modal.getOrCreateInstance(modalCadEl) : null;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        initialView: 'dayGridMonth',
        selectable: true, 
        slotMinTime: '06:00:00',
        slotMaxTime: '22:00:00',
        allDaySlot: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hoje', month: 'Mês', week: 'Semana', day: 'Dia'
        },

        events: '/api/agenda/eventos', 

        dateClick: function(info) {
            if (!modalCad) return; // Se o modal não existir na página, não faz nada

            let dataClicada = info.dateStr.split('T')[0];
            
            // 1. Limpa seleções anteriores e define a nova data
            $('#agendamento_data').val(dataClicada);
            $('.date-card').removeClass('active');
            
            let $card = $(`.date-card[data-date="${dataClicada}"]`);
            if($card.length > 0) {
                $card.addClass('active');
                $('#mes_ano_display').text($card.data('mesano'));
            }

            // 2. Abre o modal usando a instância já criada
            modalCad.show();

            // 3. Scroll suave após abertura
            setTimeout(() => {
                if($card.length > 0) {
                    $card[0].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                }
                if(typeof atualizarHorarios === "function") atualizarHorarios();
            }, 400);
        },

        // Dentro do seu FullCalendar { ... }

eventClick: function(info) {
    var modalConcluirEl = document.getElementById('modalConcluirAtendimento');
    if (!modalConcluirEl) return;
    
    var modalConcluir = bootstrap.Modal.getOrCreateInstance(modalConcluirEl);
    
    // Agora os dados existem!
    const agendaId = info.event.id;
    const cliente  = info.event.title;
    const status   = info.event.extendedProps.status;
    const valor    = info.event.extendedProps.valor_total || 0;
    const servico  = info.event.extendedProps.servico;

    // Bloqueia se já estiver concluído
    if (status === 'Concluído') {
        alert('Este atendimento já foi finalizado.');
        return;
    }

    // Preenche os campos do modal
    $('#concluir_agenda_id').val(agendaId);
    $('#concluir_cliente_nome').text(cliente);
    $('#concluir_servico_info').text(servico);
    
    // Formatação segura
    $('#concluir_valor_total').text('R$ ' + parseFloat(valor).toLocaleString('pt-br', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }));

    modalConcluir.show();
},
        
        eventDidMount: function(info) {
            if (info.event.backgroundColor) {
                info.el.style.setProperty('background-color', info.event.backgroundColor, 'important');
                info.el.style.setProperty('border-color', info.event.backgroundColor, 'important');
            }
        }
    });

    $('#formConcluirAtendimento').on('submit', function(e) {
    e.preventDefault();
    const btn = $(this).find('button[type="submit"]');
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

    $.ajax({
        url: '/agenda/concluir',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
    // 1. Fecha o modal
    const modalElement = document.getElementById('modalConcluirAtendimento');
    bootstrap.Modal.getInstance(modalElement).hide();

    // 2. Recarrega os eventos no calendário
    calendar.refetchEvents();

    // 3. Dispara o Toast padrão do Alcecar via SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'success',
        title: response.message || 'Atendimento concluído com sucesso!'
    });
},
error: function(xhr) {
    const message = xhr.responseJSON ? xhr.responseJSON.message : 'Erro ao concluir atendimento';
    
    Swal.fire({
        icon: 'error',
        title: 'Ops!',
        text: message,
        confirmButtonColor: '#727cf5'
    });
},
        error: function() {
            alert('Erro ao concluir atendimento.');
        },
        complete: function() {
            btn.prop('disabled', false).text('Finalizar e Baixar');
        }
    });
});

    calendar.render();
});