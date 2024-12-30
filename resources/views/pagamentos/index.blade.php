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
                        // Callback chamado quando o Brick está pronto.
                      },
                      onSubmit: ({ selectedPaymentMethod, formData }) => {
                        return new Promise((resolve, reject) => {
                          // Obtém o token CSRF do meta tag
                          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                          fetch("/createPayment", {
                            method: "POST",
                            headers: {
                              "Content-Type": "application/json",
                              "X-CSRF-TOKEN": csrfToken, // Adiciona o token CSRF aqui
                            },
                            body: JSON.stringify(formData),
                          })
                            .then((response) => response.json())
                            .then((response) => {
                              // Receber o resultado do pagamento
                              resolve(response);
                            })
                            .catch((error) => {
                              // Manejar a resposta de erro ao tentar criar um pagamento
                              console.error("Erro ao criar o pagamento:", error);
                              reject(error);
                            });
                        });
                      },
                      onError: (error) => {
                        // Callback chamado para todos os casos de erro do Brick
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