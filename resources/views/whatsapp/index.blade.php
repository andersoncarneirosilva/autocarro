@extends('layouts.app')

@section('title', 'Conexões WhatsApp')

@include('components.toast')

@section('content')

<style>
    /* Design moderno e minimalista */
    .whatsapp-card { border-radius: 12px; transition: all 0.3s ease; border: 1px solid #eef2f7; }
    .whatsapp-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    
    .status-dot { height: 10px; width: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
    .status-online { background-color: #0acf97; box-shadow: 0 0 8px #0acf97; }
    .status-offline { background-color: #fa5c7c; }

    .nav-settings .nav-link { color: #6c757d; border: none; font-weight: 600; padding: 10px 15px; border-radius: 8px; }
    .nav-settings .nav-link.active { background-color: #727cf5; color: #fff; }

    .message-box { background: #f9fafd; border: 1px solid #e3eaef; border-radius: 10px; padding: 15px; transition: 0.2s; }
    .message-box:focus-within { border-color: #727cf5; background: #fff; }

    /* Estilo para os Toggle Switches */
    .switch { position: relative; display: inline-block; width: 38px; height: 20px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #dee2e6; transition: .4s; border-radius: 34px; }
    .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .slider { background-color: #0acf97; }
    input:checked + .slider:before { transform: translateX(18px); }

    .variable-badge { cursor: pointer; transition: 0.2s; }
    .variable-badge:hover { background-color: #727cf5 !important; color: #fff !important; }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title">Painel WhatsApp</h4>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    <i class="mdi mdi-plus-circle me-1"></i> Nova Conexão
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0 text-muted"><i class="mdi mdi-cellphone-link me-2"></i>Dispositivos Conectados</h5>
                </div>
                <div class="card-body p-2">
                    @forelse($instances as $instance)
                        <div class="whatsapp-card card mb-2 shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                <i class="mdi mdi-whatsapp font-22"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h5 class="my-0 font-15">{{ $instance->name }}</h5>
                                            <small class="text-muted">{{ $instance->number }}</small>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical font-18"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @if($instance->status === 'open')
                                                <form action="{{ route('whatsapp.logout', $instance->name) }}" method="POST">
                                                    @csrf
                                                    <button type="button" class="dropdown-item btn-logout-confirm text-warning"><i class="mdi mdi-logout me-1"></i>Desconectar</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('whatsapp.delete', $instance->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="button" class="dropdown-item btn-delete-confirm text-danger"><i class="mdi mdi-trash-can me-1"></i>Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    @if($instance->status === 'open')
                                        <span class="text-success fw-bold font-13"><span class="status-dot status-online"></span> Ativo</span>
                                        <button class="btn btn-sm btn-light rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#testArea_{{ $instance->id }}">
                                            Testar Envio
                                        </button>
                                    @else
                                        <span class="text-danger fw-bold font-13"><span class="status-dot status-offline"></span> Desconectado</span>
                                        <button class="btn btn-sm btn-primary rounded-pill btn-qr-load" data-name="{{ $instance->name }}">
                                            <i class="mdi mdi-qrcode-scan me-1"></i> Conectar
                                        </button>
                                    @endif
                                </div>

                                <div class="collapse" id="testArea_{{ $instance->id }}">
                                    <div class="bg-light p-2 mt-2 rounded border">
                                        <div class="input-group input-group-sm mb-1">
                                            <input type="text" id="phone_{{ $instance->name }}" class="form-control" placeholder="Número">
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="msg_{{ $instance->name }}" class="form-control" placeholder="Oi!">
                                            <button class="btn btn-dark btn-send-test" data-instance="{{ $instance->name }}" type="button"><i class="mdi mdi-send"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted">Nenhuma conexão configurada.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">
                        <i class="mdi mdi-plus-circle me-1"></i> Nova conexão
                    </button>
                </div>
                <h4 class="page-title">Configurações de Automação</h4>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Card: Confirmação de Agendamento --}}
        <div class="col-md-6 mb-4">
    <div class="card h-100 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
            <h4 class="header-title mb-0">Confirmação</h4>
            <div class="d-flex align-items-center gap-3">
                <div class="form-check form-switch p-0 m-0 d-flex align-items-center">
                    <input type="checkbox" class="form-check-input m-0 toggle-setting" 
                        data-field="confirmation_is_active" 
                        {{ ($settings->confirmation_is_active ?? false) ? 'checked' : '' }}
                        style="width: 38px; height: 19px; cursor: pointer;">
                </div>
                <button type="button" class="btn btn-sm btn-light rounded-pill border-0 shadow-sm px-3" 
                        data-bs-toggle="modal" data-bs-target="#modalEditConfirmation">
                    <i class="mdi mdi-square-edit-outline me-1 text-primary"></i> 
                    <span class="text-dark font-13">Editar</span>
                </button>
            </div>
        </div>
        <div class="card-body pt-0 text-center">
            <i class="mdi mdi-calendar-check display-4 text-primary d-block"></i>
            <h5 class="mt-3">Confirmação Instantânea</h5>
            <p class="text-muted font-14 px-3 mb-0">Enviada automaticamente assim que o cliente realiza um novo agendamento no sistema.</p>
            <div class="mt-3">
                <span id="status-badge-confirmation_is_active" 
                      class="badge {{ ($settings->confirmation_is_active ?? false) ? 'badge-primary-lighten' : 'badge-secondary-lighten' }} font-12 p-1 px-2 status-badge">
                    Status: {{ ($settings->confirmation_is_active ?? false) ? 'Ativo' : 'Inativo' }}
                </span>
            </div>
        </div>
    </div>
</div>

        {{-- Card: Lembrete 24h --}}
      <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
        <h4 class="header-title mb-0">Lembrete</h4>
        <div class="d-flex align-items-center gap-3">
            <div class="form-check form-switch p-0 m-0 d-flex align-items-center">
                <input class="form-check-input m-0 toggle-setting" type="checkbox" 
                    data-field="reminder_is_active" 
                    {{ ($settings->reminder_is_active ?? false) ? 'checked' : '' }}>
            </div>
            <button type="button" class="btn btn-sm btn-light rounded-pill border-0 shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalEditReminder">
                <i class="mdi mdi-square-edit-outline me-1 text-primary"></i> Editar
            </button>
        </div>
    </div>
    <div class="card-body pt-0 text-center">
        <i class="mdi mdi-clock-outline display-4 text-success d-block"></i>
        <h5 class="mt-3">Lembrete de Horário</h5>
        <p class="text-muted font-14 px-3 mb-0">Envia lembrete 24h antes do serviço.</p>
        <div class="mt-3">
            {{-- ID DINÂMICO AQUI --}}
            <span id="status-badge-reminder_is_active" 
                  class="badge {{ ($settings->reminder_is_active ?? false) ? 'badge-success-lighten' : 'badge-secondary-lighten' }} font-12 p-1 px-2">
                Status: {{ ($settings->reminder_is_active ?? false) ? 'Ativo' : 'Inativo' }}
            </span>
        </div>
    </div>
</div>
    </div>

        {{-- Card: Cancelamento --}}
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
                <h4 class="header-title mb-0">Cancelamento</h4>
                <div class="d-flex align-items-center gap-3">
                    <div class="form-check form-switch p-0 m-0 d-flex align-items-center">
                        <input class="form-check-input m-0 toggle-setting" type="checkbox" 
                            id="switchCan" 
                            data-field="cancellation_is_active" 
                            {{ ($settings->cancellation_is_active ?? false) ? 'checked' : '' }} 
                            style="width: 38px; height: 19px; cursor: pointer;">
                    </div>
                    <button type="button" class="btn btn-sm btn-light rounded-pill border-0 shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalEditCancellation">
                        <i class="mdi mdi-square-edit-outline me-1 text-primary"></i> 
                        <span class="text-dark fw-semibold font-13">Editar</span>
                    </button>
                </div>
            </div>
            <div class="card-body pt-0 text-center">
    <i class="mdi mdi-calendar-remove display-4 text-danger d-block"></i>
    <h5 class="mt-3">Aviso de Cancelamento</h5>
    <p class="text-muted font-14 px-3 mb-0">Avisa o cliente se o horário for removido.</p>
    <div class="mt-3">
        {{-- ID DINÂMICO AQUI --}}
        <span id="status-badge-cancellation_is_active" 
              class="badge {{ ($settings->cancellation_is_active ?? false) ? 'badge-danger-lighten' : 'badge-secondary-lighten' }} font-12 p-1 px-2">
            Status: {{ ($settings->cancellation_is_active ?? false) ? 'Ativo' : 'Inativo' }}
        </span>
    </div>
</div>
        </div>
    </div>

    {{-- Card: Auto-Resposta (Bot) --}}
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0">
                <h4 class="header-title mb-0">Auto-Resposta</h4>
                <div class="d-flex align-items-center gap-3">
                    <div class="form-check form-switch p-0 m-0 d-flex align-items-center">
                        <input class="form-check-input m-0 toggle-setting" type="checkbox" 
                            id="switchBot" 
                            data-field="bot_is_active" 
                            {{ ($settings->bot_is_active ?? false) ? 'checked' : '' }} 
                            style="width: 38px; height: 19px; cursor: pointer;">
                    </div>
                    <button type="button" class="btn btn-sm btn-light rounded-pill border-0 shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalEditBot">
                        <i class="mdi mdi-square-edit-outline me-1 text-primary"></i> 
                        <span class="text-dark fw-semibold font-13">Editar</span>
                    </button>
                </div>
            </div>
            <div class="card-body pt-0 text-center">
    <i class="mdi mdi-robot display-4 text-info d-block"></i>
    <h5 class="mt-3">Saudação Inicial</h5>
    <p class="text-muted font-14 px-3 mb-0">Responde a primeira mensagem do dia.</p>
    <div class="mt-3">
        {{-- ID DINÂMICO AQUI --}}
        <span id="status-badge-bot_is_active" 
              class="badge {{ ($settings->bot_is_active ?? false) ? 'badge-info-lighten' : 'badge-secondary-lighten' }} font-12 p-1 px-2">
            Status: {{ ($settings->bot_is_active ?? false) ? 'Ativo' : 'Inativo' }}
        </span>
    </div>
</div>
        </div>
    </div>
    </div>
</div>

{{-- Os Modais devem vir aqui embaixo, conforme o exemplo anterior --}}
        </div>
</div>
</div>

@include('whatsapp._modals.edit-confirmacao')
@include('whatsapp._modals.edit-lembrete')

<script>
$(document).ready(function() {
    // Configuração do Toast padrão (idêntica à sua de sessão)
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
    });

    $('.toggle-setting').change(function() {
        const field = $(this).data('field');
        const isChecked = $(this).is(':checked') ? 1 : 0;
        const checkbox = $(this);

        $.ajax({
            url: "{{ route('whatsapp.update-messages') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                [field]: isChecked
            },
            success: function(response) {
                if (response.success) {
                    Toast.fire({ icon: 'success', title: response.message });

                    const badge = $(`#status-badge-${field}`);
                    
                    // Define a cor baseada no campo para manter o estilo
                    let activeClass = 'badge-primary-lighten'; // Padrão
                    if (field === 'reminder_is_active') activeClass = 'badge-success-lighten';
                    if (field === 'cancellation_is_active') activeClass = 'badge-danger-lighten';
                    if (field === 'bot_is_active') activeClass = 'badge-info-lighten';

                    if (isChecked) {
                        badge.text('Status: Ativo');
                        badge.removeClass('badge-secondary-lighten').addClass(activeClass);
                    } else {
                        badge.text('Status: Inativo');
                        badge.removeClass('badge-primary-lighten badge-success-lighten badge-danger-lighten badge-info-lighten').addClass('badge-secondary-lighten');
                    }
                }
            },
            error: function() {
                // Reverte o switch se der erro
                checkbox.prop('checked', !isChecked);
                
                Toast.fire({
                    icon: 'error',
                    title: 'Erro ao salvar alteração.'
                });
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    // Inserção de variáveis melhorada
    $('.select-tag').change(function() {
        let tag = $(this).val();
        let targetId = $(this).data('target');
        if (tag) {
            let textarea = $('#' + targetId);
            let cursorPosition = textarea.prop("selectionStart");
            let text = textarea.val();
            let newText = text.substring(0, cursorPosition) + tag + text.substring(cursorPosition);
            textarea.val(newText).focus();
            $(this).val(''); // Reset select
        }
    });
});
</script>


@include('whatsapp._modals.qrcode')
@include('whatsapp._modals.create')


<script>
$(document).ready(function() {
    // Inserção automática de tags
    $('.select-tag').on('change', function() {
        const tag = $(this).val();
        const targetId = $(this).data('target');
        const textarea = document.getElementById(targetId);

        if (tag && textarea) {
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;

            textarea.value = text.substring(0, start) + tag + text.substring(end);
            textarea.focus();
            textarea.selectionEnd = start + tag.length;
        }
        $(this).val(''); // Reseta o select
    });
});
</script>

<script>
$(document).ready(function() {
    let checkInterval;
    const qrModalElement = document.getElementById('modalQR');
    const qrModal = qrModalElement ? new bootstrap.Modal(qrModalElement) : null;

    // 1. CARREGAR QR CODE
    $('.btn-qr-load').click(function() {
        const instanceName = $(this).data('name'); // Nome específico da instância do card
        
        $('#qr-result').html('').addClass('d-none');
        $('#qr-spinner').show();
        $('#qr-success').addClass('d-none');
        qrModal.show();

        const loadQR = () => {
            $.ajax({
                url: `/whatsapp/connect/${instanceName}`,
                method: 'GET',
                success: function(data) {
                    if (data.qrcode) {
                        $('#qr-spinner').hide();
                        // Remove prefixo se a API já enviar, e limpa espaços
                        let base64 = data.qrcode.replace(/^data:image\/png;base64,/, "").trim();
                        $('#qr-result').removeClass('d-none').html(
                            `<img src="data:image/png;base64,${base64}" class="img-fluid rounded shadow-sm border" style="max-width: 250px; margin: 0 auto; display: block;">`
                        );
                        iniciarMonitoramento(instanceName);
                    } else {
                        setTimeout(loadQR, 3000);
                    }
                },
                error: function() {
                    setTimeout(loadQR, 3000); // Tenta novamente se a instância estiver iniciando
                }
            });
        };
        loadQR();
    });

    // 2. MONITORAR STATUS
    function iniciarMonitoramento(name) {
        if (checkInterval) clearInterval(checkInterval);
        
        checkInterval = setInterval(function() {
            $.get(`/whatsapp/sync/${name}`, function(res) {
                // Algumas versões retornam 'open' outras 'CONNECTED'
                const status = (res.status || res.state || "").toLowerCase();
                if (status === 'open' || status === 'connected') {
                    clearInterval(checkInterval);
                    $('#qr-result').addClass('d-none');
                    $('#qr-success').removeClass('d-none');
                    
                    if(window.jQuery.NotificationApp) {
                        $.NotificationApp.send("Sucesso", "WhatsApp Conectado!", "top-right", "#5ba035", "success");
                    }
                    
                    setTimeout(() => { location.reload(); }, 2000);
                }
            });
        }, 5000);
    }

    // 3. LIMPEZA
    qrModalElement.addEventListener('hidden.bs.modal', function () {
        if (checkInterval) clearInterval(checkInterval);
        $('#qr-result').empty();
    });

    // 4. ENVIO DE TESTE
    $('.btn-send-test').on('click', function() {
        const instance = $(this).data('instance');
        const phone = $('#phone_' + instance).val();
        const msg = $('#msg_' + instance).val();
        const $btn = $(this);

        if(!phone || !msg) {
            alert("Preencha o número e a mensagem");
            return;
        }

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.post("{{ route('whatsapp.send-test') }}", {
            _token: "{{ csrf_token() }}",
            instance: instance,
            number: phone,
            message: msg
        })
        .done(function() {
             if($.NotificationApp) {
                $.NotificationApp.send("Enviado", "Mensagem enviada com sucesso!", "top-right", "#5ba035", "success");
             } else {
                alert("Mensagem enviada!");
             }
        })
        .fail(function(err) {
            const msgErro = err.responseJSON ? err.responseJSON.message : "Erro na API";
            alert("Erro: " + msgErro);
        })
        .always(function() {
            $btn.prop('disabled', false).html('<i class="mdi mdi-send"></i>');
        });
    });

    // 5. DELETE E LOGOUT (SweetAlert)
    $(document).on('click', '.btn-delete-confirm, .btn-logout-confirm', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const tipo = $(this).hasClass('btn-delete-confirm') ? 'Excluir' : 'Desconectar';
        
        Swal.fire({
            title: `${tipo} conexão?`,
            text: "Esta ação não pode ser desfeita.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: tipo === 'Excluir' ? '#fa5c7c' : '#ffbc00',
            cancelButtonText: 'Cancelar',
            confirmButtonText: `Sim, ${tipo}!`
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>

@endsection