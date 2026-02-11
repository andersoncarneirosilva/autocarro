@extends('layouts.app')

@section('content')

<div class="position-fixed top-0 end-0 p-3" style="z-index: 1060; margin-top: 70px;">
    <div id="toastPix" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="mdi mdi-check-circle-outline me-2"></i> Código PIX copiado com sucesso!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Checkout</a></li>
                    <li class="breadcrumb-item active">Pagamento PIX</li>
                </ol>
            </div>
            <h4 class="page-title">Finalizar Pagamento</h4>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="header-title mb-3">Resumo do Plano</h4>
                <div class="bg-light p-3 rounded">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Plano:</span>
                        <span class="badge bg-primary-lighten text-primary">{{ $plano }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total a pagar:</span>
                        <h4 class="m-0 text-success">R$ {{ number_format($preco, 2, ',', '.') }}</h4>
                    </div>
                </div>
                <div class="mt-3 text-muted">
                    <small><i class="mdi mdi-shield-check-outline me-1"></i> Pagamento processado de forma segura.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                
                <div id="divGerarPix" class="py-4">
                    <img src="frontend/images/pix.png" class="mb-3" alt="PIX" width="100">
                    <h4 class="mb-3">Pagamento via PIX</h4>
                    <p class="text-muted mb-4">O QR Code será gerado para pagamento imediato.</p>
                    
                    <button id="pixPaymentButton" 
        class="btn btn-success btn-lg rounded-pill px-4"
        data-plano="{{ $plano }}" 
        data-user-email="{{ $userEmail }}">
    <i class="mdi mdi-qrcode me-1"></i> Gerar QR Code para Pagar
</button>

                    <button class="btn btn-success btn-lg rounded-pill px-4" id="pixPaymentButtonLoading" type="button" disabled style="display: none;">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Gerando...
                    </button>
                </div>

                <div id="pixPaymentContainer" style="display: none;">
                    <div class="alert alert-info border-0 mb-4" role="alert">
                        <i class="mdi mdi-information-outline me-1"></i> Escaneie o código abaixo ou copie a chave PIX.
                    </div>

                    <div id="pixContainer" class="mb-4">
                        <div class="bg-white p-2 d-inline-block border rounded shadow-sm">
                            <img id="pixQrCode" src="" alt="QR Code PIX" style="width: 220px; height: 220px;">
                        </div>
                    </div>

                    <div class="px-md-5 mb-4">
                        <label class="form-label text-muted">Pix Copia e Cola</label>
                        <div class="input-group">
                            <input type="text" id="pixCopiaCola" class="form-control bg-light" readonly>
                            <button class="btn btn-dark" id="btCopiar" type="button">
                                <i class="mdi mdi-content-copy me-1"></i> Copiar
                            </button>
                        </div>
                    </div>

                    <div id="timer" class="mb-3">
                        <p class="mb-1 text-muted">Este código expira em:</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="mdi mdi-clock-outline me-1 text-danger"></i>
                            <h3 id="timerDisplay" class="m-0 text-danger fw-bold">05:00</h3>
                        </div>
                    </div>

                    <div id="linkPlanos" style="display: none;" class="mt-3">
                        <a href="{{ route('planos.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="mdi mdi-arrow-left me-1"></i> Tempo expirado. Tente novamente.
                        </a>
                    </div>
                </div>

                <p id="pixErrorMessage" class="text-danger mt-3" style="display: none;">
                    <i class="mdi mdi-alert-circle-outline me-1"></i> Erro ao processar pagamento. Tente novamente.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos para modernizar no Hyper */
    .bg-primary-lighten { background-color: rgba(114, 124, 245, 0.15); }
    #pixQrCode { transition: transform 0.3s ease; }
    #pixQrCode:hover { transform: scale(1.02); }
    .card { border-radius: 12px; }
    .btn-lg { font-weight: 600; }
</style>


<script>
    // 1. Variáveis Globais e Configurações
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let timerInterval;
    let statusInterval;
    let remainingTime = 300; // 5 minutos

    // 2. Função para o Timer de Expiração
    function startTimer() {
        const timerDiv = document.getElementById('timer');
        const timerDisplay = document.getElementById('timerDisplay');
        const linkPlanos = document.getElementById('linkPlanos');

        if (timerDiv) timerDiv.style.display = 'block';
        
        timerInterval = setInterval(() => {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            
            if (timerDisplay) {
                timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }
            
            if (remainingTime <= 0) {
                clearInterval(timerInterval);
                clearInterval(statusInterval); // Para de verificar se expirou
                if (linkPlanos) linkPlanos.style.display = 'block';
                alert("O tempo para pagamento expirou. Por favor, gere um novo QR Code.");
            } else {
                remainingTime--;
            }
        }, 1000);
    }

    // 3. Função para Verificar Status no Banco de Dados
    function iniciarVerificacaoStatus() {
        if (statusInterval) clearInterval(statusInterval);
        
        statusInterval = setInterval(async function() {
            try {
                let response = await fetch("{{ url('/check-payment-status') }}");
                if (!response.ok) return;
                
                let data = await response.json();
                console.log("Status Alcecar:", data.status);

                if (data.status === 'approved' || data.status === 'paid') {
                    clearInterval(statusInterval);
                    clearInterval(timerInterval);
                    window.location.href = "{{ route('pagamento.confirmado') }}"; 
                }
            } catch (error) {
                console.error("Erro ao verificar status:", error);
            }
        }, 5000); // 5 em 5 segundos
    }

    // 4. Evento de Clique para Gerar PIX
    const pixBtn = document.getElementById("pixPaymentButton");
    if (pixBtn) {
        pixBtn.addEventListener("click", async () => {
            const btnGerar = document.getElementById("pixPaymentButton");
            const btnLoading = document.getElementById("pixPaymentButtonLoading");
            const errorMsg = document.getElementById("pixErrorMessage");

            // Feedback Visual
            btnGerar.style.display = "none";
            if (btnLoading) btnLoading.style.display = "inline-block";
            if (errorMsg) errorMsg.style.display = "none";

            try {
                const pixResponse = await fetch("{{ url('/create-pix-payment') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        plano: @json($plano) 
                    })
                });

                if (!pixResponse.ok) throw new Error("Erro no servidor");

                const pixData = await pixResponse.json();
                
                // Mostrar Container do QR Code e esconder botão de gerar
                document.getElementById("divGerarPix").style.display = "none";
                document.getElementById('pixPaymentContainer').style.display = 'block';

                if (pixData.qr_code_base64) {
                    document.getElementById("pixQrCode").src = "data:image/png;base64," + pixData.qr_code_base64;
                }
                if (pixData.qr_code) {
                    document.getElementById("pixCopiaCola").value = pixData.qr_code;
                }

                // Inicia os processos automáticos
                startTimer();
                iniciarVerificacaoStatus();

            } catch (error) {
                console.error("Erro ao criar pagamento PIX:", error);
                btnGerar.style.display = "inline-block";
                if (errorMsg) errorMsg.style.display = "block";
            } finally {
                if (btnLoading) btnLoading.style.display = "none";
            }
        });
    }

    // 5. Função de Copiar Código
    const btnCopiar = document.getElementById("btCopiar");
    if (btnCopiar) {
        btnCopiar.addEventListener("click", function () {
            const pixCodeInput = document.getElementById("pixCopiaCola");
            if (pixCodeInput && pixCodeInput.value) {
                navigator.clipboard.writeText(pixCodeInput.value).then(() => {
                    const toastEl = document.getElementById("toastPix");
                    if (toastEl) {
                        let toast = new bootstrap.Toast(toastEl);
                        toast.show();
                    } else {
                        alert("Código copiado!");
                    }
                });
            }
        });
    }
</script>



@endsection