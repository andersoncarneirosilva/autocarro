@extends('layouts.app')

@section('title', 'Perfil e Empresa | Alcecar')

@section('content')

@include('components.toast')

<div class="container-fluid">
    {{-- TÍTULO DA PÁGINA --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Perfil da Empresa</li>
                    </ol>
                </div>
                <h4 class="page-title">Perfil e Configurações</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
    @if($empresa->logo && Storage::disk('public')->exists($empresa->logo))
        <img src="{{ asset('storage/' . $empresa->logo) }}" 
             class="rounded-circle avatar-lg img-thumbnail shadow-sm" 
             alt="{{ $empresa->razao_social }}"
             style="width: 100px; height: 100px; object-fit: cover;">
    @else
        <div class="rounded-circle avatar-lg img-thumbnail d-flex align-items-center justify-content-center bg-primary text-white fw-bold shadow-sm" 
             style="width: 100px; height: 100px; font-size: 2.5rem; text-transform: uppercase;">
            {{ mb_substr($empresa->razao_social, 0, 1) }}
        </div>
    @endif
</div>

                    <h4 class="mb-0 mt-2">{{ $empresa->razao_social }}</h4>
                    <p class="text-muted font-14">Empresa / Salão</p>

                    <a href="{{ url('/' . $empresa->slug) }}" target="_blank" class="btn btn-success btn-sm mb-2 rounded-pill">
                        <i class="mdi mdi-eye me-1"></i>Ver Vitrine
                    </a>
                    <button type="button" 
        class="btn btn-secondary btn-sm mb-2 rounded-pill" 
        data-bs-toggle="modal" 
        data-bs-target="#shareModal">
    <i class="mdi mdi-share-variant me-1"></i>Compartilhar
</button>

                    <div class="text-start mt-3">
                        <h4 class="font-13 text-uppercase">Informações :</h4>
                        <p class="text-muted font-13 mb-3">
                            Gerencie aqui os dados públicos da sua empresa que aparecem na vitrine de agendamentos.
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Responsável :</strong> <span class="ms-2">{{ $empresa->nome_responsavel }}</span></p>

                        <p class="text-muted mb-2 font-13">
    <strong>WhatsApp:</strong>
    <span class="ms-2">
        @php
            $num = preg_replace('/\D/', '', $empresa->whatsapp); // Remove qualquer coisa que não seja número
            $len = strlen($num);
            
            if ($len == 11) {
                // Formato (99) 99999-9999
                $formatado = '(' . substr($num, 0, 2) . ') ' . substr($num, 2, 5) . '-' . substr($num, 7);
            } elseif ($len == 10) {
                // Formato (99) 9999-9999
                $formatado = '(' . substr($num, 0, 2) . ') ' . substr($num, 2, 4) . '-' . substr($num, 6);
            } else {
                $formatado = $empresa->whatsapp; // Se for estranho, exibe original
            }
        @endphp
        {{ $formatado }}
    </span>
</p>

                        <p class="text-muted mb-2 font-13"><strong>Email Corp. :</strong> <span class="ms-2 ">{{ $empresa->email_corporativo }}</span></p>

                        <p class="text-muted mb-1 font-13"><strong>Localização :</strong> <span class="ms-2">{{ $empresa->cidade ?? 'Não informada' }}/{{ $empresa->estado }}</span></p>
                    </div>

                   <ul class="social-list list-inline mt-3 mb-0">
    
    <li class="list-inline-item">
        @if(!empty($empresa->configuracoes['redes']['facebook']))
            <a href="{{ $empresa->configuracoes['redes']['facebook'] }}" target="_blank" class="social-list-item border-primary text-primary">
                <i class="mdi mdi-facebook"></i>
            </a>
        @else
            <span class="social-list-item border-light text-muted bg-light" title="Não configurado" style="cursor: not-allowed; opacity: 0.5;">
                <i class="mdi mdi-facebook"></i>
            </span>
        @endif
    </li>

    <li class="list-inline-item">
        @if(!empty($empresa->configuracoes['redes']['instagram']))
            <a href="{{ $empresa->configuracoes['redes']['instagram'] }}" target="_blank" class="social-list-item border-danger text-danger">
                <i class="mdi mdi-instagram"></i>
            </a>
        @else
            <span class="social-list-item border-light text-muted bg-light" title="Não configurado" style="cursor: not-allowed; opacity: 0.5;">
                <i class="mdi mdi-instagram"></i>
            </span>
        @endif
    </li>

    <li class="list-inline-item">
        @if(!empty($empresa->configuracoes['redes']['twitter']))
            <a href="{{ $empresa->configuracoes['redes']['twitter'] }}" target="_blank" class="social-list-item border-secondary text-secondary">
                <i class="mdi mdi-twitter"></i>
            </a>
        @else
            <span class="social-list-item border-light text-muted bg-light" title="Não configurado" style="cursor: not-allowed; opacity: 0.5;">
                <i class="mdi mdi-twitter"></i>
            </span>
        @endif
    </li>

    <li class="list-inline-item">
        @if($empresa->whatsapp)
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $empresa->whatsapp) }}" target="_blank" class="social-list-item border-success text-success">
                <i class="mdi mdi-whatsapp"></i>
            </a>
        @else
            <span class="social-list-item border-light text-muted bg-light" title="Não configurado" style="cursor: not-allowed; opacity: 0.5;">
                <i class="mdi mdi-whatsapp"></i>
            </span>
        @endif
    </li>

</ul>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#empresa-tab" data-bs-toggle="tab" aria-expanded="true" class="nav-item nav-link active rounded-0">
                                <i class="mdi mdi-office-building d-md-none d-block"></i>
                                <span class="d-none d-md-block">Dados da Empresa</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#endereco-tab" data-bs-toggle="tab" class="nav-link rounded-0">
                                <span class="d-none d-md-block">Endereço</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#usuario-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-item nav-link rounded-0">
                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                <span class="d-none d-md-block">Meu Usuário</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#galeria" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-image-multiple d-md-none d-block me-1"></i>
                                <span class="d-none d-md-block">Galeria de Fotos</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        {{-- ABA EMPRESA --}}
                        <div class="tab-pane show active" id="empresa-tab">
    <form action="{{ route('empresa.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-office-building me-1"></i> Informações do Negócio</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="razao_social" class="form-label">Razão Social / Nome Fantasia</label>
                <input type="text" class="form-control" name="razao_social" value="{{ $empresa->razao_social }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nome_responsavel" class="form-label">Nome do Responsável</label>
                <input type="text" class="form-control" name="nome_responsavel" value="{{ $empresa->nome_responsavel }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cnpj" class="form-label">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ $empresa->cnpj }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="whatsapp" class="form-label">WhatsApp Comercial</label>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ $empresa->whatsapp }}">
            </div>
        </div>

        <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-share-variant me-1"></i> Redes Sociais</h5>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Instagram</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="mdi mdi-instagram"></i></span>
                    <input type="url" class="form-control" name="configuracoes[redes][instagram]" 
                           value="{{ $empresa->configuracoes['redes']['instagram'] ?? '' }}" placeholder="https://instagram.com/perfil">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Facebook</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="mdi mdi-facebook"></i></span>
                    <input type="url" class="form-control" name="configuracoes[redes][facebook]" 
                           value="{{ $empresa->configuracoes['redes']['facebook'] ?? '' }}" placeholder="https://facebook.com/pagina">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">X (Twitter)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="mdi mdi-twitter"></i></span>
                    <input type="url" class="form-control" name="configuracoes[redes][twitter]" 
                           value="{{ $empresa->configuracoes['redes']['twitter'] ?? '' }}" placeholder="https://x.com/perfil">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Logo da Empresa</label>
            <input type="file" name="logo" class="form-control">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Atualizar Empresa</button>
        </div>
    </form>
</div>

                        {{-- ABA ENDEREÇO --}}
                        <div class="tab-pane" id="endereco-tab">
                            <form action="{{ route('empresa.update', $empresa->id) }}" method="POST">
                                @csrf @method('PUT')
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-map-marker me-1"></i> Localização do Negócio</h5>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">CEP</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="cep" name="cep" value="{{ $empresa->cep ?? '' }}" placeholder="00000-000">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Logradouro (Rua/Avenida)</label>
                                        <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{ $empresa->logradouro }}" placeholder="Ex: Rua das Flores, 123">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">Número</label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="numero" 
                                            name="numero" 
                                            value="{{ $empresa->numero ?? '' }}" 
                                            placeholder="Ex: 123">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" name="bairro" value="{{ $empresa->bairro ?? '' }}">
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $empresa->cidade ?? '' }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">UF</label>
                                        <input type="text" class="form-control" id="uf" name="estado" value="{{ $empresa->estado ?? '' }}" maxlength="2">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Complemento / Ponto de Referência</label>
                                        <input type="text" class="form-control" name="complemento" value="{{ $empresa->complemento ?? '' }}" placeholder="Sala 10, próximo ao mercado...">
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-info mt-2"><i class="mdi mdi-content-save"></i> Salvar Endereço</button>
                                </div>
                            </form>
                        </div>

                        {{-- ABA USUÁRIO --}}
                        <div class="tab-pane" id="usuario-tab">
                            <form action="{{ route('perfil.update', auth()->user()->id) }}" method="POST">
                                @csrf @method('PUT')
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Dados de Acesso</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Seu Nome</label>
                                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">E-mail (Login)</label>
                                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                    </div>
                                </div>
                                
                                <h5 class="mb-3 text-uppercase bg-light p-2 mt-2"><i class="mdi mdi-key me-1"></i> Alterar Senha</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nova Senha</label>
                                        <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Confirmar Senha</label>
                                        <input type="password" name="password_confirm" class="form-control" placeholder="Repita a nova senha">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary mt-2"><i class="mdi mdi-content-save"></i> Salvar Perfil</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="galeria">
                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Dados de Acesso</h5>
                                    <form action="{{ route('empresa.update.galeria', $empresa->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="card border-dashed border-2 text-center p-4" style="border: 2px dashed #dee2e6; cursor: pointer;" onclick="document.getElementById('fotos_input').click();">
                                            <div class="card-body">
                                                <i class="mdi mdi-cloud-upload text-primary" style="font-size: 2.5rem;"></i>
                                                <h4 class="mt-2">Adicionar novas fotos</h4>
                                                <p class="text-muted small">Clique aqui para selecionar (Máx. 10 fotos no total)</p>
                                                <input type="file" name="fotos[]" id="fotos_input" class="d-none" multiple accept="image/*" onchange="this.form.submit()">
                                            </div>
                                        </div>
                                    </form>

                            <div class="row" id="galeria-container">
                                @forelse($empresa->fotos as $foto)
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 mb-3" id="foto-card-{{ $foto->id }}">
                                        <div class="card mb-1 shadow-none border">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $foto->caminho) }}" class="card-img-top" style="height: 140px; object-fit: cover;">
                                                
                                                <div class="position-absolute" style="top: 5px; right: 5px; z-index: 10;">
                                <button type="button" 
                                        onclick="confirmarExclusao({{ $foto->id }})" 
                                        class="btn btn-danger btn-sm rounded-circle shadow-sm"
                                        style="width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-4">
                                        <p class="text-muted">Nenhuma foto na galeria.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<style>
    .galeria-item .btn-delete {
        opacity: 0;
        transition: opacity 0.2s;
    }
    .galeria-item:hover .btn-delete {
        opacity: 1;
    }
</style>
<style>
    .mdi-instagram { color: #E1306C; }
    .mdi-facebook { color: #1877F2; }
    .mdi-twitter { color: #000000; } /* Representando o X */
</style>
@include('empresa._modals.modal-compartilhar')
<style>
    .profile-user-box {
        background-color: rgba(255, 255, 255, 0.12);
        border-radius: 0.25rem;
    }
    .bg-nav-pills {
        background-color: #f1f3fa;
        border-radius: 5px;
    }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
.btn-xs { padding: 0.15rem 0.35rem; font-size: 0.7rem; }
</style>


<script>
function confirmarExclusao(fotoId) {
    Swal.fire({
        title: 'Excluir foto?',
        text: "Essa ação não pode ser desfeita!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#fa5c7c', // Cor danger do Hyper
        cancelButtonColor: '#98a6ad',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Chamada AJAX para excluir
            excluirFoto(fotoId);
        }
    })
}

function excluirFoto(fotoId) {
    const url = `/empresa/foto/delete/${fotoId}`;

    // Configuração do Toast idêntica à sua de sessão
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true
    });

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 1. Remove o card da tela
            const elemento = document.getElementById(`foto-card-${fotoId}`);
            if (elemento) {
                elemento.style.transition = '0.3s';
                elemento.style.opacity = '0';
                setTimeout(() => elemento.remove(), 300);
            }

            // 2. Dispara o Toast de sucesso
            Toast.fire({
                icon: 'success',
                title: 'Foto excluída com sucesso!'
            });
        } else {
            // Dispara o Toast de erro caso a controller retorne success: false
            Toast.fire({
                icon: 'error',
                title: data.message || 'Erro ao excluir a foto.'
            });
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        Toast.fire({
            icon: 'error',
            title: 'Erro de comunicação com o servidor.'
        });
    });
}
</script>

<script>
// Função para mostrar preview das fotos selecionadas antes do upload
function previewImages(input) {
    const container = document.getElementById('preview-container');
    container.innerHTML = '';
    if (input.files) {
        [...input.files].forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-md-2 mb-2';
                div.innerHTML = `
                    <div class="position-relative border p-1 rounded">
                        <img src="${e.target.result}" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;">
                        <span class="position-absolute top-0 start-0 badge bg-success">Novo</span>
                    </div>
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}

// Script visual para marcar quais serão excluídas
document.querySelectorAll('.btn-check').forEach(check => {
    check.addEventListener('change', function() {
        const badge = document.getElementById('badge' + this.value);
        if(this.checked) {
            badge.classList.remove('d-none');
            this.nextElementSibling.classList.remove('btn-danger');
            this.nextElementSibling.classList.add('btn-dark');
        } else {
            badge.classList.add('d-none');
            this.nextElementSibling.classList.remove('btn-dark');
            this.nextElementSibling.classList.add('btn-danger');
        }
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('blur', function() {
            let cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                // Opcional: Adicionar um estado de "carregando" nos campos
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('logradouro').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('uf').value = data.uf;
                            
                            // FOCO NO CAMPO NÚMERO
                            document.getElementById('numero').focus();
                        }
                    })
                    .catch(error => console.error('Erro ao buscar CEP:', error));
            }
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Máscara CNPJ
    const cnpj = document.getElementById('cnpj');
    if (cnpj) {
        cnpj.addEventListener('input', (e) => {
            let v = e.target.value.replace(/\D/g, '').slice(0, 14);
            v = v.replace(/^(\d{2})(\d)/, '$1.$2');
            v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
            v = v.replace(/(\d{4})(\d)/, '$1-$2');
            e.target.value = v;
        });
    }

    // Máscara WhatsApp
    const whatsapp = document.getElementById('whatsapp');
    if (whatsapp) {
        whatsapp.addEventListener('input', (e) => {
            let v = e.target.value.replace(/\D/g, '').slice(0, 11);
            if (v.length <= 10) {
                v = v.replace(/^(\d{2})(\d)/, '($1) $2');
                v = v.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                v = v.replace(/^(\d{2})(\d)/, '($1) $2 ');
                v = v.replace(/(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = v;
        });
    }
});
</script>

@endsection