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
                <button id="pixPaymentButton" class="btn btn-success" style="display: block;" onclick="processPixPayment()">Gerar QR Code PIX</button>
            </div>
        </div>
        <div class="col-3 text-end">
            <img src="assets/images/payments/pix.png" class="img-fluid" alt="PIX-img" width="75px">
        </div>
    </div>
</div>

<!-- Container para pagamento PIX (oculto por padrão) -->
<div id="pixPaymentContainer" class="border p-3 rounded" style="display: none;">
    <div id="pixLoading" style="display: none;">
        <strong>Gerando QR Code...</strong>
        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
    </div>

    <!-- Container para exibir o QR Code PIX -->
    <div id="pixContainer" style="display: none; margin-top: 10px;">
        <h3>Escaneie o QR Code para pagar com PIX:</h3>
        <img id="pixQrCode" src="" alt="QR Code PIX" style="width: 250px;">
        <a id="pixTicketUrl" href="#" target="_blank"></a>
    </div>

    <!-- Input para Copia e Cola -->
    <input type="hidden" id="pixCopiaCola" class="form-control" readonly style="display: none;">
    <button class="btn btn-outline-secondary" id="btCopiar" type="button" style="display: none;">Copiar</button>

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
function processPixPayment() {
    try {
        // Exibe o spinner enquanto o QR Code está sendo gerado
        document.getElementById('pixLoading').style.display = 'block';
        document.getElementById('pixContainer').style.display = 'none';
        document.getElementById('pixCopiaCola').style.display = 'none';
        document.getElementById('btCopiar').style.display = 'none';

        // Simula a geração do QR Code (substitua pela lógica real)
        const qrCodeSrc = "#";  // Substitua pela URL do QR Code real
        const boletoLink = "#"; // Substitua pelo link do boleto do PIX

        if (qrCodeSrc && boletoLink) {
            document.getElementById('pixQrCode').src = qrCodeSrc;
            document.getElementById('pixTicketUrl').href = boletoLink;
            document.getElementById('pixContainer').style.display = 'block';
            document.getElementById('pixErrorMessage').style.display = 'none'; // Ocultar mensagem de erro
            document.getElementById('pixPaymentContainer').style.display = 'block';
        } else {
            throw new Error("Informações do pagamento PIX não estão disponíveis.");
        }
    } catch (error) {
        document.getElementById('pixErrorMessage').style.display = 'block';
        document.getElementById('pixContainer').style.display = 'none'; // Ocultar QR Code em caso de erro
    } finally {
        document.getElementById('pixLoading').style.display = 'none';
    }
}

// Lógica de pagamento PIX
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
document.getElementById("pixPaymentButton").addEventListener("click", async () => {
    try {
        // Exibe o spinner e esconde o conteúdo
        document.getElementById("pixLoading").style.display = "block";
        document.getElementById("pixContainer").style.display = "none";
        document.getElementById("pixCopiaCola").style.display = "none";
        document.getElementById("btCopiar").style.display = "none";
        document.getElementById("pixPaymentButton").style.display = "none";
        document.getElementById("divGerarPix").style.display = "none";

        // const pixResponse = await fetch('/api/create-pix-payment', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-CSRF-TOKEN': csrfToken
        //     },
        //     body: JSON.stringify({
        //         amount: {{ $preco }},
        //         payer_email: @json($userEmail)
        //     })
        // });

        const pixResponse = await fetch('/api/create-pix-payment', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Authorization': 'Bearer TEST-83c1af18-f3a5-4077-bc98-e72379b980b1' // Passando o token no cabeçalho
    },
    body: JSON.stringify({
        amount: {{ $preco }},
        payer_email: @json($userEmail)
    })
});



        const pixData = await pixResponse.json();
        

        // Esconde o spinner
        document.getElementById("pixLoading").style.display = "none";

        if (pixData.qr_code_base64) {
            document.getElementById("pixQrCode").src = "data:image/png;base64," + pixData.qr_code_base64;
            document.getElementById("pixContainer").style.display = "block";
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
        console.error("Erro ao criar pagamento PIX catch script:", error);
        //alert("Erro ao processar pagamento PIX.");
        document.getElementById("pixLoading").style.display = "none"; // Esconde o spinner em caso de erro
    }
});

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


@endsection