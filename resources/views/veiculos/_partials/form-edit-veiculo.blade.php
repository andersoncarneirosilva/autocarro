
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
                    {{-- <p class="text-muted mb-2 font-13"><strong>Marca:</strong><span class="ms-2">{{ $veiculo->marca }}</span></p> --}}

                    <p class="text-muted mb-2 font-13"><strong>Placa:</strong><span class="ms-2">{{ $veiculo->placa }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Cor:</strong><span class="ms-2 ">{{ $veiculo->cor }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Ano/Modelo:</strong><span class="ms-2">{{ $veiculo->ano }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Chassi:</strong><span class="ms-2">{{ $veiculo->chassi }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Renavam:</strong><span class="ms-2">{{ $veiculo->renavam }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Cidade:</strong><span class="ms-2">{{ $veiculo->cidade }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>CRV:</strong><span class="ms-2">{{ $veiculo->crv }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Categoria:</strong><span class="ms-2">{{ $veiculo->categoria }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Motor:</strong><span class="ms-2">{{ $veiculo->motor }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Combustível:</strong><span class="ms-2">{{ $veiculo->combustivel }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Observações:</strong><span class="ms-2">{{ $veiculo->infos }}</span></p>
                </div>
            </div> 
        </div> 
    </div>
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                <form>
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Documentos assinados</h5>
                    <div class="row">
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">

                                @if (!empty($veiculo->arquivo_proc_assinado))
                                <div class="card mb-1 shadow-none border">
                                    <div class="p-2">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-primary-lighten text-primary rounded">
                                                        .PDF
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <a href="{{ $veiculo->arquivo_proc_assinado }}" target="_blank" class="text-muted fw-bold">{{ $veiculo->placa }}.pdf</a>
                                                <p class="mb-0">{{ $veiculo->size_proc_pdf }} MB</p>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ $veiculo->arquivo_proc_assinado }}" target="_blank" class="btn btn-link btn-lg text-muted">
                                                    <i class="ri-download-2-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                               
                                @if (!empty($veiculo->arquivo_atpve_assinado))
                                <div class="card mb-1 shadow-none border">
                                    <div class="p-2">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-primary-lighten text-primary rounded">
                                                        .PDF
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <a href="{{ $veiculo->arquivo_atpve_assinado }}" target="_blank" class="text-muted fw-bold">atpve_{{ $veiculo->placa }}.pdf</a>
                                                <p class="mb-0">{{ $veiculo->size_atpve_pdf }} MB</p>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ $veiculo->arquivo_atpve_assinado }}" target="_blank" class="btn btn-link btn-lg text-muted">
                                                    <i class="ri-download-2-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif


                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="text-end">
                        <button type="submit" class="btn btn-success mt-2">Salvar</button>
                    </div>
                </form>
            </div> <!-- end card body -->
        </div>
    </div>
    
</div>