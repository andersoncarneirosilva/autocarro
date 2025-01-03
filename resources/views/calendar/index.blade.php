@extends('layouts.app')

@section('title', 'Usuários')

@section('content')



{{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap5',
        locale: 'pt-br',
        events: function(info, successCallback, failureCallback) {
            // Requisição AJAX para carregar eventos
            fetch('/calendar/events')
                .then(response => response.json())
                .then(data => successCallback(data))
                .catch(error => failureCallback(error));
        },
        dateClick: function(info) {
            document.getElementById('eventDate').value = info.dateStr;
            $('#eventModal').modal('show');
        },
        eventClick: function(info) {
            console.log("Evento ID: " . info); // Verifique o objeto completo do evento
            console.log(info.event.id); // Verifique se o ID está correto
            // Preenche os campos do modal de edição com os dados do evento
            document.getElementById('editEventTitle').value = info.event.title;
            document.getElementById('editEventDescription').value = info.event.extendedProps.description;
            document.getElementById('editEventDate').value = info.event.start.toISOString().slice(0, 16); // Formata a data para o input "datetime-local"
            document.getElementById('editEventId').value = info.event.id;

            // Exibe o modal de edição
            $('#editEventModal').modal('show');
        }
    });
    calendar.render();
    calendar.refetchEvents();  // Recarrega todos os eventos do servidor

    // Evento para salvar o novo evento
    document.getElementById('saveEventBtn').addEventListener('click', function() {
        var eventTitle = document.getElementById('eventTitle').value;
        var eventDescription = document.getElementById('eventDescription').value;
        var eventDate = document.getElementById('eventDate').value;

        if (eventTitle && eventDate) {
            // Enviar dados via AJAX para o backend
            fetch('/calendar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    title: eventTitle,
                    description: eventDescription,
                    event_date: eventDate
                })
            })
            .then(response => response.json()) // Espera a resposta JSON do backend
            .then(data => {
                
                if (data) {
                    // Adicionar evento ao FullCalendar
                    calendar.addEvent({
                        id: data.eventId,
                        title: data.title,
                        start: data.event_date,
                        description: data.description
                    });

                    // Fecha o modal
                    $('#eventModal').modal('hide');

                    // Limpar o formulário
                    document.getElementById('eventForm').reset();
                }
            })
            .catch(error => {
                console.error('Erro ao salvar evento:', error);
            });
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });



// Para excluir evento
document.getElementById('deleteEventBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Previne a navegação padrão
    var eventId = 13;
console.log('ID EVENTO: ', eventId);
    fetch('/calendar/delete/' + eventId, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var event = calendar.getEventById(eventId);
            event.remove();
            $('#editEventModal').modal('hide');
        } else {
            console.error('Erro ao excluir o evento:', data.message || 'Resposta inválida do servidor.');
        }
    })
    .catch(error => {
        console.error('Erro ao excluir o evento:', error);
    });
});




 });





</script> --}}
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Calendar</li>
                    </ol>
                </div>
                <h4 class="page-title">Calendar</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="d-grid">
                                <button class="btn btn-lg font-16 btn-danger" data-bs-toggle="modal" data-bs-target="#event-modal" id="btn-new-event">
                                    <i class="mdi mdi-plus-circle-outline"></i> Create New Event
                                </button>
                            </div>
                            <div id="external-events" class="mt-3">
                                <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                <div class="external-event bg-success-lighten text-success" data-class="bg-success"><i
                                        class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>New Theme Release
                                </div>
                                <div class="external-event bg-info-lighten text-info" data-class="bg-info"><i
                                        class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>My Event</div>
                                <div class="external-event bg-warning-lighten text-warning" data-class="bg-warning"><i
                                        class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Meet manager</div>
                                <div class="external-event bg-danger-lighten text-danger" data-class="bg-danger"><i
                                        class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Create New theme
                                </div>
                            </div>

                            <div class="mt-5 d-none d-xl-block">
                                <h5 class="text-center">How It Works ?</h5>

                                <ul class="ps-3">
                                    <li class="text-muted mb-3">
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged.
                                    </li>
                                    <li class="text-muted mb-3">
                                        Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked
                                        up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage.
                                    </li>
                                    <li class="text-muted mb-3">
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged.
                                    </li>
                                </ul>
                            </div>

                        </div> <!-- end col-->

                        <div class="col-lg-9">
                            <div class="mt-4 mt-lg-0">
                                <div id="calendar"></div>
                            </div>
                        </div> <!-- end col -->

                    </div> <!-- end row -->
                </div> <!-- end card body-->
            </div> <!-- end card -->
<!-- Modal -->
 <!-- Modal -->
 <div class="modal fade" id="event-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-event" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add/Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="event-title" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="event-title" required>
                        <div class="invalid-feedback">Please provide a title for the event.</div>
                    </div>
                    <div class="mb-3">
                        <label for="event-title" class="form-label">ID</label>
                        <input type="text" class="form-control" id="event-id-hidden">
                    </div>
                    <div class="mb-3">
                        <label for="event-category-label" class="form-label">Event Category</label>
                        <select id="event-category" class="form-select" required>
                            <option value="" selected disabled>Select Category</option>
                            <option value="bg-primary">Primary</option>
                            <option value="bg-success">Success</option>
                            <option value="bg-danger">Danger</option>
                            <option value="bg-warning">Warning</option>
                            <option value="bg-info">Info</option>
                        </select>
                        <div class="invalid-feedback">Please select a category.</div>
                    </div>
                    <div class="mb-3">
                        <label for="event-date" class="form-label">Data</label>
                        <input type="text" class="form-control" id="event-date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-delete-event" class="btn btn-danger d-none">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btn-save-event" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
            <!-- Bootstrap 5 Modal -->
            {{-- <div class="modal fade" id="event-modal" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" >Cadastrar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="form-event">
                        
                        <div class="mb-3">
                        <label for="eventTitle" class="form-label">Título do Evento</label>
                        <input type="text" class="form-control" id="eventTitle" placeholder="Digite o título do evento">
                        </div>
                        <div class="mb-3">
                        <label for="eventDescription" class="form-label">Descrição</label>
                        <textarea class="form-control" id="eventDescription" rows="3" placeholder="Digite a descrição do evento"></textarea>
                        </div>
                        <input type="hidden" id="eventDate" value="">
                    </form>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btn-new-event">Salvar Evento</button>
                    </div>
                </div>
                </div>
            </div> --}}

            <!-- Modal para Editar ou Excluir Evento -->
            <!-- Modal de Edição de Evento -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">Editar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm"  method="POST" action="">
                    @csrf
                    <div class="mb-3">
                        <label for="editEventTitle" class="form-label">Título do Evento</label>
                        <input type="text" class="form-control" id="editEventTitle">
                    </div>
                    <div class="mb-3">
                        <label for="editEventDescription" class="form-label">Descrição</label>
                        <textarea class="form-control" id="editEventDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editEventDate" class="form-label">Data e Hora</label>
                        <input type="datetime-local" class="form-control" id="editEventDate">
                    </div>
                    <input type="hidden" id="editEventId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="saveEventChangesBtn">Salvar Alterações</button>
                <button type="button" class="btn btn-danger" id="deleteEventBtn">Excluir Evento</button>
            </div>
        </div>
    </div>
</div>


        </div>
        <!-- end col-12 -->
    </div> <!-- end row -->

@endsection
