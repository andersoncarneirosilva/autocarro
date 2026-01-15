<div class="row">
    <div class="col-4">
<p class="text-muted mb-2 mt-2 font-13"><strong>DOCUMENTOS GERADOS</strong></p>
    </div>
    <div class="col-8 text-end">
        <button type="button" class="btn btn-sm btn-primary" onclick="openCrlvModal(event, {{ $veiculo->id }})">
                                                <i class="mdi mdi-file-outline me-1"></i> NOVO CRLV
                                            </button>
        <button type="button" class="btn btn-sm btn-primary" onclick="openProcModal(event, {{ $veiculo->id }})">
                                                <i class="mdi mdi-file-outline me-1"></i> NOVA PROCURAÇÃO
                                            </button>
                                            @if ($veiculo->crv === '***')
                                            <button type="button" class="btn btn-sm btn-secondary" disabled>
                                                <i class="mdi mdi-file-outline me-1"></i> NOVA SOLICITAÇÃO ATPVE
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-sm btn-primary" onclick="{{ $veiculo->crv === '***' ? 'return false;' : "openAddressModal(event, $veiculo->id)" }}">
                                                <i class="mdi mdi-file-outline me-1"></i> NOVA SOLICITAÇÃO ATPVE
                                            </button>
                                            @endif
    </div>
</div>

<p class="text-muted mb-2 mt-2 font-13"><i class="mdi mdi-file-outline"></i> <strong>CRLV</strong></p>

@if (!empty($veiculo->arquivo_doc))
    <div class="row mb-2" style="text-align: left;">
        <div class="col-12">
            <div class="shadow-none border rounded p-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-reset rounded">
                                <i class="mdi mdi-file-pdf-box text-danger font-36"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col ps-0" style="text-align: left;">
                        <a href="{{ $veiculo->arquivo_doc }}" target="_blank"
    class="text-muted fw-bold">{{ basename($veiculo->arquivo_doc) }}</a>

                        <p class="mb-0 font-13">
                            {{ number_format($veiculo->size_doc / 1024, 2, ',', '.') }} KB</p>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('veiculos.excluir_doc', $veiculo->id) }}" method="POST"
                            id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="text-secondary font-20" id="deleteIcon">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </a>
                        </form>
                        <script>
                            document.getElementById('deleteIcon').addEventListener('click', function(event) {
                                event.preventDefault(); // Impede o envio do formulário inicialmente

                                Swal.fire({
                                    title: 'Atenção',
                                    text: "Deseja excluir este documento?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sim, excluir!',
                                    cancelButtonText: 'Cancelar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('deleteForm')
                                            .submit(); // Envia o formulário se o usuário confirmar
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


<p class="text-muted mb-2 mt-2 font-13"><i class="mdi mdi-file-document-outline"></i> <strong>Procuração</strong></p>
@if (!empty($veiculo->arquivo_proc))
    <div class="row mb-2">
        <div class="col-12">
            <div class="shadow-none border rounded p-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-reset rounded">
                                <i class="mdi mdi-file-pdf-box text-danger font-36"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col ps-0" style="text-align: left;">
                        <a href="{{ $veiculo->arquivo_proc }}" target="_blank"
                            class="text-muted fw-bold">{{ basename($veiculo->arquivo_proc) }}</a>
                        <p class="mb-0 font-13">
                            {{ number_format($veiculo->size_proc / 1024, 2, ',', '.') }} KB</p>
                    </div>

                    <div class="col-auto">
                        <form action="{{ route('veiculos.excluir_proc', $veiculo->id) }}"
                            method="POST" id="deleteProcForm">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="text-secondary font-20" id="deleteProcIcon">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </a>
                        </form>
                        <script>
                            document.getElementById('deleteProcIcon').addEventListener('click', function(event) {
                                event.preventDefault(); // Impede o envio do formulário inicialmente

                                Swal.fire({
                                    title: 'Atenção',
                                    text: "Deseja excluir esta procuração?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sim, excluir!',
                                    cancelButtonText: 'Cancelar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('deleteProcForm')
                                            .submit(); // Envia o formulário se o usuário confirmar
                                    }
                                });
                            });
                        </script>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end shadow-none border rounded -->
        </div> <!-- end col-12 -->
    </div> <!-- end row -->
@endif


<p class="text-muted mb-2 mt-2 font-13"><i class="mdi mdi-file-edit-outline"></i> <strong>Solicitação ATPVE</strong></p>
@if (!empty($veiculo->arquivo_atpve))
    <div class="row mb-2">
        <div class="col-12">
            <div class="shadow-none border rounded p-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-reset rounded">
                                <i class="mdi mdi-file-pdf-box text-danger font-36"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col ps-0" style="text-align: left;">
                        <a href="{{ $veiculo->arquivo_atpve }}" target="_blank"
                            class="text-muted fw-bold">{{ basename($veiculo->arquivo_atpve) }}</a>
                        <p class="mb-0 font-13">
                            {{ number_format($veiculo->size_atpve / 1024, 2, ',', '.') }} KB</p>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('veiculos.excluir_atpve', $veiculo->id) }}"
                            method="POST" id="deleteAtpveForm">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="text-secondary font-20" id="deleteAtpveIcon">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </a>
                        </form>
                        <script>
                            document.getElementById('deleteAtpveIcon').addEventListener('click', function(event) {
                                event.preventDefault(); // Impede o envio do formulário inicialmente

                                Swal.fire({
                                    title: 'Atenção',
                                    text: "Deseja excluir esta ATPVe?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sim, excluir!',
                                    cancelButtonText: 'Cancelar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('deleteAtpveForm')
                                            .submit(); // Envia o formulário se o usuário confirmar
                                    }
                                });
                            });
                        </script>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end shadow-none border rounded -->
        </div> <!-- end col-12 -->
    </div> <!-- end row -->
@endif

@if (empty($veiculo->arquivo_proc || $veiculo->arquivo_atpve || $veiculo->arquivo_doc))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger bg-transparent text-danger" role="alert">
                NENHUM RESULTADO ENCONTRADO!
            </div>
        </div>
    </div>
@endif

<hr>

<div class="row">
    <div class="col-6">
<p class="text-muted mb-2 mt-2 font-13"><strong>DOCUMENTOS ASSINADOS</strong></p>
    </div>
    <div class="col-6 text-end">
        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalProcuracao">
                                            PROCURAÇÃO
                                        </button>

                                        <!-- Botão para abrir modal de ATPVe -->
                                        @if (empty($veiculo->arquivo_atpve))
                                            <button class="btn btn-secondary btn-sm" disabled>SOLICITAÇÃO ATPVE</button>
                                            @else
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalAtpve">SOLICITAÇÃO ATPVE</button>
                                        @endif
    </div>
</div>
@if (!empty($veiculo->arquivo_proc_assinado))
    <div class="row mb-2" style="text-align: left;">
        <div class="col-12">
            <div class="shadow-none border rounded p-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-reset rounded">
                                <i class="mdi mdi-file-pdf-box text-danger font-36"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col ps-0" style="text-align: left;">
                        <a href="{{ $veiculo->arquivo_proc_assinado }}" target="_blank"
                            class="text-muted fw-bold">{{ basename($veiculo->arquivo_proc_assinado) }}</a>
                        <p class="mb-0 font-13">
                            {{ number_format($veiculo->size_proc_pdf / 1024, 2, ',', '.') }} KB</p>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('veiculos.excluir_proc_assinado', $veiculo->id) }}"
                            method="POST" id="deleteProcAssinadoForm">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="text-secondary font-20"
                                id="deleteProcAssinadoIcon">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </a>
                        </form>
                        <script>
                            document.getElementById('deleteProcAssinadoIcon').addEventListener('click', function(event) {
                                event.preventDefault(); // Impede o envio do formulário inicialmente

                                Swal.fire({
                                    title: 'Atenção',
                                    text: "Deseja excluir esta procuração?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sim, excluir!',
                                    cancelButtonText: 'Cancelar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('deleteProcAssinadoForm')
                                            .submit(); // Envia o formulário se o usuário confirmar
                                    }
                                });
                            });
                        </script>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end shadow-none border rounded -->
        </div> <!-- end col-12 -->
    </div> <!-- end row -->
@else
    <div class="row">
        <div class="col-12">
            <p class="text-muted mb-2 mt-2 font-13"><strong>Procuração assinada</strong></p>
            <div class="alert alert-danger bg-transparent text-danger" role="alert">
                NENHUM DOCUMENTO ENCONTRADO!
            </div>
        </div>
    </div>
    @endif

@if (!empty($veiculo->arquivo_atpve_assinado))
    <div class="row mb-2">
        <div class="col-12">
            <div class="shadow-none border rounded p-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-reset rounded">
                                <i class="mdi mdi-file-pdf-box text-danger font-36"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col ps-0" style="text-align: left;">
                        <a href="{{ $veiculo->arquivo_atpve_assinado }}" target="_blank"
                            class="text-muted fw-bold">{{ basename($veiculo->arquivo_atpve_assinado) }}</a>
                        <p class="mb-0 font-13">
                            {{ number_format($veiculo->size_atpve_pdf / 1024, 2, ',', '.') }} KB</p>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('veiculos.excluir_atpve_assinado', $veiculo->id) }}"
                            method="POST" id="deleteAtpveAssinadoForm">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="text-secondary font-20"
                                id="deleteAtpveAssinadoIcon">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </a>
                        </form>
                        <script>
                            document.getElementById('deleteAtpveAssinadoIcon').addEventListener('click', function(event) {
                                event.preventDefault(); // Impede o envio do formulário inicialmente

                                Swal.fire({
                                    title: 'Atenção',
                                    text: "Deseja excluir esta ATPVe?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sim, excluir!',
                                    cancelButtonText: 'Cancelar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('deleteAtpveAssinadoForm')
                                            .submit(); // Envia o formulário se o usuário confirmar
                                    }
                                });
                            });
                        </script>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end shadow-none border rounded -->
        </div> <!-- end col-12 -->
    </div> <!-- end row -->
    @else
    <div class="row">
        <div class="col-12">
            <p class="text-muted mb-2 mt-2 font-13"><strong>Solicitação ATPVe assinada</strong></p>
            <div class="alert alert-danger bg-transparent text-danger" role="alert">
                NENHUM DOCUMENTO ENCONTRADO!
            </div>
        </div>
    </div>
    @endif
