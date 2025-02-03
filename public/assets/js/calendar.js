function showNotification(message, eventTitle, eventDate) {
    // Converter eventDate para um objeto Date
    const date = new Date(eventDate);
    
    // Formatar data para formato brasileiro (DD/MM/YYYY)
    const formattedDate = `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}/${date.getFullYear()}`;
    
    $.toast({
        heading: false, // Remove o cabeçalho do toast
        text: `
            <p>${message}</p>
            <p><strong>Evento:</strong> ${eventTitle}</p>
            <p><strong>Data:</strong> ${formattedDate}</p>
        `,
        position: 'top-right',  // Posiciona a notificação no canto superior direito
        stack: false,           // Não empilha notificações
        icon: 'success',        // Ícone de sucesso
        showHideTransition: 'fade',  // Efeito de fade ao aparecer/desaparecer
        hideAfter: 5000,          // A notificação desaparecerá após 3 segundos
        close: false
    });
}

// Exemplo de invocação da função
// Exemplo: Exibe a notificação apenas quando o botão for clicado
$('#show-toast-btn').on('click', () => {
    const eventData = {
        title: 'Licenciamento',
        event_date: '2025-01-04 13:52:00'
    };

    showNotification(
        "Seu evento foi criado com sucesso!",
        eventData.title,
        eventData.event_date
    );
});




!function(l) {
    "use strict";

    function e() {
        this.$body = l("body"),
        //this.$modal = new bootstrap.Modal(document.getElementById("event-modal")),
        this.$modal = document.getElementById("event-modal") ? new bootstrap.Modal(document.getElementById("event-modal")) : null,
        this.$calendar = l("#calendar"),
        this.$formEvent = l("#form-event"),
        this.$btnNewEvent = l("#btn-new-event"),
        this.$btnDeleteEvent = l("#btn-delete-event"),
        this.$btnSaveEvent = l("#btn-save-event"),
        this.$modalTitle = l("#modal-title"),
        this.$calendarObj = null,
        this.$selectedEvent = null
    }

    e.prototype.onEventClick = function(e) {
        if (!this.$modal || !this.$formEvent.length) return; // Verifica se elementos necessários existem

        this.$formEvent[0].reset();
        this.$formEvent.removeClass("was-validated");
        if (this.$btnDeleteEvent.length) this.$btnDeleteEvent.show();
        if (this.$modalTitle.length) this.$modalTitle.text("Editar evento");
        
        this.$modal.show();

    
        // Verifique se e.event existe
        if (e.event) {
            this.$selectedEvent = e.event;

            // Preenche o formulário com os dados do evento
            l("#event-title").val(this.$selectedEvent.title || "");
            l("#event-id-hidden").val(this.$selectedEvent.id || "");
            l("#event-category").val(this.$selectedEvent.classNames[0] || "");
            
            // Cria um objeto Date a partir da data ISO 8601 (em UTC)
            let utcDate = new Date(this.$selectedEvent.startStr); 
            
            // Ajuste manual para o horário de São Paulo (GMT-3) (subtrai 3 horas do UTC)
            let saoPauloDate = new Date(utcDate.getTime() - (0 * 60 * 60 * 1000)); // Subtrai 3 horas em milissegundos
            
            // Ajusta para o formato necessário (YYYY-MM-DDTHH:MM)
            let year = saoPauloDate.getFullYear();
            let month = ('0' + (saoPauloDate.getMonth() + 1)).slice(-2); // Adiciona zero à esquerda
            let day = ('0' + saoPauloDate.getDate()).slice(-2); // Adiciona zero à esquerda
            let hours = ('0' + saoPauloDate.getHours()).slice(-2); // Adiciona zero à esquerda
            let minutes = ('0' + saoPauloDate.getMinutes()).slice(-2); // Adiciona zero à esquerda
            
            // Formatar a data para datetime-local (YYYY-MM-DDTHH:MM)
            let formattedDate = `${year}-${month}-${day}T${hours}:${minutes}`;
            //console.log("Data atual:", formattedDate);
            
            // Preenche o campo com a data formatada corretamente
            l("#event-date").val(formattedDate);
            


        } else {
            //console.error("Evento não encontrado ou 'e.event' está indefinido.");
        }
    };
    
    e.prototype.onSelect = function(e) {
        if (!this.$modal || !this.$formEvent.length) return;

        this.$formEvent[0].reset();
        this.$formEvent.removeClass("was-validated");
        this.$selectedEvent = null;
        if (this.$btnDeleteEvent.length) this.$btnDeleteEvent.hide();
        if (this.$modalTitle.length) this.$modalTitle.text("Criar novo evento");
        this.$modal.show();
        this.$calendarObj.unselect();
    };

    e.prototype.init = function() {
        if (!this.$calendar.length) return;

        var a = this;

        // Initialize FullCalendar
        a.$calendarObj = new FullCalendar.Calendar(a.$calendar[0], {
            locale: 'pt',  // Adicionando o locale para português
            slotDuration: "00:15:00",
            slotMinTime: "08:00:00",
            slotMaxTime: "19:00:00",
            themeSystem: "bootstrap",
            bootstrapFontAwesome: false,
            editable: true,  // Permite mover os eventos
            droppable: true,  // Permite soltar eventos (se necessário)
            selectable: true,
            buttonText: { 
                today: "Hoje", 
                month: "Mês", 
                week: "Semana", 
                day: "Dia", 
                list: "Lista", 
                prev: "Anterior", 
                next: "Próximo" 
            },
            headerToolbar: { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth" },

            // Função chamada quando o evento é movido
            eventDrop: function(info) {
                // Obtém a data do evento e ajusta o fuso horário para GMT-3
                let rawDate = info.event.start.toISOString(); 
                let localDate = new Date(rawDate);
                localDate.setHours(localDate.getHours() - 3);
            
                // Formata para o formato Y-m-d H:i:s
                let formattedDate = localDate.toISOString().replace('T', ' ').slice(0, 19);
            
                // Dados do evento
                let eventData = {
                    id: info.event.id,
                    title: info.event.title, // Título do evento
                    event_date: formattedDate, // Data ajustada corretamente
                    category: info.event.classNames[0] // Categoria do evento
                };
            
                // Enviar solicitação para atualizar o evento no banco de dados
                fetch(`/calendar/move/${eventData.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(eventData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.id) {
                        // ✅ Exibir notificação após mover evento com sucesso
                        showNotification(
                            "Evento atualizado com sucesso!",
                            data.title,        // Novo título
                            data.event_date,   // Nova data formatada
                            data.category      // Nova categoria
                        );
                    } else {
                        console.error("Erro ao mover o evento. Resposta inesperada:", data);
                    }
                })
                .catch(error => console.error('Erro ao tentar mover o evento:', error));
            }
            
            
            
            ,
            events: function(fetchInfo, successCallback, failureCallback) {
                fetch('/calendar/events', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(events => {
                    console.log(events);
                    // Passe cada evento para o FullCalendar
                    successCallback(events.map(event => {
                        return {
                            id: event.id, 
                            title: event.title,
                            start: event.event_date,
                            className: event.category
                        };
                    }));
                })
                .catch(error => {
                    //console.error('Error fetching events:', error);
                    failureCallback(error);
                });
            },
            editable: true,
            droppable: true,
            selectable: true,
            dateClick: function(e) { a.onSelect(e); },
            eventClick: function(e) { a.onEventClick(e); }
        });

        a.$calendarObj.render();

        // Save Event
        a.$btnSaveEvent.on("click", function(e) {
            e.preventDefault();
            var form = a.$formEvent[0];  // Obtém o formulário
            

            // Verifica se o formulário é válido
            if (form.checkValidity()) {
                var eventData = {
                    title: document.getElementById("event-title").value, // Título do evento
                    category: document.getElementById("event-category").value, // Categoria do evento
                    event_date: document.getElementById("event-date").value, // Data do evento
                };
                
                // Verificar se a data fornecida não está vazia
                if (eventData.event_date) {
                    // Criar um objeto Date a partir da data do evento (no formato YYYY-MM-DDTHH:MM)
                    let localDate = new Date(eventData.event_date);
                
                    // Ajuste para o horário de São Paulo (fuso horário GMT-3)
                    // O getTimezoneOffset retorna a diferença entre o horário local e UTC em minutos
                    let timezoneOffset = localDate.getTimezoneOffset() * 60000; // Convertendo minutos para milissegundos
                    let saoPauloDate = new Date(localDate.getTime() - timezoneOffset); // Ajustando para GMT-3 (São Paulo)
                
                    // Verificar se a data foi criada corretamente
                    if (!isNaN(saoPauloDate.getTime())) {
                        // Formatar a data para o formato correto 'YYYY-MM-DD HH:mm:ss'
                        let formattedDate = saoPauloDate.toISOString().slice(0, 19).replace('T', ' ');
                        //console.log("DATA formatada CADASTRO:", formattedDate);  // Verifique a data formatada
                        
                    } else {
                        //console.error("Data inválida fornecida:", eventData.event_date);
                    }
                    
                } else {
                    //console.error("Data não fornecida ou inválida.");
                }
                

                // Atualize eventData com a data formatada
                if (a.$selectedEvent) {
                    let rawDate = document.getElementById("event-date").value;

                    // Criar a data local com a hora fornecida pelo campo datetime-local
                    let localDate = new Date(rawDate);

                    // Ajuste manual para o horário de São Paulo (GMT-3)
                    let timezoneOffset = localDate.getTimezoneOffset() * 60000; // Diferença de minutos para milissegundos
                    let saoPauloDate = new Date(localDate.getTime() - timezoneOffset); // Ajusta para GMT-3

                    // Formata a data para o formato "YYYY-MM-DD HH:mm:ss"
                    let formattedDate = saoPauloDate.toISOString().slice(0, 19).replace('T', ' ');
                    // Cria os dados do evento
                    let eventData = {
                        title: document.getElementById("event-title").value, // Título do evento
                        category: document.getElementById("event-category").value, // Categoria do evento
                        event_date: formattedDate // Data formatada corretamente
                    };
                    // Atualizar evento existente
                    fetch(`/calendar/update/${a.$selectedEvent.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // CSRF token
                        },
                        body: JSON.stringify(eventData),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.id) {
                            // Atualiza o evento no calendário
                            var eventToUpdate = a.$calendarObj.getEventById(a.$selectedEvent.id);
                            if (eventToUpdate) {
                                eventToUpdate.setProp("title", eventData.title);
                                eventToUpdate.setProp("classNames", [eventData.category]);
                                eventToUpdate.setStart(data.event_date);
                                eventToUpdate.setAllDay(data.all_day === 1);
                    
                                // ✅ Exibir notificação após atualização bem-sucedida
                                showNotification(
                                    "Evento atualizado com Sucesso!",
                                    data.title,        // Novo título
                                    data.event_date,   // Nova data
                                    data.category      // Nova categoria
                                );
                            }
                        } else {
                            console.error("Erro ao atualizar o evento. Resposta inesperada:", data);
                        }
                    })
                    .catch(error => {
                        console.error("Erro na requisição:", error);
                    });
                    
                    
                } else {

                    let rawDate = document.getElementById("event-date").value;

// Criar a data local com a hora fornecida pelo campo datetime-local
let localDate = new Date(rawDate);

// Ajuste manual para o horário de São Paulo (GMT-3)
let timezoneOffset = localDate.getTimezoneOffset() * 60000; // Diferença de minutos para milissegundos
let saoPauloDate = new Date(localDate.getTime() - timezoneOffset); // Ajusta para GMT-3

// Formata a data para o formato "YYYY-MM-DD HH:mm:ss"
let formattedDate = saoPauloDate.toISOString().slice(0, 19).replace('T', ' ');

// Cria os dados do evento
let eventData = {
    title: document.getElementById("event-title").value, // Título do evento
    category: document.getElementById("event-category").value, // Categoria do evento
    event_date: document.getElementById("event-date").value,
};
                    // Adicionar novo evento
// Adicionar novo evento
fetch('/calendar', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify(eventData),
})
.then(response => response.json())
.then(data => {
    // Adiciona o novo evento ao calendário
    a.$calendarObj.addEvent({
        id: data.id, // ID do evento retornado pelo backend
        title: eventData.title,
        start: eventData.event_date, // Data correta para o novo evento
        className: eventData.category
    });

    // Exibir a notificação
    showNotification(
        "Evento Criado com Sucesso!",
        data.event.title,
        data.event.event_date,
        data.event.category
    );
    form.reset();
    //console.log(form);
    //document.getElementById("form-event").reset();
    // Adiciona a classe "noti-icon-badge" ao span do navbar
    const navbarBadge = document.querySelector('.noti-icon-badge');
    if (navbarBadge) {
        navbarBadge.classList.add('noti-icon-badge');
    }
})
.catch(error => console.error('Error adding new event:', error));

                }

                // Fecha o modal
                a.$modal.hide();
            } else {
                form.classList.add("was-validated");
            }
        });


        // Função para excluir um evento
        a.$btnDeleteEvent.on("click", function(e) {
            e.preventDefault();
        
            if (a.$selectedEvent && a.$selectedEvent.id) {
                // Usando SweetAlert2 para confirmação
                Swal.fire({
                    title: 'Tem certeza?',
                    text: 'Você deseja excluir este evento?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7066e0',
                    cancelButtonColor: '#6e7881',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Exclui o evento
                        fetch(`/calendar/delete/${a.$selectedEvent.id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove o evento do calendário
                                const eventToDelete = a.$calendarObj.getEventById(a.$selectedEvent.id);
                                if (eventToDelete) {
                                    eventToDelete.remove();
                                    Swal.fire(
                                        'Excluído!',
                                        'O evento foi excluído com sucesso.',
                                        'success'
                                    );
                                    //console.log(data.message); // Log de sucesso
                                }
                                a.$modal.hide(); // Fecha o modal
                            } else {
                                //console.error('Erro ao excluir o evento:', data.message); // Log de erro
                                Swal.fire(
                                    'Erro!',
                                    'Não foi possível excluir o evento.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            //console.error('Erro ao tentar excluir o evento:', error);
                            Swal.fire(
                                'Erro!',
                                'Ocorreu um erro ao excluir o evento.',
                                'error'
                            );
                        });
                    }
                });
            } else {
               // console.error('Nenhum evento selecionado para excluir.');
                Swal.fire(
                    'Erro!',
                    'Nenhum evento selecionado para exclusão.',
                    'error'
                );
            }
            
        });
        



    };

    // Initialize Calendar App
    l.CalendarApp = new e;
    l.CalendarApp.Constructor = e;
}(window.jQuery);

// Start Calendar App
(function() {
    "use strict";
    if (document.getElementById("calendar")) { // Verifica se o calendário existe no DOM antes de inicializar
        window.jQuery.CalendarApp.init();
    }
})();