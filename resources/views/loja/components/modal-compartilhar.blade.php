<div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <div class="ps-2 pt-2">
                    <h5 class="fw-bold mb-1">Compartilhar Veículo</h5>
                    <p class="text-muted small mb-0">{{ $veiculo->marca_real }} {{ $veiculo->modelo_real }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                @php
                    // Prepara a mensagem de texto para as redes sociais
                    $textoShare = "Confira este " . $veiculo->marca_real . " " . $veiculo->modelo_real . " no Alcecar!";
                    if($veiculo->valor) {
                        $textoShare .= " por apenas R$ " . number_format($veiculo->valor, 2, ',', '.');
                    }
                    $urlAtual = url()->current();
                    $shareFullText = $textoShare . " " . $urlAtual;
                @endphp

                <ul class="list-group list-group-flush">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($shareFullText) }}" target="_blank"
                       class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #24A148;">
                            <i class="bi bi-whatsapp text-white fs-5"></i>
                        </div>
                        <span class="fw-medium">Whatsapp</span>
                    </a>

                    <a href="javascript:void(0)" onclick="socialPopup('https://www.facebook.com/sharer/sharer.php?u={{ urlencode($urlAtual) }}')" 
                       class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #405994;">
                            <i class="bi bi-facebook text-white fs-5"></i>
                        </div>
                        <span class="fw-medium">Facebook</span>
                    </a>

                    <a href="javascript:void(0)" onclick="socialPopup('https://twitter.com/intent/tweet?url={{ urlencode($urlAtual) }}&text={{ urlencode($textoShare) }}')"
                       class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #000;">
                            <i class="bi bi-twitter-x text-white fs-5"></i>
                        </div>
                        <span class="fw-medium">X (Twitter)</span>
                    </a>

                    <button onclick="copyToClipboard()" class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #F28000;">
                            <i class="bi bi-link-45deg text-white fs-4"></i>
                        </div>
                        <div class="d-flex flex-column text-start">
                            <span class="fw-medium">Copiar link</span>
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

function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
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