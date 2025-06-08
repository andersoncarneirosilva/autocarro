@extends('layouts.app')

@section('title', 'Proconline')

@section('content')

<div class="row justify-content-center">
    <div class="col-xxl-10">
        <div class="text-center">
            <h3 class="mb-2">Plano mensal</h3>
            <p class="text-muted w-50 m-auto">
                O plano ideal que se encaixa perfeitamente no seu negócio.
            </p>
        </div>

        <!-- Plans -->
        <div class="row mt-sm-5 mt-3 mb-3">
            <!-- Plano Básico -->
            <div class="col-md-4">
                <div class="card card-pricing">
                    {{-- <div class="card-body text-center">
                        <p class="card-pricing-plan-name fw-bold text-uppercase">Padrão</p>
                        <i class="card-pricing-icon ri-user-line text-primary"></i>
                        <h2 class="card-pricing-price">R$150 <span>/ mês</span></h2>
                        <ul class="card-pricing-features">
                            <li>Gerar procuração</li>
                            <li>10 documentos</li>
                        </ul>
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plano" value="Padrão">
                            <input type="hidden" name="preco" value="150">
                            <button type="submit" class="btn btn-primary mt-4 mb-2 rounded-pill">Escolher plano</button>
                        </form>
                    </div> --}}
                </div>
            </div>
        
            <!-- Plano Intermediário -->
            <div class="col-md-4">
                <div class="card card-pricing card-pricing-recommended">
                    <div class="card-body text-center">
                        <p class="card-pricing-plan-name fw-bold text-uppercase">Intermediário</p>
                        <i class="card-pricing-icon ri-briefcase-line text-success"></i>
                        <h2 class="card-pricing-price">R$50 <span>/ mês</span></h2>
                        <ul class="card-pricing-features">
                            <li>Gerar procuração</li>
                            <li>Gerar solicitação ATPVe</li>
                            <li>1 GB de armazenamento</li>
                            <li>Suporte dedicado</li>
                        </ul>
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plano" value="Intermediário">
                            <input type="hidden" name="preco" value="50">
                            <button type="submit" class="btn btn-success mt-4 mb-2 rounded-pill">Escolher plano</button>
                        </form>
                    </div>
                </div>
            </div>
        
            <!-- Plano Avançado -->
            <div class="col-md-4">
                <div class="card card-pricing">
                    {{-- <div class="card-body text-center">
                        <p class="card-pricing-plan-name fw-bold text-uppercase">Avançado</p>
                        <i class="card-pricing-icon ri-shield-star-line text-danger"></i>
                        <h2 class="card-pricing-price">R$400 <span>/ mês</span></h2>
                        <ul class="card-pricing-features">
                            <li>Gerar procuração</li>
                            <li>Gerar solicitação ATPVe</li>
                            <li>Documentos ilimitados</li>
                            <li>5 GB de armazenamento</li>
                            <li>Suporte dedicado</li>
                        </ul>
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plano" value="Avançado">
                            <input type="hidden" name="preco" value="0.30">
                            <button type="submit" class="btn btn-danger mt-4 mb-2 rounded-pill">Escolher plano</button>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
        

        </div>

    </div>

@endsection