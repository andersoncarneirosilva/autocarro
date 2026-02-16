<style>
    /* Container da foto */
.avatar-wrapper {
    position: relative;
    width: 160px;
    height: 160px;
    margin: 0 auto;
    border: 4px solid #fff;
    border-radius: 50%;
    overflow: hidden;
    transition: all 0.3s ease;
}

.profile-img-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Camada que aparece ao passar o mouse */
.avatar-edit-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
}

.avatar-wrapper:hover .avatar-edit-overlay {
    opacity: 1;
}

.avatar-edit-overlay i {
    font-size: 24px;
    margin-bottom: 5px;
}

/* Estilo para quando a aba for ativada (garantia de visibilidade) */
.tab-pane.fade.show.active {
    display: block !important;
}
</style>

<div class="modal fade" id="modalEditarFuncionario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Editar Profissional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- Adicione o enctype="multipart/form-data" --}}
            <form id="formEditarFuncionario" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#edit-dados-pessoais" data-bs-toggle="tab" class="nav-link active">
                                <span class="d-none d-md-block">Dados Pessoais</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#edit-aba-servicos" data-bs-toggle="tab" class="nav-link">
                                <span class="d-none d-md-block">Serviços e Comissões</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#edit-aba-horarios" data-bs-toggle="tab" class="nav-link">
                                <span class="d-none d-md-block">Agenda</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        

                        <div class="tab-pane show active" id="edit-dados-pessoais">
    <div class="row align-items-center">
        <div class="col-md-4 text-center border-end">
            <div class="profile-upload-container position-relative d-inline-block">
                <div class="avatar-wrapper shadow-sm mb-2" style="width: 150px; height: 150px; margin: 0 auto; position: relative; border-radius: 50%; overflow: hidden; border: 3px solid #f1f3fa;">
                    <img id="edit-preview-foto" 
                         src="{{ asset('backend/images/avatar-blank.png') }}" 
                         class="profile-img-preview" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                    
                    {{-- Overlay Interativo --}}
                    <div class="avatar-edit-overlay" 
                         onclick="document.getElementById('edit-input-foto').click();"
                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; transition: 0.3s; cursor: pointer; color: white;">
                        <i class="fas fa-camera mb-1"></i>
                        <span style="font-size: 10px;">ALTERAR</span>
                    </div>
                </div>
                
                <input type="file" name="foto" id="edit-input-foto" class="d-none" accept="image/*">
                
                <h5 class="mt-2 mb-0 fw-bold small">Foto do Perfil</h5>
                <button type="button" class="btn btn-link btn-sm text-decoration-none" onclick="document.getElementById('edit-input-foto').click();">
                    Trocar imagem
                </button>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Nome<span class="text-danger">*</span></label>
                    <input type="text" name="nome" id="edit_nome" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cor na Agenda</label>
                    <input type="color" name="cor_agenda" id="edit_cor" class="form-control form-control-color w-100">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">E-mail (Login)<span class="text-danger">*</span></label>
                    <input type="email" name="email" id="edit_email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
    <label class="form-label">Telefone <span class="text-danger">*</span></label>
    <input type="text" 
           name="telefone" 
           id="edit_telefone" 
           class="form-control phone-mask" 
           placeholder="(00) 00000-0000">
</div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nova Senha</label>
                    <input type="password" name="password" class="form-control" placeholder="Deixe vazio para manter">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="edit_status" class="form-select">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>


                        <div class="tab-pane" id="edit-aba-servicos">
                            <div class="row g-2 overflow-auto" style="max-height: 300px;">
                                @foreach($servicos as $servico)
                                    <div class="col-md-6">
                                        <div class="card border shadow-none mb-2 item-servico-selecionavel-edit" style="cursor: pointer;">
                                            <div class="card-body p-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="form-check">
                                                        <input type="checkbox" 
                                                               class="form-check-input edit-check-servico" 
                                                               id="edit_serv_{{ $servico->id }}" 
                                                               name="servicos_selecionados[{{ $loop->index }}][id]" 
                                                               value="{{ $servico->id }}">
                                                        <label class="form-check-label fw-bold text-dark">{{ $servico->nome }}</label>
                                                        <input type="hidden" name="servicos_selecionados[{{ $loop->index }}][nome]" value="{{ $servico->nome }}">
                                                    </div>
                                                    <div class="input-group input-group-sm w-50 edit-div-comissao d-none">
                                                        <input type="number" name="servicos_selecionados[{{ $loop->index }}][comissao]" class="form-control">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="tab-pane" id="edit-aba-horarios">
                            <div class="table-responsive">
                                <table class="table table-sm table-centered mb-0">
                                    <tbody>
                                        @foreach(['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                                        @php $diaLower = strtolower($dia); @endphp
                                        <tr class="linha-horario-edit">
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" name="horarios[{{ $diaLower }}][trabalha]" 
                                                           class="form-check-input edit-check-dia" 
                                                           id="edit_check_{{ $diaLower }}" value="1">
                                                </div>
                                            </td>
                                            <td class="fw-bold">{{ $dia }}</td>
                                            <td><input type="time" name="horarios[{{ $diaLower }}][inicio]" class="form-control form-control-sm edit-input-hora" value="08:00" disabled></td>
                                            <td><input type="time" name="horarios[{{ $diaLower }}][fim]" class="form-control form-control-sm edit-input-hora" value="18:00" disabled></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar Profissional</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
    var behavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {
        onKeyPress: function (val, e, field, options) {
            field.mask(behavior.apply({}, arguments), options);
        }
    };

    // Aplica a máscara em todos os campos com a classe phone-mask
    $('.phone-mask').mask(behavior, options);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const botoesEditar = document.querySelectorAll('.btn-editar-funcionario');
    const modalEditElement = document.getElementById('modalEditarFuncionario');
    
    if (!modalEditElement) return;

    const modalEdit = new bootstrap.Modal(modalEditElement);

    botoesEditar.forEach(button => {
        button.addEventListener('click', function() {
            // Captura de dados com fallback para strings vazias ou objetos vazios
            const id = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome') || '';
            const email = this.getAttribute('data-email') || '';
            const telefone = this.getAttribute('data-telefone') || '';
            const cor = this.getAttribute('data-cor') || '#727cf5';
            const status = this.getAttribute('data-status') || '1';
            const foto = this.getAttribute('data-foto');

            // --- LÓGICA DA FOTO NO PREVIEW ---
        const previewImg = document.getElementById('edit-preview-foto');
        if (previewImg) {
            if (foto && foto !== '') {
                // Se o funcionário tem foto, mostra a foto do storage
                previewImg.src = `/storage/${foto}`;
            } else {
                // Se não tem, mostra o avatar padrão
                previewImg.src = "{{ asset('backend/images/avatar-blank.png') }}";
            }
        }
        
        // Limpa o input de arquivo (sempre que abrir um novo para não enviar lixo)
        const inputFoto = document.getElementById('edit-input-foto');
        if(inputFoto) inputFoto.value = '';

            // Parsing seguro de JSON para evitar o erro de "undefined" ou "null"
            let servicosFunc = [];
            let horariosFunc = {};
            try {
                servicosFunc = JSON.parse(this.getAttribute('data-servicos')) || [];
                horariosFunc = JSON.parse(this.getAttribute('data-horarios')) || {};
            } catch (e) {
                console.error("Erro ao processar JSON do funcionário", e);
            }

            // Preenchimento do formulário
            const form = document.getElementById('formEditarFuncionario');
            if(form) form.action = `/profissionais/${id}`;
            
            if(document.getElementById('edit_nome')) document.getElementById('edit_nome').value = nome;
            if(document.getElementById('edit_email')) document.getElementById('edit_email').value = email;
            if(document.getElementById('edit_telefone')) document.getElementById('edit_telefone').value = telefone;
            if(document.getElementById('edit_cor')) document.getElementById('edit_cor').value = cor;
            if(document.getElementById('edit_status')) document.getElementById('edit_status').value = status;

            // --- LÓGICA DE SERVIÇOS ---
            document.querySelectorAll('.edit-check-servico').forEach(check => {
                check.checked = false;
                const card = check.closest('.card');
                const divComissao = card ? card.querySelector('.edit-div-comissao') : null;

                if (card) card.classList.remove('border-primary', 'bg-light');
                if (divComissao) divComissao.classList.add('d-none');
                
                const servId = parseInt(check.value);
                const servicoEncontrado = servicosFunc.find(s => parseInt(s.id) === servId);

                if (servicoEncontrado) {
                    check.checked = true;
                    if (card) card.classList.add('border-primary', 'bg-light');
                    if (divComissao) {
                        divComissao.classList.remove('d-none');
                        const inputComissao = divComissao.querySelector('input');
                        if (inputComissao) inputComissao.value = servicoEncontrado.comissao;
                    }
                }
            });

            // --- LÓGICA DE HORÁRIOS ---
            // Limpa todos os campos antes de preencher
            document.querySelectorAll('.edit-check-dia').forEach(c => {
                c.checked = false;
                const linha = c.closest('.linha-horario-edit');
                if(linha) {
                    linha.querySelectorAll('.edit-input-hora').forEach(i => {
                        i.disabled = true;
                        i.value = "08:00"; // Valor padrão ao resetar
                    });
                }
            });

            // Verifica se horariosFunc é um objeto válido antes de usar Object.keys
            if (horariosFunc && typeof horariosFunc === 'object' && !Array.isArray(horariosFunc)) {
                Object.keys(horariosFunc).forEach(dia => {
                    const checkDia = document.querySelector(`#edit_check_${dia}`);
                    if (checkDia) {
                        checkDia.checked = true;
                        const linha = checkDia.closest('.linha-horario-edit');
                        if(linha) {
                            const inputs = linha.querySelectorAll('.edit-input-hora');
                            inputs.forEach(input => {
                                input.disabled = false;
                                if(input.name.includes('[inicio]') && horariosFunc[dia].inicio) 
                                    input.value = horariosFunc[dia].inicio;
                                if(input.name.includes('[fim]') && horariosFunc[dia].fim) 
                                    input.value = horariosFunc[dia].fim;
                            });
                        }
                    }
                });
            }

            modalEdit.show();
        });
    });

    // 1. Delegar evento para os switches de horário no MODAL DE EDIÇÃO
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('edit-check-dia')) {
            const linha = e.target.closest('.linha-horario-edit');
            if (linha) {
                const inputs = linha.querySelectorAll('.edit-input-hora');
                inputs.forEach(input => input.disabled = !e.target.checked);
            }
        }
    });

    // 2. Lógica para quando o CHECKBOX de serviço mudar (clique direto no check)
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('edit-check-servico')) {
            const cardItem = e.target.closest('.item-servico-selecionavel-edit');
            const divComissao = cardItem ? cardItem.querySelector('.edit-div-comissao') : null;
            
            if (cardItem && divComissao) {
                if (e.target.checked) {
                    cardItem.classList.add('border-primary', 'bg-light');
                    divComissao.classList.remove('d-none');
                } else {
                    cardItem.classList.remove('border-primary', 'bg-light');
                    divComissao.classList.add('d-none');
                }
            }
        }
    });

    // 3. Lógica para quando o CARD de serviço for clicado (clique na área do card)
    document.addEventListener('click', function(e) {
        const cardItem = e.target.closest('.item-servico-selecionavel-edit');
        
        // Se não clicou num card ou clicou direto num input/label, para aqui
        if (!cardItem || e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL') return;

        const checkbox = cardItem.querySelector('.edit-check-servico');
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
            // Dispara o evento 'change' manualmente para ativar a lógica acima
            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });

// Dentro do seu $(document).ready ou DOMContentLoaded
document.getElementById('edit-input-foto').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('edit-preview-foto').src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    }
});

});
</script>
