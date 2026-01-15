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
            <div class="card shadow-sm overflow-hidden">

    {{-- Imagem do veículo no topo --}}
    @php
        $imagens = json_decode($veiculo->images ?? '[]', true);
        $primeiraImagem = $imagens[0] ?? null;
    @endphp

    @if($primeiraImagem)
        <img src="{{ asset("storage/{$primeiraImagem}") }}"
            class="w-100"
            style="height: 260px; object-fit: cover; object-position: center; border-bottom: 1px solid #dee2e6;">
    @else
        <img src="{{ asset('assets/img/icon_user.png') }}"
            class="w-100"
            style="height: 260px; object-fit: cover; object-position: center; background: #f8f9fa;">
    @endif

    {{-- Conteúdo do card --}}
    <div class="card-body">
        {{-- Coloque aqui o conteúdo do card --}}
        <h5 class="text-primary text-center mb-3">Resumo do Veículo</h5>
        {{-- ... restante do conteúdo ... --}}
    </div>
</div>


    <div class="card shadow-sm">
        <div class="card-body">

            

            {{-- Título --}}
            <h5 class="text-primary text-center mb-3">
                <i class="mdi mdi-car-side me-1"></i>Resumo do Veículo
            </h5>

            {{-- Informações rápidas --}}
            <div class="text-start small">
                <p class="mb-2">
                    <strong class="text-muted">Placa:</strong>
                    <span class=" ms-1">{{ $veiculo->placa }}</span>
                </p>

                <p class="mb-2">
                    <strong class="text-muted">Ano/Modelo:</strong>
                    <span class=" ms-1">{{ $veiculo->ano }}</span>
                </p>

                <p class="mb-2">
                    <strong class="text-muted">Kilometragem:</strong>
                    <span class=" ms-1">{{ $veiculo->kilometragem }}</span>
                </p>

                <p class="mb-2">
                    <strong class="text-muted">Câmbio:</strong>
                    <span class=" ms-1">{{ $veiculo->cambio }}</span>
                </p>

                <p class="mb-0">
                    <strong class="text-muted">Valor:</strong>
                    <span class="fw-bold text-danger ms-1">R$ {{ number_format(floatval(preg_replace('/[^\d,.-]/', '', str_replace(',', '.', $veiculo->valor))), 2, ',', '.') }}
</span>
                </p>
            </div>

            <hr class="my-3">

            {{-- Botões de ação --}}
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-info">
                    <i class="mdi mdi-pencil-outline me-1"></i> Editar
                </button>
                <button type="button" class="btn btn-sm btn-outline-primary">
                    <i class="mdi mdi-archive-outline me-1"></i> Arquivar
                </button>
                <button type="button" class="btn btn-sm btn-outline-success">
                    <i class="mdi mdi-cash-multiple me-1"></i> Vender
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger">
                    <i class="mdi mdi-delete-outline me-1"></i> Excluir
                </button>
            </div>
        </div>
    </div>
</div>


                        <div class="col-xl-8 col-lg-7">
                            
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a href="#aboutme" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active" aria-selected="true" role="tab">
                                                Informações gerais
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="#timeline" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0" aria-selected="false" role="tab" tabindex="-1">
                                                Documentação
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0" aria-selected="false" role="tab" tabindex="-1">
                                                Fotos
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="aboutme" role="tabpanel">

                                            @include('veiculos._partials.info-veiculo')

                                        </div> <!-- end tab-pane -->
                                        <!-- end about me section content -->

                                        <div class="tab-pane" id="timeline" role="tabpanel">

                                                @include('veiculos._partials.docs-veiculo')

                                            <!-- Story Box-->
                                            <div class="border border-light rounded p-2 mb-3">
                                                
                                            </div>

                                            

                                        </div>
                                        <!-- end timeline content-->
                                        
                                        <div class="tab-pane" id="settings" role="tabpanel">
                                            @php
                                                $fotos = json_decode($veiculo->images ?? '[]', true);
                                            @endphp

                                            <div class="container py-4">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <h4 class="mb-0">Galeria de Fotos</h4>
                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarFoto">
                                                        <i class="bi bi-plus-circle me-1"></i> Adicionar Fotos
                                                    </button>
                                                </div>

                                                <div class="row g-3">
                                                    @foreach($fotos as $index => $foto)
                                                        <div class="col-6 col-md-4 col-lg-3 position-relative">
                                                            <div class="card shadow-sm border-0">
                                                                <div class="position-relative">
                                                                    <img src="{{ asset('storage/' . $foto) }}" class="card-img-top img-fluid rounded" alt="Foto">
                                                                    
                                                                    <!-- Botão de Remover -->
                                                                    <form action="{{ route('veiculos.removerFoto', $veiculo->id) }}" method="POST"
                                                class="form-remover-foto position-absolute top-0 end-0 m-1">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="foto" value="{{ $foto }}">
                                                <button type="button"
                                                        class="btn btn-sm btn-danger rounded-circle btn-confirm-delete"
                                                        style="width: 28px; height: 28px; line-height: 1; padding: 0;"
                                                        title="Remover Foto">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>


                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>



                                        </div>
                                        <!-- end settings content-->

                                    </div> <!-- end tab-content -->
                                </div> <!-- end card body -->
                            </div> <!-- end card -->
                        </div> <!-- end col -->
                    </div>

        


@include('veiculos._partials.modals')


<script>
            function openAddressModal(event, docId) {
                // Armazena o ID do documento globalmente
                window.selectedDocId = docId;

                // Atualiza o campo oculto no formulário com o ID do documento
                document.getElementById('docId').value = docId;

                // Exibe o modal
                $('#addressModal').modal('show');
            }

            function openProcModal(event, docId) {
                // Armazena o ID do documento globalmente
                window.selectedDocId = docId;

                // Atualiza o campo oculto no formulário com o ID do documento
                document.getElementById('docId').value = docId;

                // Exibe o modal
                $('#procModal').modal('show');
            }

            function openCrlvModal(event, docId) {
                // Armazena o ID do documento globalmente
                window.selectedDocId = docId;

                // Atualiza o campo oculto no formulário com o ID do documento
                document.getElementById('docId').value = docId;

                // Exibe o modal
                $('#crlvModal').modal('show');
            }

            function submitProc() {

                const docId = window.selectedDocId;
                //console.log(docId);
                // Atualiza a ação do formulário para incluir o ID do documento na rota
                const form = document.getElementById('procForm');
                form.action = `{{ url('veiculos/store-proc') }}/${docId}`; //secure_url

                // Envia o formulário
                form.submit();
            }

            function submitCrlv() {

                const docId = window.selectedDocId;
                //console.log(docId);
                // Atualiza a ação do formulário para incluir o ID do documento na rota
                const form = document.getElementById('docForm');
                form.action = `{{ url('veiculos/store-crlv') }}/${docId}`; //secure_url

                // Envia o formulário
                form.submit();
            }

            function submitAddress() {
                

                const docId = window.selectedDocId;

                // Atualiza a ação do formulário para incluir o ID do documento na rota
                const form = document.getElementById('addressForm');
                form.action = `{{ app()->isLocal() ? url('veiculos/store-atpve') : secure_url('veiculos/store-atpve') }}/${docId}`;


                // Envia o formulário
                form.submit();
            }
        </script>

        <script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-confirm-delete').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Tem certeza?',
                text: 'Esta foto será removida permanentemente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, remover',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
