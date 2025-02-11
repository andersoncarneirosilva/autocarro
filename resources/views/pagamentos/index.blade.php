@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <h3 class="page-title">Dashboard</h3>
        </div>
    </div>
</div>
<br>

<div id="paymentBrick_container">
</div>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const mp = new MercadoPago('TEST-83c1af18-f3a5-4077-bc98-e72379b980b1', {
      locale: 'pt'
    });
    const bricksBuilder = mp.bricks();
  
    const renderPaymentBrick = async () => {
      try {
        // Requisição para obter um preferenceId do backend
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
            preferenceId: preferenceData.preferenceId,  // Use o preferenceId retornado aqui
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
              /*
               Callback chamado quando o Brick está pronto.
               Aqui, você pode ocultar seu site, por exemplo.
              */
            },
  
            onSubmit: ({ selectedPaymentMethod, formData }) => {
              return new Promise((resolve, reject) => {
                // Verificar se o paymentMethodId está presente
                if (!selectedPaymentMethod) {
                  alert('Por favor, selecione um método de pagamento.');
                  reject();
                  return;
                }
                formData.paymentMethodId = selectedPaymentMethod.id;
  
                // Enviar a requisição
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
                        window.location.href = "/pagamento-sucesso"; // Página de sucesso
                    } else {
                        window.location.href = "/pagamento-falha"; // Página de erro
                    }
                })
                .catch(error => {
                    console.error('Erro ao processar pagamento:', error);
                    alert('Erro ao processar pagamento.');
                });


              });
            },
  
            onError: (error) => {
              // callback chamado para todos os casos de erro do Brick
              console.error(error);
            },
          },
        };
  
        // Criando o Brick de pagamento
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
  
    renderPaymentBrick();
  </script>
  

@endsection