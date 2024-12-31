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
                    amount: 10000,  // Ajuste conforme necessário
                    preferenceId: "<PREFERENCE_ID>",  // Substitua com o seu ID da preferência
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
                        console.log("Form Data:", formData);  // Para depuração, verifique se formData contém os dados corretos
                        
                        fetch("/pagamentos", {
                          method: "POST",
                          headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,  // Usando o token CSRF corretamente
                          },
                          body: JSON.stringify(formData),  // Envia os dados do formulário
                        })
                          .then((response) => {
                            console.log("Response Status:", response.status);
                            if (!response.ok) {
                              throw new Error('Erro ao processar o pagamento');
                            }
                            return response.json(); // Tenta converter para JSON
                          })
                          .then((data) => {
                            console.log("Response Data:", data);
                            if (data.status === 'success') {
                              // Caso o pagamento seja bem-sucedido
                              alert(data.message);  // Exibe uma mensagem de sucesso
                              window.location.href = '/pagina-de-confirmacao';  // Redireciona para a página de confirmação (ajuste conforme necessário)
                            } else {
                              // Caso ocorra algum erro no processamento do pagamento
                              alert(data.message || 'Ocorreu um erro no pagamento.'); 
                            }
                            resolve();
                          })
                          .catch((error) => {
                            console.error("Erro ao criar pagamento:", error);
                            alert('Erro ao processar o pagamento. Tente novamente.');
                            reject();
                          });
                      });
                    },
                    onError: (error) => {
                      // Callback chamado para todos os casos de erro do Brick
                      console.error("Erro no Brick:", error);
                      alert('Erro no pagamento. Tente novamente.');
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