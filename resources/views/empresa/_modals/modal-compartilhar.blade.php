<div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <div class="ps-2 pt-2">
                    <h5 class="fw-bold mb-1">Compartilhar Vitrine</h5>
                    <p class="text-muted small mb-0">Convide clientes para agendar</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                @php
                    // URL da Vitrine Pública baseada no slug
                    $urlVitrine = url('/' . $empresa->slug);
                    
                    // Mensagem personalizada
                    $textoShare = "Olá! Agende seu horário no " . $empresa->razao_social . " de forma rápida e fácil pelo nosso site:";
                    $shareFullText = $textoShare . " " . $urlVitrine;
                @endphp

                <ul class="list-group list-group-flush">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($shareFullText) }}" target="_blank"
                       class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #24A148;">
                            <i class="mdi mdi-whatsapp text-white fs-4"></i>
                        </div>
                        <span class="fw-medium">Enviar pelo WhatsApp</span>
                    </a>

                    <a href="javascript:void(0)" onclick="socialPopup('https://www.facebook.com/sharer/sharer.php?u={{ urlencode($urlVitrine) }}')" 
                       class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #405994;">
                            <i class="mdi mdi-facebook text-white fs-4"></i>
                        </div>
                        <span class="fw-medium">Postar no Facebook</span>
                    </a>

                    <button onclick="copyToClipboard('{{ $urlVitrine }}')" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #727cf5;">
                            <i class="mdi mdi-link-variant text-white fs-4"></i>
                        </div>
                        <div class="d-flex flex-column text-start">
                            <span class="fw-medium">Copiar link da vitrine</span>
                            <small id="copy-status" class="text-success" style="display:none;">Link copiado!</small>
                        </div>
                    </button>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function socialPopup(url) {
    const width = 600;
    const height = 450;
    const left = (screen.width - width) / 2;
    const top = (screen.height - height) / 2;
    window.open(url, 'sharer', `width=${width},height=${height},top=${top},left=${left},toolbar=0,status=0,location=0,menubar=0,scrollbars=1,resizable=1`);
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const status = document.getElementById('copy-status');
        status.style.display = 'block';
        setTimeout(() => {
            status.style.display = 'none';
        }, 2500);
    }).catch(err => {
        console.error('Erro ao copiar link: ', err);
    });
}
</script>