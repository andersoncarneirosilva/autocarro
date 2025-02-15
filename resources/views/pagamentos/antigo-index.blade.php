

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Toast Bootstrap no canto superior direito -->
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
                <select class="form-select mb-3">
                    <option selected value="">Adicionar créditos</option>
                    <option value="1">- R$ 10</option>
                    <option value="20">- R$ 20</option>
                    <option value="30">- R$ 30</option>
                    <option value="50">- R$ 50</option>
                    <option value="100">- R$ 100</option>
                </select>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr class="fw-bold">
                                <td>Total:</td>
                                <td class="text-end"><span id="total">R$7,50</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Botão de pagamento -->
                {{-- <div class="d-grid mt-3">
                    <button class="btn btn-primary btn-lg w-100">Finalizar Compra</button>
                </div> --}}
            </div>
            <br>
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
    <button id="pixPaymentButton" class="btn btn-success" onclick="processPixPayment()">Pagar com PIX</button>

    <!-- Container para exibir o QR Code PIX -->
    <div id="pixContainer" style="display: none;">
        <h3>Escaneie o QR Code para pagar com PIX:</h3>
        <img id="pixQrCode" src="" alt="QR Code PIX" style="width: 300px;">
        <a id="pixTicketUrl" href="#" target="_blank"></a>
    </div>
    
    <div class="input-group">
        <div class="col-sm-6">
        <input type="text" id="pixCopiaCola" class="form-control" readonly>
        </div>
        <div class="col-sm-6">
            <button class="btn btn-outline-secondary" id="btCopiar" type="button">Copiar</button>
            </div>
    </div>
    <!-- Mensagem de erro (oculta por padrão) -->
    <p id="pixErrorMessage" style="color: red; display: none;">Erro ao processar pagamento PIX.</p>
</div>




            
            
            
            



          </div>

          <!-- Resumo do Pedido -->
          <!-- Resumo do Pedido -->
          
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
 const mp = new MercadoPago('TEST-83c1af18-f3a5-4077-bc98-e72379b980b1', {
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
                 amount: 1,
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
                 amount: 1,
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
 
 // Única definição do clique do botão PIX
 document.getElementById("pixPaymentButton").addEventListener("click", async () => {
     try {
         const pixResponse = await fetch('/api/create-pix-payment', {
             method: 'POST',
             headers: {
                 'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': csrfToken
             },
             body: JSON.stringify({
                 amount: 1,
                 payer_email: "andersonqipoa@gmail.com"
             })
         });
 
         const pixData = await pixResponse.json();
         
         // Verificar o que está sendo retornado da API
         console.log(pixData); // Adicionando log para depuração
 
         if (pixData.qr_code_base64) {
             document.getElementById("pixQrCode").src = "data:image/png;base64," + pixData.qr_code_base64;
             document.getElementById("pixContainer").style.display = "block";
         }
         if(pixData.qr_code){
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