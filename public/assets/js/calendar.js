!function(l) {
    "use strict";
    let globalEventId = null;

    function e() {
        this.$body = l("body"),
        this.$modal = new bootstrap.Modal(document.getElementById("event-modal")),
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
        this.$formEvent[0].reset();
        this.$formEvent.removeClass("was-validated");
        this.$btnDeleteEvent.show();
        this.$modalTitle.text("Editar evento");
        this.$modal.show();
    
        // Verifique se e.event existe
        if (e.event) {
            console.log('Analisar E: ',e);
            this.$selectedEvent = e.event;
    
            // Preenche o formulário com os dados do evento
            l("#event-title").val(this.$selectedEvent.title);
            l("#event-id-hidden").val(this.$selectedEvent.id);  // Certifique-se que o ID esteja disponível
            l("#event-category").val(this.$selectedEvent.classNames[0]); // Categoria do evento
            l("#event-date").val(this.$selectedEvent.startStr); // Categoria do evento
    
            //console.log('ID do evento selecionado:', this.$selectedEvent.id);
            console.log('Data do EVENTO: ', this.$selectedEvent.startStr);
        } else {
            console.error("Evento não encontrado ou 'e.event' está indefinido.");
        }
    };
    
    e.prototype.onSelect = function(e) {
        this.$formEvent[0].reset(),
        this.$formEvent.removeClass("was-validated"),
        this.$selectedEvent = null,
        this.$btnDeleteEvent.hide(),
        this.$modalTitle.text("Criar novo evento"),
        this.$modal.show(),
        this.$calendarObj.unselect();
    };

    e.prototype.init = function() {
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
                //console.log(info);
                let rawDate = info.event.start.toISOString();
                let formattedDate = rawDate.replace('T', ' ').slice(0, 19); // Mantém a data no formato correto

            
                let eventData = {
                    id: info.event.id,
                    title: info.event.title, // Certifique-se de usar `info.event.title`
                    event_date: formattedDate,
                    category: info.event.classNames[0] // Adicione a categoria do evento
                };
                //console.log(eventData);
                fetch(`/calendar/move/${eventData.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(eventData)
                })
                //console.log('Dados enviados para o backend:', eventData)

                .then(response => response.json())
                .then(data => {
                    //console.log(text);
                    console.log('Evento atualizado com sucesso:', data);

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
                    event_date:  document.getElementById("event-date").value, 
                };
                
                // Verificar se a data fornecida não está vazia
                if (eventData.event_date) {
                    // Tentar criar uma data válida
                    let parsedDate = new Date(eventData.event_date);
                
                    // Verificar se a data foi criada corretamente
                    if (!isNaN(parsedDate.getTime())) {
                        // Formatar a data para o formato correto 'YYYY-MM-DD HH:mm:ss'
                        let formattedDate = parsedDate.toISOString().slice(0, 19).replace('T', ' ');
                        console.log("DATA formatada:", formattedDate);
                    } else {
                        console.error("Data inválida fornecida:", eventData.event_date);
                    }
                } else {
                    console.error("Data não fornecida ou inválida.");
                }

                // Atualize eventData com a data formatada
                //eventData.event_date = formattedDate;
                if (a.$selectedEvent) {
                    let rawDate = document.getElementById("event-date").value;

                    // Formata a data para o formato "YYYY-MM-DD HH:mm:ss"
                    let formattedDate = new Date(rawDate).toISOString().slice(0, 19).replace('T', ' ');

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
                   
                        // Verifica se a resposta contém o evento esperado
                        if (data && data.id) {
                            // Atualiza o evento no calendário com os novos dados
                            var eventToUpdate = a.$calendarObj.getEventById(a.$selectedEvent.id);
                            if (eventToUpdate) {
                                eventToUpdate.setProp("title", eventData.title);  // Atualiza o título do evento
                                eventToUpdate.setProp("classNames", [eventData.category]);  // Atualiza a categoria
                                eventToUpdate.setStart(data.event_date);  // Atualiza a data de início
                                console.log(data.event_date);
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
                    // Obtém a data do formulário
                    let rawDate = document.getElementById("event-date").value;

                    // Formata a data para o formato "YYYY-MM-DD HH:mm:ss"
                    let formattedDate = new Date(rawDate).toISOString().slice(0, 19).replace('T', ' ');

                    // Cria os dados do evento
                    let eventData = {
                        title: document.getElementById("event-title").value, // Título do evento
                        category: document.getElementById("event-category").value, // Categoria do evento
                        event_date: formattedDate // Data formatada corretamente
                    };
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
                        //console.log(text);
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
                                    console.log(data.message); // Log de sucesso
                                }
                                a.$modal.hide(); // Fecha o modal
                            } else {
                                console.error('Erro ao excluir o evento:', data.message); // Log de erro
                                Swal.fire(
                                    'Erro!',
                                    'Não foi possível excluir o evento.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao tentar excluir o evento:', error);
                            Swal.fire(
                                'Erro!',
                                'Ocorreu um erro ao excluir o evento.',
                                'error'
                            );
                        });
                    }
                });
            } else {
                console.error('Nenhum evento selecionado para excluir.');
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
    window.jQuery.CalendarApp.init();
})();
