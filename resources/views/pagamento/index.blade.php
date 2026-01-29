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
                    
                    <button id="pixPaymentButton" class="btn btn-success btn-lg rounded-pill px-4" onclick="processPixPayment()">
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
    let timerInterval;
    let remainingTime = 300; // 5 minutos em segundos (300 segundos)
    
    function startTimer() {
        // Exibe o timer na tela
        document.getElementById('timer').style.display = 'block';
    
        // Atualiza o tempo a cada segundo
        timerInterval = setInterval(() => {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
    
            // Exibe o tempo formatado como MM:SS
            document.getElementById('timerDisplay').textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    
            // Decrementa o tempo
            if (remainingTime > 0) {
                remainingTime--;
            } else {
                clearInterval(timerInterval); // Para o timer quando o tempo acabar
                document.getElementById('linkPlanos').style.display = 'block';
            }
        }, 1000);
    }
    </script>
    

<script>
function processPixPayment() {
    try {
        // Exibe o botão com spinner e esconde o botão de "Gerar QR Code"
        document.getElementById('pixPaymentButton').style.display = 'none';
        document.getElementById('pixPaymentButtonLoading').style.display = 'inline-block';

        // Oculta o conteúdo anterior
        document.getElementById('pixContainer').style.display = 'none';
        document.getElementById('pixCopiaCola').style.display = 'none';
        document.getElementById('btCopiar').style.display = 'none';
        document.getElementById('pixPaymentContainer').style.display = 'none';

        // Lógica de criação do QR Code (substitua com sua lógica real)
        const qrCodeSrc = "#";  // Substitua pela URL do QR Code real
        const boletoLink = "#"; // Substitua pelo link do boleto do PIX

        if (qrCodeSrc && boletoLink) {
            document.getElementById('pixQrCode').src = qrCodeSrc;
            document.getElementById('pixTicketUrl').href = boletoLink;
            document.getElementById('pixContainer').style.display = 'block';
            document.getElementById('pixErrorMessage').style.display = 'none'; // Oculta a mensagem de erro
            document.getElementById('pixPaymentContainer').style.display = 'block';
            document.getElementById('timer').style.display = 'block';
        } else {
            throw new Error("Informações do pagamento PIX não estão disponíveis.");
        }
    } catch (error) {
        document.getElementById('pixErrorMessage').style.display = 'block';
        document.getElementById('pixContainer').style.display = 'none'; // Oculta QR Code em caso de erro
    } finally {
        // Esconde o spinner e o botão de "Loading..."
        document.getElementById('pixPaymentButtonLoading').style.display = 'none';
    }
}

// Lógica de pagamento PIX (enviar requisição)
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.getElementById("pixPaymentButton").addEventListener("click", async () => {
    try {
        // Exibe o spinner e esconde o conteúdo
        document.getElementById("pixPaymentButtonLoading").style.display = "inline-block";
        document.getElementById("pixContainer").style.display = "none";
        document.getElementById("pixCopiaCola").style.display = "none";
        document.getElementById("btCopiar").style.display = "none";
        document.getElementById("pixPaymentButton").style.display = "none";  // Esconde o botão "Gerar QR Code"
        document.getElementById("divGerarPix").style.display = "block"; // Esconde toda a área de gerar PIX
        document.getElementById('pixPaymentContainer').style.display = 'none';

        // Faz a requisição para gerar o pagamento PIX
        // No seu arquivo JS:
const pixResponse = await fetch('/create-pix-payment', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        amount: {{ $preco }},
        payer_email: @json($userEmail),
        plano: @json($plano) 
    })
});



        const pixData = await pixResponse.json();
        
        // Inicia o timer de 5 minutos
        startTimer();
        iniciarVerificacaoStatus();
        // Esconde o spinner
        document.getElementById('pixPaymentContainer').style.display = 'block';
        document.getElementById("pixPaymentButtonLoading").style.display = "none";


        if (pixData.qr_code_base64) {
            document.getElementById("pixQrCode").src = "data:image/png;base64," + pixData.qr_code_base64;
            document.getElementById("pixContainer").style.display = "block";
            document.getElementById("divGerarPix").style.display = "none"; 
        }
        if (pixData.qr_code) {
            document.getElementById("pixCopiaCola").style.display = "block";
            document.getElementById("pixCopiaCola").value = pixData.qr_code;
            document.getElementById("btCopiar").style.display = "block";
        }

        if (pixData.ticket_url) {
            document.getElementById("pixTicketUrl").href = pixData.ticket_url;
        }

    } catch (error) {
        console.error("Erro ao criar pagamento PIX:", error);
        document.getElementById("pixPaymentButtonLoading").style.display = "none"; // Esconde o spinner em caso de erro
    }
});

// Função para copiar o código PIX
document.getElementById("btCopiar").addEventListener("click", function () {
    const pixCodeInput = document.getElementById("pixCopiaCola");

    if (!pixCodeInput.value) {
        alert("Nenhum código PIX disponível para copiar.");
        return;
    }

    navigator.clipboard.writeText(pixCodeInput.value)
        .then(() => {
            let toastElement = new bootstrap.Toast(document.getElementById("toastPix"));
            toastElement.show();
        })
        .catch(err => {
            console.error("Erro ao copiar código PIX:", err);
            alert("Erro ao copiar. Tente manualmente.");
        });
});
</script>


<script>
    let statusInterval; // Variável global para controlar o intervalo

function iniciarVerificacaoStatus() {
    // Evita duplicar o intervalo se clicar duas vezes
    if (statusInterval) clearInterval(statusInterval);

    statusInterval = setInterval(async function() {
        try {
            let response = await fetch('/check-payment-status');
            
            if (!response.ok) return;

            let data = await response.json();

            if (data.status === 'approved' || data.status === 'paid') {
                clearInterval(statusInterval);
                window.location.href = "{{ route('pagamento.confirmado') }}"; 
            }
        } catch (error) {
            console.error("Erro ao verificar status:", error);
        }
    }, 5000); // 5 segundos é o ideal para não sobrecarregar o log
}
</script>


@endsection