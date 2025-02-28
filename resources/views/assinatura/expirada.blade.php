@extends('layouts.app')

@section('content')

<div class="row mt-5">
    <div class="col-sm-12">
        <div class="text-center">
            <h3 class="">Assinatura Expirada!</h3>
            <p class="text-muted mt-3">Renove sua assinatura para continuar utilizando o sistema.</p>

            <a href="{{ route('planos.index') }}" class="btn btn-sm btn-primary">
                Renovar Assinatura
            </a>
        </div>
    </div><!-- end col -->
</div>


@endsection
