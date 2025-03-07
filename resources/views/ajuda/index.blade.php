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
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                            aria-expanded="false" aria-controls="collapseOne">
                            Como cadastrar um veículo?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h5>Cadastrar o veículo e baixar a procuração</h5>
                            <ul>
                                <li>Clique no botão cadastrar e selecione o cadastro automático.</li>
                                <li>Insira o endereço do outorgado e o documento em PDF.</li>
                            </ul>
                            <div class="mb-3">
                                <video controls class="w-100" style="max-width: 640px; height: auto;">
                                    <source src="https://proconline.com.br/images/videos/cadastrar-veiculo.mp4" type="video/mp4">
                                    Seu navegador não suporta a tag de vídeo.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Como gerar uma solicitação de ATPVe?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h5>Cadastrar o veículo e baixar a procuração</h5>
                            <ul>
                                <li>Acesse a página <strong>veículos</strong>, clique no menu <strong>Ações</strong>.</li>
                                <li>Em seguida clique em <strong>Gerar solicitação ATPVe</strong>.</li>
                                <li>Selecione o <strong>Outorgado</strong>, <strong>cliente</strong> e preencha o valor da venda.</li>
                            </ul>
                            <div class="mb-3">
                                <video controls class="w-100" style="max-width: 640px; height: auto;">
                                    <source src="https://proconline.com.br/images/videos/gerar-atpve.mp4" type="video/mp4">
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