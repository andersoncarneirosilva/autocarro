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
                                    Total: R$ {{ number_format($preco) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
          </div>

          <div class="col-lg-8">
            <div class="border p-3 mb-3 rounded">
              <div class="row align-items-center">
                  <div class="col-9">
                      <div class="form-check">
                          <input type="radio" id="BillingOptRadioCard" name="billingOptions" class="form-check-input" onclick="togglePayment('card')">
                          <label class="form-check-label font-16 fw-bold" for="BillingOptRadioCard">Pagamento com cartão</label>
                      </div>
                      <p class="mb-0 ps-3 pt-1">Pagamento com cartões de crédito e débito.</p>
                  </div>
                  <div class="col-3 text-end">
                      <img src="assets/images/payments/paypal.png" class="img-fluid" alt="paypal-img" width="75px">
                  </div>
              </div>
            </div>

            <!-- Div oculta para pagamento com cartão -->
            <div id="paymentBrick_container" class="border p-3 rounded" style="display: none;">
                <h5>Insira os dados do cartão</h5>
                <p>Aqui virá o conteúdo do pagamento via cartão.</p>
            </div>

            <!-- Pagamento via PIX -->
            <div class="border p-3 rounded">
              <div class="row align-items-center">
                <div class="col-9">
                    <div class="form-check">
                        <input type="radio" id="BillingOptRadioPix" name="billingOptions" class="form-check-input" onclick="togglePayment('pix')">
                        <label class="form-check-label font-16 fw-bold" for="BillingOptRadioPix">Pagamento via PIX</label>
                    </div>
                    <p class="mb-0 ps-3 pt-1">Escaneie ou copie o QR Code.</p>
                </div>
                <div class="col-3 text-end">
                    <img src="assets/images/payments/pix.png" class="img-fluid" alt="PIX-img" width="75px">
                </div>
              </div>
            </div>

            


<!-- Container para pagamento PIX (oculto por padrão) -->
<div id="pixPaymentContainer" class="border mt-3 p-3 rounded" style="display: none;">
    <!-- Botão para pagamento PIX -->
    <button id="pixPaymentButton" class="btn btn-success" style="display: block;" onclick="processPixPayment()">Pagar com PIX</button>

    <!-- Spinner de carregamento (inicialmente oculto) -->


    

    <div id="pixLoading" style="display: none; margin-top: 10px;">
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
  function togglePayment(type) {
      // Oculta todas as opções de pagamento
      document.getElementById('paymentBrick_container').style.display = 'none';
      document.getElementById('pixPaymentContainer').style.display = 'none';
      document.getElementById('pixContainer').style.display = 'none';
      document.getElementById('pixCopiaCola').style.display = 'none';
      document.getElementById('btCopiar').style.display = 'none';
      document.getElementById('pixErrorMessage').style.display = 'none'; // Oculta a mensagem de erro ao alternar pagamento

      if (type === 'card') {
          document.getElementById('paymentBrick_container').style.display = 'block';
      } else if (type === 'pix') {
          document.getElementById('pixPaymentContainer').style.display = 'block';
      }
  }

  function processPixPayment() {
    try {
        // Simula a geração do QR Code
        const qrCodeSrc = "assets/images/payments/qr-code.png"; // Substitua por lógica real para gerar o QR Code
        const boletoLink = "#"; // Substitua pelo link real do boleto PIX

        // Verificar se o QR Code e o link do boleto estão disponíveis
        if (qrCodeSrc && boletoLink) {
            document.getElementById('pixQrCode').src = qrCodeSrc;
            document.getElementById('pixTicketUrl').href = boletoLink;
            document.getElementById('pixContainer').style.display = 'block';
            document.getElementById('pixErrorMessage').style.display = 'none'; // Ocultar mensagem de erro
        } else {
            throw new Error("Informações do pagamento PIX não estão disponíveis.");
        }
    } catch (error) {
        // Exibir mensagem de erro caso algo tenha falhado
        document.getElementById('pixErrorMessage').style.display = 'block';
        document.getElementById('pixContainer').style.display = 'none'; // Ocultar o QR code e boleto
    }
}

</script>



<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
 //const mp = new MercadoPago('TEST-83c1af18-f3a5-4077-bc98-e72379b980b1', {
 const mp = new MercadoPago('APP_USR-46c2384a-3f32-4ff9-9b96-b4497129462b', {
     locale: 'pt'
 });
 const bricksBuilder = mp.bricks();
 
 const renderPaymentBrick = async () => {
     try {
         const preferenceResponse = await fetch('/api/create-preference', {
             method: 'POST',
             headers: {
                 'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': csrfToken
             },
             body: JSON.stringify({
                amount: {{ $preco }},
                 payer_email: "andersonqipoa@gmail.com"
             })
         });
 
         const preferenceData = await preferenceResponse.json();
         if (!preferenceData.preferenceId) {
             console.error("Erro ao obter preferenceId:", preferenceData);
             alert("Erro ao carregar o pagamento.");
             return;
         }
 
         const settings = {
             initialization: {
                 amount: {{ $preco }},
                 preferenceId: preferenceData.preferenceId,
                 payer: {
                     firstName: "Anderson",
                     lastName: "Carneiro",
                     email: "andersonqipoa@gmail.com",
                 },
             },
             customization: {
                 visual: {
                     style: {
                         theme: "default",
                     },
                 },
                 paymentMethods: {
                     creditCard: "all",
                     debitCard: "all",
                     atm: "all",
                     bankTransfer: "all",
                     maxInstallments: 1
                 },
             },
             callbacks: {
                 onReady: () => {
                     console.log("Brick pronto!");
                 },
                 onSubmit: ({ selectedPaymentMethod, formData }) => {
                     return new Promise((resolve, reject) => {
                         if (!selectedPaymentMethod) {
                             alert('Por favor, selecione um método de pagamento.');
                             reject();
                             return;
                         }
                         formData.paymentMethodId = selectedPaymentMethod.id;
 
                         fetch("/api/process-payment", {
                             method: "POST",
                             headers: {
                                 "Content-Type": "application/json",
                                 "X-CSRF-TOKEN": csrfToken,
                             },
                             body: JSON.stringify(formData),
                         })
                         .then(response => response.json())
                         .then(data => {
                             if (data.payment_status === "approved") {
                                 window.location.href = "/pagamento-sucesso";
                             } else {
                                 window.location.href = "/pagamento-falha";
                             }
                         })
                         .catch(error => {
                             console.error('Erro ao processar pagamento:', error);
                             alert('Erro ao processar pagamento.');
                         });
                     });
                 },
                 onError: (error) => {
                     console.error("Erro no Brick:", error);
                 },
             },
         };
 
         window.paymentBrickController = await bricksBuilder.create(
             "payment",
             "paymentBrick_container",
             settings
         );
 
     } catch (error) {
         console.error("Erro ao renderizar Brick:", error);
         alert("Erro ao carregar pagamento.");
     }
 };
 
 document.getElementById("pixPaymentButton").addEventListener("click", async () => {
    try {
        // Exibe o spinner e esconde o conteúdo
        document.getElementById("pixLoading").style.display = "block";
        document.getElementById("pixContainer").style.display = "none";
        document.getElementById("pixCopiaCola").style.display = "none";
        document.getElementById("btCopiar").style.display = "none";
        document.getElementById("pixPaymentButton").style.display = "none";
        const pixResponse = await fetch('/api/create-pix-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                amount: {{ $preco }},
                payer_email: "andersonqipoa@gmail.com"
            })
        });

        const pixData = await pixResponse.json();

        console.log(pixData); // Debugging

        // Esconde o spinner
        document.getElementById("pixLoading").style.display = "none";
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
        console.error("Erro ao criar pagamento PIX:", error);
        alert("Erro ao processar pagamento PIX.");
        document.getElementById("pixLoading").style.display = "none"; // Esconde o spinner em caso de erro
    }
});
 
 // Chama a função para renderizar o brick de pagamento
 renderPaymentBrick();
 
 </script>
 

 <script>
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
