@extends('layouts.app')

@section('title', 'Outorgados')

@section('content')

@include('outorgados._partials.cadastrar-outorgado')

@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if(session('error'))
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
                    <li class="breadcrumb-item active">Outorgados</li>
                </ol>
            </div>
            <h3 class="page-title">Outorgados</h3>
        </div>
    </div>
</div>



<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Outorgados Cadastrados</h4>
                <p class="text-muted font-13 mb-0">Gerencie as informações dos outorgados do sistema.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0">
                                <i class="uil uil-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control bg-light border-0 ps-0" 
                                   placeholder="Filtrar por nome, CPF ou email...">
                        </div>
                    </div>

                    {{-- Ajustei o data-bs-target para o modal de Outorgados --}}
                    <button type="button" class="btn btn-red btn-sm rounded-pill shadow-sm px-3" 
                            data-bs-toggle="modal" data-bs-target="#modalCadastroOut">
                        <i class="uil uil-plus me-1"></i> Novo Outorgado
                    </button>
                </div>
            </div>
        </div>

        @if ($outs->total() != 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0" id="outorgadosTable">
                <thead>
                    <tr class="bg-dark">
                        <th class="py-3 text-white fw-semibold border-0">Nome</th>
                        <th class="py-3 text-white fw-semibold border-0">CPF</th>
                        <th class="py-3 text-white fw-semibold border-0">Email</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach ($outs as $out)
                    <tr class="align-middle user-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm border text-white fw-bold" 
                                     style="width: 38px; height: 38px; background-color: #730000; font-size: 16px;">
                                    {{ strtoupper(substr($out->nome_outorgado, 0, 1)) }}
                                </div>
                                <span class="fw-semibold text-dark">{{ $out->nome_outorgado }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $out->cpf_outorgado }}</td>
                        <td>
                            @php
                                $email = $out->email_outorgado;
                                $emailParts = explode('@', $email);
                                $emailMasked = (count($emailParts) == 2) 
                                    ? substr($emailParts[0], 0, 2) . '****' . '@' . $emailParts[1] 
                                    : $email;
                            @endphp
                            <span class="text-muted">{{ $emailMasked }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn-action edit" data-id="{{ $out->id }}" onclick="openEditModalOutorgado(event)">
                                    <i class="uil uil-pen"></i>
                                </button>
                                
                                <a href="{{ route('outorgados.destroy', $out->id) }}" class="btn-action delete" data-confirm-delete="true">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="alert alert-danger bg-transparent text-danger mt-3" role="alert">
                <i class="uil uil-exclamation-octagon me-2"></i> NENHUM RESULTADO ENCONTRADO!
            </div>
        @endif
    </div>

    <div class="card-footer bg-transparent border-0">
        <div class="row">
            {{ $outs->appends(['search' => request()->get('search', '')])->links('components.pagination') }}
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro no cadastro!',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#730000'
        });
    </script>
@endif



<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cpf_outorgado').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 11) value = value.slice(0, 11); // Limita ao tamanho máximo do CPF
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o primeiro ponto
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o segundo ponto
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
            e.target.value = value;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('edit_cpf_outorgado').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 11) value = value.slice(0, 11); // Limita ao tamanho máximo do CPF
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o primeiro ponto
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o segundo ponto
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
            e.target.value = value;
        });
    });
</script>

{{-- <script>
    // Função para validar CPF
    function validarCPF(cpf) {
        // Remove caracteres não numéricos
        cpf = cpf.replace(/[^\d]+/g, '');

        // Verifica se o CPF tem 11 dígitos ou é uma sequência repetida
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }

        // Função para calcular os dígitos verificadores
        function calcularDigito(base) {
            let soma = 0;
            for (let i = 0; i < base.length; i++) {
                soma += base[i] * (base.length + 1 - i);
            }
            const resto = soma % 11;
            return resto < 2 ? 0 : 11 - resto;
        }

        // Calcula o primeiro dígito verificador
        const primeiroDigito = calcularDigito(cpf.slice(0, 9));

        // Verifica o primeiro dígito
        if (primeiroDigito !== parseInt(cpf[9], 10)) {
            return false;
        }

        // Calcula o segundo dígito verificador
        const segundoDigito = calcularDigito(cpf.slice(0, 10));

        // Verifica o segundo dígito
        return segundoDigito === parseInt(cpf[10], 10);
    }

    // Adiciona evento no envio do formulário
    document.getElementById('form-cad').addEventListener('submit', function (e) {
        e.preventDefault(); // Impede o envio do formulário para verificar antes
        const cpfInput = document.getElementById('cpf_outorgado');

        if (validarCPF(cpfInput.value)) {
            // CPF válido, aqui você pode prosseguir com o envio do formulário
            //alert('CPF válido!');
             e.target.submit(); // Envia o formulário caso o CPF seja válido
        } else {
            // Exibe o SweetAlert com erro por 5 segundos
            Swal.fire({
                icon: 'error',
                title: 'CPF Inválido!',
                text: 'O CPF informado não é válido.',
                timer: 5000, // Exibe por 5 segundos
                showConfirmButton: true, // Remove o botão de confirmação
                timerProgressBar: true,
            });
        }
    });
</script> --}}

{{-- <script>
    // Função para validar CPF
    function validarCPF(cpf) {
        // Remove caracteres não numéricos
        cpf = cpf.replace(/[^\d]+/g, '');

        // Verifica se o CPF tem 11 dígitos ou é uma sequência repetida
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }

        // Função para calcular os dígitos verificadores
        function calcularDigito(base) {
            let soma = 0;
            for (let i = 0; i < base.length; i++) {
                soma += base[i] * (base.length + 1 - i);
            }
            const resto = soma % 11;
            return resto < 2 ? 0 : 11 - resto;
        }

        // Calcula o primeiro dígito verificador
        const primeiroDigito = calcularDigito(cpf.slice(0, 9));

        // Verifica o primeiro dígito
        if (primeiroDigito !== parseInt(cpf[9], 10)) {
            return false;
        }

        // Calcula o segundo dígito verificador
        const segundoDigito = calcularDigito(cpf.slice(0, 10));

        // Verifica o segundo dígito
        return segundoDigito === parseInt(cpf[10], 10);
    }

    // Adiciona evento no envio do formulário
    document.getElementById('edit-form-cad').addEventListener('submit', function (e) {
    e.preventDefault(); // Impede o envio do formulário para verificar antes
    const cpfInput = document.getElementById('edit_cpf_outorgado');

    if (validarCPF(cpfInput.value)) {
        // CPF válido, aqui você pode prosseguir com o envio do formulário
        e.target.submit(); // Envia o formulário caso o CPF seja válido
    } else {
        // Exibe o SweetAlert com erro por 5 segundos
        Swal.fire({
            icon: 'error',
            title: 'CPF Inválido!',
            text: 'O CPF informado não é válido.',
            timer: 5000, // Exibe por 5 segundos
            showConfirmButton: true, // Remove o botão de confirmação
            timerProgressBar: true,
        });
    }
});

</script> --}}

    @endsection
