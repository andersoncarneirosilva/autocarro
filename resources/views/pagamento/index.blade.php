@extends('layouts.app')

@section('content')

<!-- Toast Bootstrap no canto superior direito -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050; margin-top: 70px;">
    <div id="toastPix" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Código PIX copiado com sucesso!
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
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <h3 class="page-title">Adicionar créditos</h3>
        </div>
    </div>
</div>
<br>
<div class="row">
  <div class="col-lg-12">
    
</div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-4">

                <div class="border p-3 rounded">
                    <h4 class="header-title mb-3 text-center">Resumo do Pedido</h4>
                    <div class="table-responsive">
                    <table class="table table-nowrap table-centered mb-0">
                        <tbody>
                            <tr>
                                <td>
                                    <p class="m-0 d-inline-block align-middle">
                                        <a href="apps-ecommerce-products-details.html" class="text-body fw-semibold">Plano {{ $plano }}</a>
                                        <br>
                                        <li>20 documentos</li>
                                    </p>
                                </td>
                                <td class="text-end">
                                    Total: R$ {{ number_format($preco, 2, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
          </div>

          <div class="col-lg-8">

            <!-- Pagamento via PIX -->
            <div class="border p-3 rounded" id="divGerarPix">
                <div class="row align-items-center">
                    <div class="col-9">
                        <div class="form-check">
                            <!-- Botão para gerar o QR Code (inicialmente visível) -->
                            <button id="pixPaymentButton" class="btn btn-success" style="display: block;" onclick="processPixPayment()">Gerar QR Code</button>
            
                            <!-- Botão de "Loading..." (inicialmente oculto) -->
                            <button class="btn btn-success" id="pixPaymentButtonLoading" type="button" disabled style="display: none;">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Gerando QR Code...
                            </button>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <img src="assets/images/payments/pix.png" class="img-fluid" alt="PIX-img" width="75px">
                    </div>
                </div>
            </div>
            

            <div id="pixPaymentContainer" class="border p-3 rounded" style="display: none;">
                <!-- Container para exibir o QR Code PIX -->
                <div id="pixContainer" style="display: none;">
                    <h4 class="header-title mb-3">Escaneie o QR Code para pagar com PIX:</h4>
                    <img id="pixQrCode" src="" alt="QR Code PIX" style="width: 250px;">
                    <a id="pixTicketUrl" href="#" target="_blank"></a>
                </div>
            
                <!-- Input para Copia e Cola -->
                <input type="hidden" id="pixCopiaCola" class="form-control" readonly style="display: none;">
                <button class="btn btn-outline-secondary" id="btCopiar" type="button" style="display: none;">Copiar</button>
            
                <!-- Timer de 5 minutos -->
                <div id="timer" style="display: none; margin-top: 10px;">
                    <h5>Tempo restante:</h5>
                    <span id="timerDisplay">05:00</span>
                </div>
            
                <!-- Mensagem de erro (oculta por padrão) -->
                <p id="pixErrorMessage" style="color: red; display: none;">Erro ao processar pagamento PIX.</p>
            </div>
            




          </div>
        </div> <!-- row -->
      </div> <!-- card-body -->
    </div> <!-- card -->
  </div> <!-- col-12 -->
</div>
<!-- Toast Bootstrap -->

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
            alert('O tempo para o pagamento expirou!');
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
        const pixResponse = await fetch('/api/create-pix-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Authorization': 'Bearer APP_USR-46c2384a-3f32-4ff9-9b96-b4497129462b' // Token Mercado Pago
            },
            body: JSON.stringify({
                amount: {{ $preco }},
                payer_email: @json($userEmail)
            })
        });

        const pixData = await pixResponse.json();
        
        // Inicia o timer de 5 minutos
        startTimer();

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
    setInterval(async function() {
        try {
            let response = await fetch('/check-payment-status');
            let data = await response.json();

            if (data.status === 'paid') {
                window.location.href = "{{ route('pagamento.confirmado') }}"; // Usa a rota Laravel
            }
        } catch (error) {
            console.error("Erro ao verificar pagamento:", error);
        }
    }, 2000);
</script>


@endsection