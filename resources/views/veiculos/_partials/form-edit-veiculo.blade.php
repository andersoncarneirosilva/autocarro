<div class="row">
    <div class="col-sm-12">
        <!-- Profile -->
        <div class="card bg-primary">
            <div class="card-body profile-user-box">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar-lg">
                                        <img src="{{ url("$veiculo->image") }}" alt="" class="rounded-circle img-thumbnail">
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <h4 class="mt-1 mb-1 text-white">Marca</h4>
                                    <p class="font-13 text-white-50">{{ $veiculo->marca }}</p>

                                    <ul class="mb-0 list-inline text-light">
                                        <li class="list-inline-item me-3">
                                            <h5 class="mb-1 text-white">Cor</h5>
                                            <p class="mb-0 font-13 text-white-50">{{ $veiculo->cor }}</p>
                                        </li>
                                        <li class="list-inline-item">
                                            <h5 class="mb-1 text-white">Ano</h5>
                                            <p class="mb-0 font-13 text-white-50">{{ $veiculo->ano }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-sm-4">
                        <div class="text-center mt-sm-0 mt-3 text-sm-end">
                            {{-- <button type="button" class="btn btn-light">
                                <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                            </button> --}}
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row -->

            </div> <!-- end card-body/ profile-user-box-->
        </div><!--end profile/ card -->
    </div> <!-- end col-->
</div>

<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                {{-- @if($veiculo->image)
                <img src="/storage/{{ $veiculo->image }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                @else
                    <img src="{{ url('assets/img/icon_user.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="user-image">
                @endif--}}

                {{-- <h4 class="mb-0 mt-2">{{ $veiculo->marca }}</h4> --}}

                <div class="text-start mt-3">
                    <p class="text-muted mb-2 font-13"><strong>Informações do veículo</strong></p>
                    <hr>
                    <p class="text-muted mb-2 font-13"><strong>Placa:</strong><span class="ms-2">{{ $veiculo->placa }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Cor:</strong><span class="ms-2 ">{{ $veiculo->cor }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Ano/Modelo:</strong><span class="ms-2">{{ $veiculo->ano }}</span></p>

                    {{-- <p class="text-muted mb-2 font-13"><strong>Chassi:</strong><span class="ms-2">{{ $veiculo->chassi }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Renavam:</strong><span class="ms-2">{{ $veiculo->renavam }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Cidade:</strong><span class="ms-2">{{ $veiculo->cidade }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>CRV:</strong><span class="ms-2">{{ $veiculo->crv }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Categoria:</strong><span class="ms-2">{{ $veiculo->categoria }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Motor:</strong><span class="ms-2">{{ $veiculo->motor }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Combustível:</strong><span class="ms-2">{{ $veiculo->combustivel }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Observações:</strong><span class="ms-2">{{ $veiculo->infos }}</span></p> --}}
                </div>
            </div> 
        </div> 
    </div>
    
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#aboutme" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active" aria-selected="false" tabindex="-1" role="tab">
                            Envio
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#timeline" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0" aria-selected="true" role="tab">
                            Arquivos
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="aboutme" role="tabpanel">
                        <form>
                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-file me-1"></i> Enviar documentos</h5>
                            <div class="row">
                                @if ($veiculo->arquivo_doc === "0")
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">CRLV</label>
                                        <input class="form-control" type="file" name="arquivo_doc">
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Procuração assinada</label>
                                        <input class="form-control" type="file" name="arquivo_proc_assinado">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">ATPVe assinada</label>
                                        <input class="form-control" type="file" name="arquivo_atpve_assinado">
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            @if ($veiculo->crv === "***")
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">CRV:</label>
                                        <input class="form-control" type="text" name="crv" value="{{ $veiculo->crv ?? old('crv') }}">
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="text-end">
                                <a href="{{ route('veiculos.index')}}" class="btn btn-secondary btn-sm">Voltar</a>
                                <button type="submit" class="btn btn-success btn-sm">Enviar</button>
                            </div>
                        </form>
                    </div> <!-- end tab-pane -->
                    <!-- end about me section content -->

                    <div class="tab-pane" id="timeline" role="tabpanel">
                        <div class="mt-3">
                            <h5 class="mb-3 text-uppercase"><i class="mdi mdi-file-document-outline me-1"></i> Documentos gerados</h5>
                            <div class="row mx-n1 g-0">

                                @if (!empty($veiculo->arquivo_doc))
                                    <div class="col-xxl-3 col-lg-6">
                                        <p class="text-muted mb-2 font-13"><strong>CRLV</strong></p>
                                        <div class="card m-1 shadow-none border">
                                            <div class="p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title bg-light text-reset rounded">
                                                                <i class="mdi mdi-file-pdf-box font-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <a href="{{ $veiculo->arquivo_doc }}" target="_blank" class="text-muted fw-bold">CRLV</a>
                                                        <p class="mb-0 font-13">{{ number_format($veiculo->size_doc / 1024, 2, ',', '.') }} KB</p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <form action="{{ route('veiculos.excluir_doc', $veiculo->id) }}" method="POST" id="deleteForm">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="text-secondary" id="deleteIcon">
                                                                <i class="mdi mdi-trash-can-outline"></i>
                                                            </a>
                                                        </form>
                                                        <script>
                                                            document.getElementById('deleteIcon').addEventListener('click', function(event) {
                                                                event.preventDefault(); // Impede o envio do formulário inicialmente
                                                        
                                                                Swal.fire({
                                                                    title: 'Deseja excluir este documento?',
                                                                    text: "Essa ação não pode ser desfeita!",
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Sim, excluir!',
                                                                    cancelButtonText: 'Cancelar',
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        document.getElementById('deleteForm').submit(); // Envia o formulário se o usuário confirmar
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div> <!-- end row -->
                                            </div> <!-- end .p-2-->
                                        </div> <!-- end col -->
                                    </div> <!-- end col-->
                                
                                @endif

                                @if (!empty($veiculo->arquivo_proc))
                                    <div class="col-xxl-3 col-lg-6">
                                        <p class="text-muted mb-2 font-13"><strong>Procuração</strong></p>
                                        <div class="card m-1 shadow-none border">
                                            <div class="p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title bg-light text-reset rounded">
                                                                <i class="mdi mdi-file-pdf-box font-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <a href="{{ $veiculo->arquivo_proc }}" target="_blank" class="text-muted fw-bold">Procuração</a>
                                                        <p class="mb-0 font-13">{{ number_format($veiculo->size_proc / 1024, 2, ',', '.') }} KB</p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <form action="{{ route('veiculos.excluir_proc', $veiculo->id) }}" method="POST" id="deleteProcForm">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="text-secondary" id="deleteProcIcon">
                                                                <i class="mdi mdi-trash-can-outline"></i>
                                                            </a>
                                                        </form>
                                                        <script>
                                                            document.getElementById('deleteProcIcon').addEventListener('click', function(event) {
                                                                event.preventDefault(); // Impede o envio do formulário inicialmente
                                                        
                                                                Swal.fire({
                                                                    title: 'Deseja excluir esta procuração?',
                                                                    text: "Essa ação não pode ser desfeita!",
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Sim, excluir!',
                                                                    cancelButtonText: 'Cancelar',
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        document.getElementById('deleteProcForm').submit(); // Envia o formulário se o usuário confirmar
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div> <!-- end row -->
                                            </div> <!-- end .p-2-->
                                        </div> <!-- end col -->
                                    </div> <!-- end col-->
                                
                                @endif

                                @if (!empty($veiculo->arquivo_atpve))
                                    <div class="col-xxl-3 col-lg-6">
                                        <p class="text-muted mb-2 font-13"><strong>ATPVe</strong></p>
                                        <div class="card m-1 shadow-none border">
                                            <div class="p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title bg-light text-reset rounded">
                                                                <i class="mdi mdi-file-pdf-box font-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <a href="{{ $veiculo->arquivo_atpve }}" target="_blank" class="text-muted fw-bold">ATPVe</a>
                                                        <p class="mb-0 font-13">{{ number_format($veiculo->size_atpve / 1024, 2, ',', '.') }} KB</p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <form action="{{ route('veiculos.excluir_atpve', $veiculo->id) }}" method="POST" id="deleteAtpveForm">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="text-secondary" id="deleteAtpveIcon">
                                                                <i class="mdi mdi-trash-can-outline"></i>
                                                            </a>
                                                        </form>
                                                        <script>
                                                            document.getElementById('deleteAtpveIcon').addEventListener('click', function(event) {
                                                                event.preventDefault(); // Impede o envio do formulário inicialmente
                                                        
                                                                Swal.fire({
                                                                    title: 'Deseja excluir esta atpve?',
                                                                    text: "Essa ação não pode ser desfeita!",
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Sim, excluir!',
                                                                    cancelButtonText: 'Cancelar',
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        document.getElementById('deleteAtpveForm').submit(); // Envia o formulário se o usuário confirmar
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div> <!-- end row -->
                                            </div> <!-- end .p-2-->
                                        </div> <!-- end col -->
                                    </div> <!-- end col-->
                                
                                @endif
                            </div> <!-- end row-->
                        </div>
                        <hr>
                        <div class="mt-3">
                            <h5 class="mb-3 text-uppercase"><i class="mdi mdi-file-sign me-1"></i> Documentos assinados</h5>
                            <div class="row mx-n1 g-0">

                                @if (!empty($veiculo->arquivo_proc_assinado))
                                <div class="col-xxl-3 col-lg-6">
                                    <p class="text-muted mb-2 font-13"><strong>Procuração</strong></p>
                                    <div class="card m-1 shadow-none border">
                                        <div class="p-2">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-light text-reset rounded">
                                                            <i class="mdi mdi-file-pdf-box font-24"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col ps-0">
                                                    <a href="{{ $veiculo->arquivo_proc_assinado }}" target="_blank" class="text-muted fw-bold">Procuração</a>
                                                    <p class="mb-0 font-13">{{ number_format($veiculo->size_proc_pdf / 1024, 2, ',', '.') }} KB</p>
                                                </div>
                                            </div> <!-- end row -->
                                        </div> <!-- end .p-2-->
                                    </div> <!-- end col -->
                                </div> <!-- end col-->
                                @elseif (!empty($veiculo->arquivo_atpve_assinado))
                                <div class="col-xxl-3 col-lg-6">
                                    <p class="text-muted mb-2 font-13"><strong>ATPVe</strong></p>
                                    <div class="card m-1 shadow-none border">
                                        <div class="p-2">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-light text-reset rounded">
                                                            <i class="mdi mdi-file-pdf-box font-24"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col ps-0">
                                                    <a href="{{ $veiculo->arquivo_atpve_assinado }}" target="_blank" class="text-muted fw-bold">ATPVe</a>
                                                    <p class="mb-0 font-13">{{ number_format($veiculo->size_atpve_pdf / 1024, 2, ',', '.') }} KB</p>
                                                </div>
                                            </div> <!-- end row -->
                                        </div> <!-- end .p-2-->
                                    </div> <!-- end col -->
                                </div> <!-- end col-->
                                @else
                                <div class="alert alert-danger bg-transparent text-danger" role="alert">
                                    NENHUM RESULTADO ENCONTRADO!
                                </div>
                                @endif
                            </div> <!-- end row-->
                        </div>
                    </div>
                </div> <!-- end tab-content -->
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div>

    
</div>