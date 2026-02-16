<div class="modal fade" id="modalCadastrarFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Nova Foto para Vitrine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('galeria.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Arquivo de Imagem</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" required>
                        <small class="text-muted">Tamanho máximo: 2MB. Formatos: JPG, PNG, WebP.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Fazer Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>