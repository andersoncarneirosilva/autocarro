@extends('layouts.app')

@section('title', 'Calendário')

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Calendário</li>
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
                                    <i class="mdi mdi-plus-circle-outline"></i> Criar novo evento
                                </button>
                            </div>
                            <div id="" class="mt-3">
                                <p class="text-muted">Dica para uma melhor organização.</p>
                                <div class="external-event bg-success-lighten text-success" data-class="bg-success">
                                    <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Finalizados
                                </div>
                                <div class="external-event bg-info-lighten text-info" data-class="bg-info">
                                    <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>A fazer
                                </div>
                                <div class="external-event bg-warning-lighten text-warning" data-class="bg-warning">
                                    <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Em andamento
                                </div>
                                <div class="external-event bg-danger-lighten text-danger" data-class="bg-danger">
                                    <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Urgente
                                </div>
                            </div>
                            

                            <div class="mt-5 d-none d-xl-block">
                                <h5 class="text-center">Como funciona?</h5>

                                <ul class="ps-3">
                                    <li class="text-muted mb-3">
                                        O calendário é uma ferramenta interativa que permite visualizar e gerenciar seus eventos de forma prática.
                                    </li>
                                    <li class="text-muted mb-3">
                                        Você pode adicionar, editar ou excluir eventos diretamente no calendário, escolhendo a data e a hora que deseja.
                                    </li>
                                    <li class="text-muted mb-3">
                                        Além disso, é possível mover eventos de uma data para outra simplesmente arrastando-os, tornando o processo mais ágil e fácil de usar.
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
                    <h5 class="modal-title" id="modal-title">Criar/Editar Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="event-title" class="form-label">Título do evento</label>
                        <input type="text" class="form-control" id="event-title" required>
                        <div class="invalid-feedback">Por favor, preencha o nome do evento.</div>
                    </div>
                    <div class="mb-3">
                        <label for="event-category-label" class="form-label">Status do evento</label>
                        <select id="event-category" class="form-select" required>
                            <option value="" selected disabled>Selecione o status</option>
                            <option value="bg-primary">A fazer</option>
                            <option value="bg-warning">Em andamento</option>
                            <option value="bg-danger">Urgente</option>
                            <option value="bg-success">Finalizado</option>
                            <option value="bg-info">Outros</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o status.</div>
                    </div>
                    <div class="mb-3">
                        <label for="event-date" class="form-label">Data</label>
                        <input type="datetime-local" class="form-control" id="event-date">
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" id="btn-delete-event" class="btn btn-danger">Excluir</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn-save-event" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
