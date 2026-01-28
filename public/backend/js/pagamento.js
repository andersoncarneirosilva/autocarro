document.addEventListener("DOMContentLoaded", () => {
    const pixButton = document.getElementById("pixPaymentButton");
    const copyButton = document.getElementById("btCopiar");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const publicKey = document.getElementById("pixPaymentButton")?.getAttribute("data-public-key") || '';

    if (!pixButton) {
        console.error("Erro: Botão de pagamento PIX não encontrado!");
        return;
    }

    // Evento de pagamento PIX
    pixButton.addEventListener("click", async () => {
        try {
            const amount = parseFloat(pixButton.getAttribute("data-preco"));
            const payerEmail = pixButton.getAttribute("data-user-email");

            // Exibe o spinner e esconde o conteúdo
            document.getElementById("pixLoading").style.display = "block";
            document.getElementById("pixContainer").style.display = "none";
            document.getElementById("pixCopiaCola").style.display = "none";
            document.getElementById("btCopiar").style.display = "none";
            document.getElementById("pixPaymentButton").style.display = "none";
            document.getElementById("divGerarPix").style.display = "none";

            const pixResponse = await fetch('/create-pix-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    amount: amount,
                    payer_email: payerEmail,
                    public_key: publicKey
                })
            });

            // Obtém a resposta como texto para verificar erros
            const responseText = await pixResponse.text();
            console.log("Resposta completa:", responseText);

            // Verifica se a resposta está vazia
            if (!responseText.trim()) {
                throw new Error("Resposta vazia do servidor");
            }

            // Verifica se a resposta contém HTML (erro do Laravel ou servidor)
            if (responseText.startsWith("<!DOCTYPE html>") || responseText.startsWith("<html>")) {
                throw new Error("O servidor retornou uma página HTML, possivelmente um erro.");
            }

            // Converte a resposta para JSON
            const pixData = JSON.parse(responseText);

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
            console.error("Erro ao criar pagamento PIX:", error);
            alert("Erro ao processar pagamento PIX.");
            document.getElementById("pixLoading").style.display = "none";
        }
    });

    // Evento de cópia do código PIX
    if (copyButton) {
        copyButton.addEventListener("click", function () {
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
    } else {
        console.error("Erro: Botão de copiar PIX não encontrado!");
    }
});
