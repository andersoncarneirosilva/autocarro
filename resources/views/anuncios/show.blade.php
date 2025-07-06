@extends('layouts.app')

@section('title', 'Detalhes do veículo')

@section('content')

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('veiculos.index') }}">Veículos</a></li>
                        <li class="breadcrumb-item active">Detalhes</li>
                    </ol>
                </div>
                <h3 class="page-title">Detalhes do veículo</h3>
            </div>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-xl-4 col-lg-5">

        
        <div class="card text-center">
            <div class="card-body" style="background-color: rgb(38, 39, 51)" >
                <div class="row">
                    <div class="col-12">
  <div class="mt-3 p-2 rounded position-relative">
    @if($veiculo->images)
      <!-- Botão esquerda -->
      <button class="btn btn-sm btn-light position-absolute start-0 top-50 translate-middle-y z-3"
              onclick="scrollCarousel(-1)">
        <i class="fas fa-chevron-left"></i>
      </button>

      <!-- Botão direita -->
      <button class="btn btn-sm  btn-light position-absolute end-0 top-50 translate-middle-y z-3"
              onclick="scrollCarousel(1)">
        <i class="fas fa-chevron-right"></i>
      </button>

      <!-- Container das imagens -->
      <div id="imageCarousel" class="d-flex" style="overflow-x: auto; overflow-y: hidden; scroll-behavior: smooth; scrollbar-width: none;">

        @foreach(json_decode($veiculo->images) as $image)
          <div class="flex-shrink-0 me-1">
            <img src="{{ url("storage/{$image}") }}" class="img-thumbnail rounded" style="height: 120px; width: auto;" />
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center">
        <img src="{{ url('assets/img/icon_user.png') }}" class="rounded-circle avatar-img" />
      </div>
    @endif
  </div>
</div>

<script>
  function scrollCarousel(direction) {
    const container = document.getElementById('imageCarousel');
    const scrollAmount = 150; // pixels por clique
    container.scrollLeft += direction * scrollAmount;
  }
</script>


                    <h4 class="mb-0 mt-2 text-white">
                        {{ $veiculo->marca }}
                    </h4>
                    
                    <p class="font-14 text-white">{{ $veiculo->modelo }}</p>
                </div>
            </div>
        </div>
        

            <div class="card text-center">
                <div class="card-body">
                    <div class="row mt-3">
                        <!-- Título de Informações do Veículo -->
                        <div class="col-12">
                            <h5 class="text-start"><i class="mdi mdi-car me-1"></i> Informações do Veículo</h5>
                            <hr>
                        </div>

                        <!-- Coluna 1: Marca e Placa -->
                        <div class="col-md-6 text-start">
                            <p class="text-muted mb-2 font-13"><strong>Marca: </strong> <span>{{ $veiculo->marca }}</span>
                            </p>
                            <p class="text-muted mb-2 font-13"><strong>Placa: </strong> <span>{{ substr($veiculo->placa, 0, 3) . '-' . substr($veiculo->placa, 3) }}</span>
                            </p>
                        </div>

                        <!-- Coluna 2: Ano/Modelo e Cor -->
                        <div class="col-md-6 text-start">
                            <p class="text-muted mb-2 font-13"><strong>Ano/Modelo: </strong>
                                <span>{{ $veiculo->ano }}</span></p>
                            <p class="text-muted mb-1 font-13"><strong>Cor: </strong> <span>{{ $veiculo->cor }}</span></p>
                        </div>
                    </div>

                    <hr>

                    <!-- Botão Detalhes -->
                    <button type="button" class="btn btn-sm btn-success mb-2" data-bs-toggle="modal"
                        data-bs-target="#veiculoModal">
                        <i class="mdi mdi-file-outline me-1"></i> Detalhes
                    </button>
                </div> <!-- end card-body -->
            </div> <!-- end card -->

            <div class="card">
                <div class="card-body">

                    <p class="text-muted mb-2 font-13"><strong>DOCUMENTOS GERADOS</strong></p>
                    @if (!empty($veiculo->arquivo_doc))
                        <div class="row mb-2" style="text-align: left;">
                            <div class="col-12">
                                <div class="shadow-none border rounded p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-reset rounded">
                                                    <i class="mdi mdi-file-pdf-box font-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0" style="text-align: left;">
                                            <a href="{{ $veiculo->arquivo_doc }}" target="_blank"
                                                class="text-muted fw-bold">CRLV</a>
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
                                    </div> <!-- end row -->
                                </div> <!-- end shadow-none border rounded -->
                            </div> <!-- end col-12 -->
                        </div> <!-- end row -->
                    @endif

                    @if (!empty($veiculo->arquivo_proc))
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="shadow-none border rounded p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-reset rounded">
                                                    <i class="mdi mdi-file-pdf-box font-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0" style="text-align: left;">
                                            <a href="{{ $veiculo->arquivo_proc }}" target="_blank"
                                                class="text-muted fw-bold">Procuração</a>
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

                    @if (!empty($veiculo->arquivo_atpve))
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="shadow-none border rounded p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-reset rounded">
                                                    <i class="mdi mdi-file-pdf-box font-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0" style="text-align: left;">
                                            <a href="{{ $veiculo->arquivo_atpve }}" target="_blank"
                                                class="text-muted fw-bold">ATPVe</a>
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
                    <p class="text-muted mb-2 mt-2 font-13"><strong>DOCUMENTOS ASSINADOS</strong></p>
                    @if (!empty($veiculo->arquivo_proc_assinado))
                        <div class="row mb-2" style="text-align: left;">
                            <div class="col-12">
                                <div class="shadow-none border rounded p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-reset rounded">
                                                    <i class="mdi mdi-file-pdf-box font-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0" style="text-align: left;">
                                            <a href="{{ $veiculo->arquivo_proc_assinado }}" target="_blank"
                                                class="text-muted fw-bold">Procuração Assinada</a>
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
                    @endif

                    @if (!empty($veiculo->arquivo_atpve_assinado))
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="shadow-none border rounded p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-reset rounded">
                                                    <i class="mdi mdi-file-pdf-box font-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0" style="text-align: left;">
                                            <a href="{{ $veiculo->arquivo_atpve_assinado }}" target="_blank"
                                                class="text-muted fw-bold">ATPVe Assinada</a>
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
                    @endif

                    <div class="row">
                        <div class="col-12">
                            @if (empty($veiculo->arquivo_atpve_assinado || $veiculo->arquivo_proc_assinado))
                                <div class="alert alert-danger bg-transparent text-danger" role="alert">
                                    NENHUM RESULTADO ENCONTRADO!
                                </div>
                            @endif
                        </div>
                    </div>
                </div> <!-- end card-body -->
            </div>
        </div>
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-file me-1"></i> Enviar documentos</h5>
                        <div class="row">
                            @if ($veiculo->arquivo_doc === '0')
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">CRLV</label>
                                        <input class="form-control" type="file" name="arquivo_doc">
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Procuração assinada</label>
                                    <input class="form-control" type="file" name="arquivo_proc_assinado">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">ATPVe assinada</label>
                                    <input class="form-control" type="file" name="arquivo_atpve_assinado">
                                </div>
                            </div>
                        </div> <!-- end row -->
                        @if ($veiculo->crv === '***')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">CRV:</label>
                                        <input class="form-control" type="text" name="crv"
                                            value="{{ $veiculo->crv ?? old('crv') }}">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="text-end">
                            <a href="{{ route('veiculos.index') }}" class="btn btn-secondary btn-sm">Voltar</a>
                            <button type="submit" class="btn btn-success btn-sm">Enviar</button>
                        </div>
                    </form>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>

    {{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
    {{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
    {{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

    <!-- Modal -->
    <div class="modal fade" id="veiculoModal" tabindex="-1" aria-labelledby="veiculoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="veiculoModalLabel">Detalhes do Veículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="modalContent">

                    <!-- Imagem do Veículo -->
                    <div class="text-center mb-3">
                        <img src="{{ url($veiculo->images) }}" alt="Imagem do Veículo" class="img-fluid rounded"
                            style="max-width: 100%; max-height: 300px;">
                    </div>

                    <!-- Informações do Vendedor -->
                    <h5 class="text-primary"><i class="mdi mdi-account-circle me-1"></i> Informações do Vendedor</h5>
                    <div class="row">
                        <div class="col-md-6"><strong>Nome:</strong> {{ $veiculo->nome }}</div>
                        <div class="col-md-6"><strong>CPF:</strong> {{ $veiculo->cpf }}</div>
                        <div class="col-md-12"><strong>Endereço:</strong> {{ $veiculo->endereco }}</div>
                    </div>

                    <hr>

                    <!-- Informações do Veículo -->
                    <h5 class="text-primary"><i class="mdi mdi-car me-1"></i> Informações do Veículo</h5>
                    <div class="row">
                        <div class="col-md-6"><strong>Marca:</strong> {{ $veiculo->marca }}</div>
                        <div class="col-md-6"><strong>Placa:</strong> {{ substr($veiculo->placa, 0, 3) . '-' . substr($veiculo->placa, 3) }}</div>
                        <div class="col-md-6"><strong>Chassi:</strong> {{ $veiculo->chassi }}</div>
                        <div class="col-md-6"><strong>Cor:</strong> {{ $veiculo->cor }}</div>
                        <div class="col-md-6"><strong>Ano:</strong> {{ $veiculo->ano }}</div>
                        <div class="col-md-6"><strong>Renavam:</strong> {{ $veiculo->renavam }}</div>
                        <div class="col-md-6"><strong>Cidade:</strong> {{ $veiculo->cidade }}</div>
                        <div class="col-md-6"><strong>CRV:</strong> {{ $veiculo->crv }}</div>
                    </div>

                    <hr>

                    <!-- Informações Complementares -->
                    <h5 class="text-primary"><i class="mdi mdi-information me-1"></i> Informações Complementares</h5>
                    <div class="row">
                        <div class="col-md-6"><strong>Placa Anterior:</strong> {{ $veiculo->placaAnterior }}</div>
                        <div class="col-md-6"><strong>Categoria:</strong> {{ $veiculo->categoria }}</div>
                        <div class="col-md-6"><strong>Motor:</strong> {{ $veiculo->motor }}</div>
                        <div class="col-md-6"><strong>Combustível:</strong> {{ $veiculo->combustivel }}</div>
                    </div>

                    <hr>

                    <!-- Outras Informações -->
                    <div class="row">
                        <div class="col-md-12"><strong>Informações Adicionais:</strong> {{ $veiculo->infos }}</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

@endsection
