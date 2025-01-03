!function(l) {
    "use strict";
    let globalEventId = null;

    function e() {
        this.$body = l("body"),
        this.$modal = new bootstrap.Modal(document.getElementById("event-modal"), { backdrop: "static" }),
        this.$calendar = l("#calendar"),
        this.$formEvent = l("#form-event"),
        this.$btnNewEvent = l("#btn-new-event"),
        this.$btnDeleteEvent = l("#btn-delete-event"),
        this.$btnSaveEvent = l("#btn-save-event"),
        this.$modalTitle = l("#modal-title"),
        this.$calendarObj = null,
        this.$selectedEvent = null,
        this.$newEventData = null;
    }

    e.prototype.onEventClick = function(e) {
        this.$formEvent[0].reset();
        this.$formEvent.removeClass("was-validated");
        this.$newEventData = null;
        this.$btnDeleteEvent.show();
        this.$modalTitle.text("Edit Event");
        this.$modal.show();
    
        // Verifique se e.event existe
        if (e.event) {
            this.$selectedEvent = e.event;
    
            // Preenche o formulário com os dados do evento
            l("#event-title").val(this.$selectedEvent.title);
            l("#event-id-hidden").val(this.$selectedEvent.id);  // Certifique-se que o ID esteja disponível
            l("#event-category").val(this.$selectedEvent.classNames[0]); // Categoria do evento
            l("#event-date").val(this.$selectedEvent.event_date); // Categoria do evento
    
            console.log('ID do evento selecionado:', this.$selectedEvent.id);  // Exibe o ID para debug
        } else {
            console.error("Evento não encontrado ou 'e.event' está indefinido.");
        }
    };
    
    e.prototype.onSelect = function(e) {
        this.$formEvent[0].reset(),
        this.$formEvent.removeClass("was-validated"),
        this.$selectedEvent = null,
        this.$newEventData = e,
        this.$btnDeleteEvent.hide(),
        this.$modalTitle.text("Add New Event"),
        this.$modal.show(),
        this.$calendarObj.unselect();
    };

    e.prototype.init = function() {
        var a = this;

        // Initialize FullCalendar
        a.$calendarObj = new FullCalendar.Calendar(a.$calendar[0], {
            slotDuration: "00:15:00",
            slotMinTime: "08:00:00",
            slotMaxTime: "19:00:00",
            themeSystem: "bootstrap",
            bootstrapFontAwesome: false,
            buttonText: { today: "Today", month: "Month", week: "Week", day: "Day", list: "List", prev: "Prev", next: "Next" },
            initialView: "dayGridMonth",
            handleWindowResize: true,
            height: l(window).height() - 200,
            headerToolbar: { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth" },
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
                    
                    // Passe cada evento para o FullCalendar
                    successCallback(events.map(event => {
                        return {
                            id: event.id, 
                            title: event.title,
                            start: event.event_date,
                            className: event.category,  // Aplique a classe de cor do evento
                            allDay: event.all_day
                        };
                    }));
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
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
                    //event_date: a.$newEventData.date, // Data do evento (provavelmente definida em outro lugar)
                    //allDay: a.$newEventData.allDay // Evento de dia inteiro
                    event_date: a.$newEventData && a.$newEventData.date 
                    ? a.$newEventData.date 
                    : (a.$selectedEvent ? a.$selectedEvent.start.toISOString().slice(0, 19).replace("T", " ") : null),  // Se não, pega a data do evento selecionado
                    allDay: a.$newEventData && a.$newEventData.allDay !== undefined ? a.$newEventData.allDay : (a.$selectedEvent ? a.$selectedEvent.allDay : false) // Se não, pega o allDay do evento selecionado
                };

                if (a.$selectedEvent) {
                    console.log('ID DO SELECTED EVENT:', a.$selectedEvent.id);
                    // Atualizar evento existente
                    fetch(`/calendar/${a.$selectedEvent.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // CSRF token
                        },
                        body: JSON.stringify(eventData),
                    })
                    .then(response => response.json())
                    
                    .then(data => {
                        // Log da resposta do servidor
                        console.log('Resposta do servidor:', data);
                    
                        // Verifica se a resposta contém o evento esperado
                        if (data && data.id) {
                            // Atualiza o evento no calendário com os novos dados
                            var eventToUpdate = a.$calendarObj.getEventById(a.$selectedEvent.id);
                            if (eventToUpdate) {
                                eventToUpdate.setProp("title", eventData.title);  // Atualiza o título do evento
                                eventToUpdate.setProp("classNames", [eventData.category]);  // Atualiza a categoria
                                eventToUpdate.setStart(data.event_date);  // Atualiza a data de início
                                eventToUpdate.setAllDay(data.all_day === 1);  // Atualiza o status de 'allDay' (1 é verdadeiro, 0 é falso)
                            } else {
                                console.error('Evento não encontrado no calendário para atualizar');
                            }
                        } else {
                            console.error("Erro ao atualizar o evento. Resposta inesperada:", data);  // Log caso a resposta não tenha os dados esperados
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao tentar atualizar o evento:', error);  // Log de erro
                    });
                    
                } else {
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
                            id: data.id,  // ID do evento retornado pelo backend
                            title: eventData.title,
                            start: eventData.event_date,  // Data correta para o novo evento
                            allDay: eventData.allDay,
                            className: eventData.category
                        });
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
        // Confirmar a exclusão
        if (confirm("Você tem certeza que deseja excluir este evento?")) {
            // Enviar a requisição DELETE para o servidor
            fetch(`/calendar/${a.$selectedEvent.id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // CSRF token
                }
            })
            .then(response => response.json())
            .then(data => {
                // Verifica se a exclusão foi bem-sucedida
                if (data.success) {
                    // Remove o evento do calendário
                    var eventToDelete = a.$calendarObj.getEventById(a.$selectedEvent.id);
                    if (eventToDelete) {
                        eventToDelete.remove();
                        console.log('Evento excluído com sucesso.');
                    } else {
                        console.error('Evento não encontrado para excluir.');
                    }

                    // Fecha o modal
                    a.$modal.hide();
                } else {
                    console.error('Erro ao excluir o evento:', data.message);
                }
            })
            .catch(error => console.error('Erro ao tentar excluir o evento:', error));
        }
    } else {
        console.error('Nenhum evento selecionado para excluir.');
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
    window.jQuery.CalendarApp.init();
})();
