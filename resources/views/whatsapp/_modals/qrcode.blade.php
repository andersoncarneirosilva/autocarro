<div id="modalQR" class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered"> {{-- Alterado para modal-lg --}}
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-light">
                <h5 class="modal-title d-flex align-items-center">
                    <i class="mdi mdi-whatsapp text-success h3 my-0 me-2"></i> 
                    <span>Conectar Instância ao WhatsApp</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-5 text-center border-end">
                        <div id="qr-container" style="min-height: 280px;" class="d-flex align-items-center justify-content-center flex-column">
    <div id="qr-spinner" class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    
    <div id="qr-result" class="mt-2"></div>
    
    <div id="qr-success" class="d-none text-center">
        <i class="mdi mdi-check-circle text-success" style="font-size: 5rem;"></i>
        <h4 class="mt-2 text-success">Aparelho Conectado!</h4>
    </div>
</div>
                    </div>

                    <div class="col-md-7">
                        <div class="ps-md-4">
                            <h4 class="header-title mb-3">Siga os passos abaixo:</h4>
                            
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <span class="avatar-xs">
                                        <span class="avatar-title bg-soft-primary text-primary rounded-circle font-13 fw-bold">1</span>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <p class="mb-0">Abra o <strong>WhatsApp</strong> no seu aparelho celular.</p>
                                </div>
                            </div>

                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <span class="avatar-xs">
                                        <span class="avatar-title bg-soft-primary text-primary rounded-circle font-13 fw-bold">2</span>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <p class="mb-0">Toque em <strong>Menu</strong> <i class="mdi mdi-dots-vertical"></i> ou <strong>Configurações</strong> <i class="mdi mdi-cog"></i> e selecione <strong>Aparelhos Conectados</strong>.</p>
                                </div>
                            </div>

                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <span class="avatar-xs">
                                        <span class="avatar-title bg-soft-primary text-primary rounded-circle font-13 fw-bold">3</span>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <p class="mb-0">Toque em <strong>Conectar um aparelho</strong>.</p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <span class="avatar-xs">
                                        <span class="avatar-title bg-soft-primary text-primary rounded-circle font-13 fw-bold">4</span>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <p class="mb-0">Aponte a câmera para esta tela para escanear o código QR Code ao lado.</p>
                                </div>
                            </div>

                            <div class="alert alert-warning border-0 mt-4 mb-0" role="alert">
                                <i class="mdi mdi-alert-circle-outline me-2"></i>
                                <strong>Importante:</strong> Não feche esta janela até que a conexão seja confirmada.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light/50 border-0 justify-content-center">
                <p class="text-muted mb-0 small">ID da Conexão: <span class="fw-bold text-dark">{{ $instance->name ?? 'Instância Ativa' }}</span></p>
            </div>
        </div>
    </div>
</div>