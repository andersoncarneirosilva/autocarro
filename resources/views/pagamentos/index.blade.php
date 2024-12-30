@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Usuários</li>
                </ol>
            </div>
            <h3 class="page-title">Usuários</h3>
        </div>
    </div>
</div>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">

            <div id="paymentBrick_container">
            </div>
            <script>
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
                      firstName: "",
                      lastName: "",
                      email: "",
                    },
                  },
                  customization: {
                    visual: {
                      hideFormTitle: true,
                      hidePaymentButton: true,
                      style: {
                        theme: "default",
                      },
                    },
                    paymentMethods: {
                      atm: "all",
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
                      // callback chamado quando há click no botão de envio de dados
                      return new Promise((resolve, reject) => {
                        fetch("/process_payment", {
                          method: "POST",
                          headers: {
                            "Content-Type": "application/json",
                          },
                          body: JSON.stringify(formData),
                        })
                          .then((response) => response.json())
                          .then((response) => {
                            // receber o resultado do pagamento
                            resolve();
                          })
                          .catch((error) => {
                            // manejar a resposta de erro ao tentar criar um pagamento
                            reject();
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
        </div>
    </div>
    
</div>
<br>


@endsection