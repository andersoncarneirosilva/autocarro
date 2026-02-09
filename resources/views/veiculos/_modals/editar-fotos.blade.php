<div class="modal fade" id="modalUploadFotos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="mdi mdi-camera-plus me-1"></i> Gerenciador de Fotos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form action="{{ route('veiculos.uploadFotos', $veiculo->id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="upload-zone border-dashed rounded-3 p-4 mb-3 text-center bg-light" id="dropzone" style="cursor: pointer; border: 2px dashed #dee2e6;">
                        <input type="file" name="images[]" id="inputFotos" hidden multiple accept="image/*">
                        <i class="mdi mdi-cloud-upload text-primary" style="font-size: 40px;"></i>
                        <h5 class="mt-2">Clique ou arraste as fotos aqui</h5>
                        <p class="text-muted small">Você pode selecionar várias fotos de uma vez.</p>
                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-4" onclick="document.getElementById('inputFotos').click()">
                            Selecionar Arquivos
                        </button>
                    </div>

                    <div id="previewContainer" class="row g-2 mb-3"></div>

                    <div class="d-grid shadow-sm" id="btnSalvarFotos" style="display: none !important;">
                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-check-all me-1"></i> Confirmar Envio das Fotos
                        </button>
                    </div>
                </form>

                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1">
                    <span class="mx-3 text-muted small fw-bold">FOTOS JÁ CADASTRADAS</span>
                    <hr class="flex-grow-1">
                </div>

                <div class="row g-2" id="galeria-fotos">
                    @php $imagensNoBanco = json_decode($veiculo->images) ?? []; @endphp

                    @forelse($imagensNoBanco as $index => $img)
                        <div class="col-4 col-md-3 col-lg-2 mb-2" id="foto-container-{{ $index }}">
                            <div class="card h-100 m-0 border shadow-none overflow-hidden group-hover">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $img) }}" class="card-img-top" style="height: 100px; object-fit: cover;">
                                    
                                    <div class="position-absolute top-0 end-0 p-1">
                                        <button type="button" class="btn btn-danger btn-sm rounded-circle p-0 btn-delete-foto shadow" 
                                                data-url="{{ route('veiculos.deleteFoto', [$veiculo->id, $index]) }}" 
                                                style="width: 24px; height: 24px;">
                                            <i class="mdi mdi-close"></i>
                                        </button>
                                    </div>

                                    @if($index != 0)
                                    <div class="position-absolute top-0 start-0 p-1">
                                        <button type="button" class="btn btn-light btn-sm rounded-circle p-0 btn-set-main shadow" 
                                                data-url="{{ route('veiculos.setMainFoto', [$veiculo->id, $index]) }}"
                                                title="Definir como principal"
                                                style="width: 24px; height: 24px;">
                                            <i class="mdi mdi-star-outline text-warning"></i>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                                
                                @if($index == 0)
                                    <div class="card-footer p-0 border-0">
                                        <div class="bg-warning text-dark text-center fw-bold small py-1" style="font-size: 10px;">
                                            FOTO DE CAPA
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4 bg-light rounded shadow-sm border" id="no-photos-msg">
                            <i class="mdi mdi-image-multiple-outline d-block font-24 text-muted"></i>
                            <span class="text-muted">Ainda não há fotos para este veículo.</span>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilo Hyper Dashboard */
    .upload-zone:hover {
        background-color: #f1f3fa !important;
        border-color: #3b5de7 !important;
        transition: 0.3s;
    }
    .border-dashed { border-style: dashed !important; }
    .btn-xs { padding: 1px 5px; font-size: 10px; }
    .group-hover:hover { transform: translateY(-2px); transition: 0.2s; box-shadow: 0 5px 10px rgba(0,0,0,0.1) !important; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Seleção de elementos (IDs do seu modal)
    const dropzone = document.getElementById('dropzone');
    const inputFotos = document.getElementById('inputFotos');
    const previewContainer = document.getElementById('previewContainer');
    const btnSalvar = document.getElementById('btnSalvarFotos');

    // --- FUNÇÃO DE RENDERIZAÇÃO (Unificada para evitar duplicados) ---
    function renderPreview(files) {
        if (!previewContainer) return;
        previewContainer.innerHTML = ''; 
        
        if (files.length > 0) {
            if(btnSalvar) btnSalvar.style.setProperty('display', 'block', 'important');
            
            Array.from(files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'col-3 col-md-2 mb-2';
                    div.innerHTML = `<img src="${e.target.result}" class="img-thumbnail shadow-sm" style="height: 65px; width: 100%; object-fit: cover;">`;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            if(btnSalvar) btnSalvar.style.setProperty('display', 'none', 'important');
        }
    }

    // --- DRAG AND DROP ---
    if (dropzone && inputFotos) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, e => { e.preventDefault(); e.stopPropagation(); }, false);
        });

        dropzone.addEventListener('dragover', () => {
            dropzone.style.backgroundColor = "#f1f3fa";
            dropzone.style.borderColor = "#727cf5";
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.style.backgroundColor = "";
            dropzone.style.borderColor = "#dee2e6";
        });

        dropzone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            inputFotos.files = files; // Sincroniza o input
            renderPreview(files);
        });

        inputFotos.addEventListener('change', function() {
            renderPreview(this.files);
        });
    }

    // --- DELEÇÃO E FOTO PRINCIPAL (Event Delegation) ---
    document.addEventListener('click', function(e) {
        // Botão FOTO PRINCIPAL
        const btnMain = e.target.closest('.btn-set-main');
        if (btnMain && !btnMain.disabled) {
            btnMain.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            btnMain.disabled = true;
            executarAcao(btnMain.getAttribute('data-url'), 'POST');
        }

        // Botão DELETAR
        const btnDel = e.target.closest('.btn-delete-foto');
        if (btnDel) {
            const index = btnDel.getAttribute('data-index');
            const container = document.getElementById(`foto-container-${index}`);
            if (container) {
                container.style.opacity = '0.3';
                container.style.pointerEvents = 'none';
            }
            executarAcao(btnDel.getAttribute('data-url'), 'DELETE');
        }
    });

    // Função auxiliar para fetch
    function executarAcao(url, metodo) {
        fetch(url, {
            method: metodo,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success || data.message) window.location.reload();
            else window.location.reload();
        })
        .catch(err => {
            console.error(err);
            window.location.reload();
        });
    }
});
</script>