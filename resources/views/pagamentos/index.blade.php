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
            amount: 10000,
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
            amount: 10000,
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
              atm: "all",
              bankTransfer: "all",
              debitCard: "all",
              ticket: "all",
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
                fetch("/api/payment-updated", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify(formData),
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log('Resposta do servidor no script:', data);

                    // Verifique se a resposta contém a chave desejada (exemplo: "payment_token")
                    if (data.payment_token) {
                        alert('Token de pagamento recebido: ' + data.payment_token);  // Exibe o token recebido
                    } else {
                        alert('Erro no pagamento: ' + data.message);  // Exibe a mensagem de erro, se houver
                    }
                })
                .catch((error) => {
                    console.error('Erro na requisição:', error);
                    alert('Erro na comunicação com o servidor.');
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