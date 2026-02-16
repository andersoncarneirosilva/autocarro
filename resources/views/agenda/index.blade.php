@extends('layouts.app')

@section('title', 'Agenda')

@section('content')



<style>
/* 1. Remova qualquer background-color: #727cf5 !important; que existir */

/* 2. Aplique este estilo para respeitar a cor do objeto JS */
.fc-h-event {
    /* Faz o evento herdar a cor do backgroundColor do objeto */
    background-color: var(--fc-event-bg-color) !important;
    border-color: var(--fc-event-border-color) !important;
}

.fc-event-main {
    color: var(--fc-event-text-color, #ffffff) !important;
}

/* 3. Estética do Alcecar: Deixar o bloco bonitão */
.fc-daygrid-event {
    border-radius: 4px !important;
    padding: 2px 4px !important;
    border: none !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* 4. Esconder a bolinha (dot) que o FullCalendar tenta colocar */
.fc-daygrid-event-dot {
    display: none !important;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h3 class="page-title">Agenda Alcecar</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
    <div class="col-lg-3">
        <div class="d-grid">
            <button class="btn btn-lg font-16 btn-primary" id="btn-new-event" data-bs-toggle="modal" data-bs-target="#modalCadastrarAgenda">
                <i class="mdi mdi-plus-circle-outline"></i> Novo Agendamento
            </button>
        </div>

        <div class="mt-5 d-none d-xl-block">
    <h5 class="text-center text-primary mb-3">Como agendar?</h5>
    <ul class="list-unstyled ps-2">
        <li class="text-muted mb-3">
            <i class="mdi mdi-cursor-default-click text-primary me-2"></i>
            <strong>Clique ou Novo:</strong> Clique em um espaço vazio no calendário ou no botão "Novo Agendamento".
        </li>
        <li class="text-muted mb-3">
            <i class="mdi mdi-clock-check-outline text-primary me-2"></i>
            <strong>Duração Dinâmica:</strong> A grade de horários se ajusta automaticamente conforme a soma do tempo dos serviços escolhidos.
        </li>
        <li class="text-muted mb-3">
            <i class="mdi mdi-calendar-lock text-primary me-2"></i>
            <strong>Verificação de Conflitos:</strong> O sistema bloqueia horários onde o profissional já possui outros atendimentos no intervalo.
        </li>
        <li class="text-muted mb-3">
            <i class="mdi mdi-cash-register text-primary me-2"></i>
            <strong>Preço Protegido:</strong> Os valores são registrados em snapshot, mantendo o histórico financeiro mesmo se o preço do serviço mudar no futuro.
        </li>
    </ul>
</div>
    </div>

    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
                
            </div>
        </div>
    </div>
</div>

<style>
    #calendar {
        max-height: 800px;
    }
    .fc-event { cursor: pointer; }
</style>
@push('scripts')
    <script src="{{ asset('js/agenda.js') }}"></script>
@endpush

@include('components.toast')

@include('agenda._modals.cad')
@include('agenda._modals.edit')
@include('agenda._modals.concluir')

@endsection