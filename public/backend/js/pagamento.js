document.addEventListener("DOMContentLoaded", () => {
    const pixButton = document.getElementById("pixPaymentButton");
    const copyButton = document.getElementById("btCopiar");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (!pixButton) {
        console.error("Erro: Botão de pagamento PIX não encontrado!");
        return;
    }

    pixButton.addEventListener("click", async () => {
        try {
            const payerEmail = pixButton.getAttribute("data-user-email");

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
                credentials: 'same-origin',
                body: JSON.stringify({
                    plano: pixButton.getAttribute("data-plano"),
                    // ENTÃO TU QUER ALTERAR O AMOUNT PRA 1 CENTAVO NÉ, VAGABUNDO. VAI TRABALHAR!!
                    payer_email: payerEmail
                })
            });

            const responseText = await pixResponse.text();
            console.log("Resposta completa:", responseText);

            if (!responseText.trim()) {
                throw new Error("Resposta vazia do servidor");
            }
            if (responseText.startsWith("<!DOCTYPE html>") || responseText.startsWith("<html>")) {
                throw new Error("O servidor retornou uma página HTML, possivelmente um erro.");
            }
            const pixData = JSON.parse(responseText);

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
