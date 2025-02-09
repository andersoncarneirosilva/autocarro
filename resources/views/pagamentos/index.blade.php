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
  const renderPaymentBrick = async (bricksBuilder) => {
    const settings = {
      initialization: {
        /*
          "amount" é a quantia total a pagar por todos os meios de pagamento com exceção da Conta Mercado Pago e Parcelas sem cartão de crédito, que têm seus valores de processamento determinados no backend através do "preferenceId"
        */
        amount: 10000,
        preferenceId: "<PREFERENCE_ID>",
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
                fetch("/process-payment", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken, // Adiciona o token CSRF nos cabeçalhos
                    },
                    body: JSON.stringify(formData),
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log('Resposta do servidor:', data);  // Verifique o conteúdo da resposta
                    if (data.status === 'success') {
                        alert(data.message);  // Exibe a mensagem de sucesso
                        resolve();  // Indica que o pagamento foi processado com sucesso
                    } else {
                        alert('Erro no pagamento: ' + data.message);  // Exibe a mensagem de erro
                        reject();  // Indica que houve um erro no pagamento
                    }
                })
                .catch((error) => {
                    console.error('Erro na requisição:', error);
                    alert('Erro na comunicação com o servidor.');
                    reject();  // Caso ocorra erro na requisição
                });

            });
        },

        onError: (error) => {
          // callback chamado para todos os casos de erro do Brick
          console.error(error);
        },
      },
    };
    window.paymentBrickController = await bricksBuilder.create(
      "payment",
      "paymentBrick_container",
      settings
    );
  };
  renderPaymentBrick(bricksBuilder);
</script>

@endsection