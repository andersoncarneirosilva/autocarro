@extends('layouts.app')

@section('title', 'Proconline')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Ajuda</li>
                </ol>
            </div>
            <div class="d-flex align-items-center">
                <h3 class="page-title mb-0">Ajuda</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title mt-2">Dicas de como utilizar o sistema</h5>
        <div class="row">
            <div class="accordion custom-accordion" id="custom-accordion-one">
                <div class="card mb-0">
                    <div class="card-header" id="headingFour">
                        <h5 class="m-0">
                            <a class="custom-accordion-title d-block"
                                data-bs-toggle="collapse" href="#collapseFour"
                                aria-expanded="true" aria-controls="collapseFour">
                                Como cadastrar um veículo?
                            </a>
                        </h5>
                    </div>
                        
                    <div id="collapseFour" class="collapse show"
                        aria-labelledby="headingFour"
                        data-bs-parent="#custom-accordion-one">
                        <div class="card-body">
                            <h5>Cadastrar o veículo e baixar a procuração</h5>
                            <ul>
                                <li>Clique no botão cadastrar e selecione o cadastro automático.</li>
                                <li>Insira o endereço do outorgado e o documento em PDF.</li>
                            </ul>
                            <div class="mb-3">
                                <video controls class="w-100" style="max-width: 640px; height: auto;">
                                    <source src="https://proconline.com.br/cadastrar-veiculo.mp4" type="video/mp4">
                                    Seu navegador não suporta a tag de vídeo.
                                </video>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card mb-0">
                    <div class="card-header" id="headingFive">
                        <h5 class="m-0">
                            <a class="custom-accordion-title collapsed d-block"
                                data-bs-toggle="collapse" href="#collapseFive"
                                aria-expanded="false" aria-controls="collapseFive">
                                Como gerar uma solicitação de ATPVe?
                            </a>
                        </h5>
                    </div>
                    <div id="collapseFive" class="collapse"
                        aria-labelledby="headingFive"
                        data-bs-parent="#custom-accordion-one">
                        <div class="card-body">
                            <h5>Cadastrar o veículo e baixar a procuração</h5>
                            <ul>
                                <li>Clique no botão cadastrar e selecione o cadastro automático.</li>
                                <li>Insira o endereço do outorgado e o documento em PDF.</li>
                            </ul>
                            <div class="mb-3">
                                <video controls class="w-100" style="max-width: 640px; height: auto;">
                                    <source src="https://proconline.com.br/gerar-atpve.mp4" type="video/mp4">
                                    Seu navegador não suporta a tag de vídeo.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection