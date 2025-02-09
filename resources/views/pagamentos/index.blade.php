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
const renderPaymentBrick = async (bricksBuilder) => {
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
                payer_email: "andersonqipoa@gmail.com" // Envie o e-mail do pagador
            })
        });

        const preferenceData = await preferenceResponse.json();
        if (!preferenceData.preferenceId) {
            console.error("Erro ao obter preferenceId:", preferenceData);
            alert("Erro ao carregar o pagamento.");
            return;
        }

        // Agora configuramos o Brick com o preferenceId dinâmico
        const settings = {
            initialization: {
                amount: 10000,
                preferenceId: preferenceData.preferenceId, // 👈 Insere o ID dinâmico
                payer: {
                    firstName: "Anderson",
                    lastName: "Carneiro",
                    email: "andersonqipoa@gmail.com",
                },
            },
            customization: {
                visual: {
                    style: { theme: "default" },
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
                onSubmit: async ({ selectedPaymentMethod, formData }) => {
                    if (!selectedPaymentMethod) {
                        alert('Por favor, selecione um método de pagamento.');
                        return;
                    }
                    formData.paymentMethodId = selectedPaymentMethod.id;

                    try {
                        const response = await fetch("/api/process-payment", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken,
                            },
                            body: JSON.stringify(formData),
                        });

                        const data = await response.json();
                        console.log('Resposta do servidor:', data);

                        if (data.status === 'success') {
                            alert(data.message);
                        } else {
                            alert('Erro no pagamento: ' + data.message);
                        }
                    } catch (error) {
                        console.error('Erro na requisição:', error);
                        alert('Erro na comunicação com o servidor.');
                    }
                },
                onError: (error) => {
                    console.error(error);
                }
            }
        };

        window.paymentBrickController = await bricksBuilder.create("payment", "paymentBrick_container", settings);

    } catch (error) {
        console.error("Erro ao renderizar Brick:", error);
        alert("Erro ao carregar pagamento.");
    }
};
renderPaymentBrick(bricksBuilder);

</script>

@endsection