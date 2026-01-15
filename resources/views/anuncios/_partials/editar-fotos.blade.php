<div class="modal fade" id="modalUploadFotos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"><i class="mdi mdi-camera-plus-outline me-1"></i> Gerenciar Fotos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form action="{{ route('anuncios.uploadFotos', $veiculo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Adicionar Novas Fotos</label>
                        <input type="file" name="images[]" id="inputFotos" class="form-control font-13" multiple accept="image/*">
                    </div>
                    <div id="previewContainer" class="row g-2 mb-3"></div>
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill mb-3" id="btnSalvarFotos" style="display: none;">
                        <i class="mdi mdi-cloud-upload me-1"></i> Iniciar Upload
                    </button>
                </form>

                <hr>

                <label class="form-label text-muted small uppercase fw-bold mb-2">Fotos Cadastradas</label>
                <div class="row g-2" id="galeria-fotos">
                    @php $imagensNoBanco = json_decode($veiculo->images) ?? []; @endphp

                    @forelse($imagensNoBanco as $index => $img)
                        <div class="col-4 col-md-3 col-lg-2" id="foto-container-{{ $index }}">
                            <div class="position-relative border rounded shadow-sm overflow-hidden" style="height: 100px;">
                                <img src="{{ asset('storage/' . $img) }}" class="w-100 h-100" style="object-fit: cover;">
                                
                                <button type="button" 
                                        class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1 shadow-sm btn-delete-foto" 
                                        data-url="{{ route('anuncios.deleteFoto', [$veiculo->id, $index]) }}"
                                        data-index="{{ $index }}"
                                        style="width: 24px; height: 24px; padding: 0;">
                                    <i class="mdi mdi-trash-can-outline"></i>
                                </button>

                                <span class="position-absolute bottom-0 start-0 badge bg-dark opacity-75 font-10 m-1">
                                    #{{ $index + 1 }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-3" id="no-photos-msg">
                            <p class="text-muted small">Nenhuma foto cadastrada.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<script>
// --- Script de Preview (Mantido) ---
document.getElementById('inputFotos').addEventListener('change', function(event) {
    const container = document.getElementById('previewContainer');
    const btnSalvar = document.getElementById('btnSalvarFotos');
    container.innerHTML = ''; 

    if (this.files && this.files.length > 0) {
        btnSalvar.style.display = 'inline-block';
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-4 col-md-3 col-lg-2 mb-2';
                div.innerHTML = `<div class="position-relative border-primary border rounded shadow-sm bg-white p-1" style="height: 100px;">
                    <img src="${e.target.result}" class="w-100 h-100 rounded" style="object-fit: cover;">
                    <span class="position-absolute top-0 start-0 badge bg-success font-10 m-1">PREVIEW</span>
                </div>`;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    } else {
        btnSalvar.style.display = 'none';
    }
});

// --- Script de Exclusão Corrigido ---
document.addEventListener('click', function(e) {
    // Verifica se o clique foi no botão de delete ou em um ícone dentro dele
    const btn = e.target.closest('.btn-delete-foto');
    if (!btn) return;

    const url = btn.getAttribute('data-url');
    const index = btn.getAttribute('data-index');
    const container = document.getElementById(`foto-container-${index}`);

    // Feedback visual imediato
    container.style.opacity = '0.3';
    container.style.pointerEvents = 'none';

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            container.remove();
            
            // Verifica se ainda existem fotos na galeria
            const fotosRestantes = document.querySelectorAll('.btn-delete-foto');
            const msgVazio = document.getElementById('no-photos-msg');
            
            if (fotosRestantes.length === 0 && msgVazio) {
                msgVazio.classList.remove('d-none');
            }
        } else {
            alert('Erro ao excluir foto.');
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        container.style.opacity = '1';
        container.style.pointerEvents = 'auto';
    });
});
</script>