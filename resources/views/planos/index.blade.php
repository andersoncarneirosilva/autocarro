@extends('layouts.app')

@section('title', 'Planos de Assinatura - Alcecar')

@section('content')

<div class="row justify-content-center">
    <div class="col-xxl-10">
        <div class="text-center mb-4">
            <h3 class="mb-2">Escolha o plano ideal para sua revenda</h3>
            <p class="text-muted w-50 m-auto">
                Gestão profissional de estoque, multas e documentos com a tecnologia Alcecar.
            </p>
        </div>

        <div class="row mt-sm-5 mt-3 mb-3 justify-content-center">
            
            <div class="col-md-4">
                <div class="card card-pricing shadow-sm border-0">
                    <div class="card-body text-center">
                        <p class="card-pricing-plan-name fw-bold text-uppercase text-primary">Plano Start</p>
                        <i class="card-pricing-icon lni lni-user text-primary" style="font-size: 48px;"></i>
                        <h2 class="card-pricing-price">R$ 19,90 <span>/ mês</span></h2>
                        <ul class="card-pricing-features text-start ps-4">
                            <li><i class="mdi mdi-check text-success"></i> 1 Usuário (Adm)</li>
                            <li><i class="mdi mdi-check text-success"></i> Gestão de Veículos</li>
                            <li><i class="mdi mdi-check text-success"></i> Emissão de Procurações</li>
                            <li class="text-muted text-decoration-line-through"><i class="mdi mdi-close text-danger"></i> Solicitações ATPVe</li>
                            <li><i class="mdi mdi-check text-success"></i> Suporte Técnico</li>
                        </ul>
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plano" value="Start">
                            <input type="hidden" name="preco" value="1">
                            <button type="submit" class="btn btn-primary mt-4 mb-2 rounded-pill w-100">Escolher Start</button>
                        </form>
                    </div>
                </div>
            </div>
        
            <div class="col-md-4">
                <div class="card card-pricing card-pricing-recommended border-primary shadow-lg" style="transform: scale(1.05);">
                    <div class="card-body text-center">
                        <div class="badge bg-primary rounded-pill px-3 py-1 mb-2 text-white">MAIS POPULAR</div>
                        <p class="card-pricing-plan-name fw-bold text-uppercase text-primary">Plano Standard</p>
                        <i class="card-pricing-icon lni lni-layers text-primary" style="font-size: 48px;"></i>
                        <h2 class="card-pricing-price text-primary">R$ 39,90 <span>/ mês</span></h2>
                        <ul class="card-pricing-features text-start ps-4">
                            <li><i class="mdi mdi-check text-success"></i> <strong>Até 2 Vendedores</strong></li>
                            <li><i class="mdi mdi-check text-success"></i> Gestão de Veículos</li>
                            <li><i class="mdi mdi-check text-success"></i> Emissão de Procurações</li>
                            <li><i class="mdi mdi-check text-success"></i> Emissão de ATPVe</li>
                            <li><i class="mdi mdi-check text-success"></i> Suporte via WhatsApp</li>
                        </ul>
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plano" value="Standard">
                            <input type="hidden" name="preco" value="2">
                            <button type="submit" class="btn btn-primary mt-4 mb-2 rounded-pill w-100">Escolher Standard</button>
                        </form>
                    </div>
                </div>
            </div>
        
            <div class="col-md-4">
                <div class="card card-pricing shadow-sm border-0">
                    <div class="card-body text-center">
                        <p class="card-pricing-plan-name fw-bold text-uppercase text-dark">Plano Pro</p>
                        <i class="card-pricing-icon lni lni-crown text-warning" style="font-size: 48px;"></i>
                        <h2 class="card-pricing-price">R$ 59,90 <span>/ mês</span></h2>
                        <ul class="card-pricing-features text-start ps-4" style="font-size: 0.85rem;">
                            <li><i class="mdi mdi-check text-success"></i> <strong>Vendedores Ilimitados</strong></li>
                            <li><i class="mdi mdi-check text-success"></i> Tabela FIPE Integrada</li>
                            <li><i class="mdi mdi-check text-success"></i> Gestão de Multas</li>
                            <li><i class="mdi mdi-check text-success"></i> Procurações e ATPVe</li>
                            <li><i class="mdi mdi-check text-success"></i> <strong>Backup Diário</strong></li>
                            <li><i class="mdi mdi-check text-success"></i> Suporte Prioritário</li>
                        </ul>
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plano" value="Pro">
                            <input type="hidden" name="preco" value="3">
                            <button type="submit" class="btn btn-dark mt-4 mb-2 rounded-pill w-100">Escolher Pro</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-pricing-features {
        list-style: none;
        padding-left: 0;
        margin-top: 20px;
    }
    .card-pricing-features li {
        margin-bottom: 10px;
        font-size: 14px;
    }
    .card-pricing-recommended {
        border: 2px solid #727cf5 !important;
        z-index: 1;
    }
</style>

@endsection