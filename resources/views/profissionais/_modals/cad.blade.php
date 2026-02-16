<div class="modal fade" id="modalCadastrarFuncionario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Novo Profissional - Alcecar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            {{-- Adicione o enctype abaixo --}}
                <form action="{{ route('profissionais.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#dados-pessoais" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                <span class="d-none d-md-block">Dados Pessoais</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#aba-servicos" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-scissors-cutting d-md-none d-block"></i>
                                <span class="d-none d-md-block">Serviços e Comissões</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#aba-horarios" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-calendar-clock d-md-none d-block"></i>
                                <span class="d-none d-md-block">Agenda</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="dados-pessoais">
    <div class="row align-items-center">
        <div class="col-md-4 text-center border-end">
            <div class="profile-upload-container position-relative d-inline-block">
                <div class="avatar-wrapper shadow-sm mb-2" style="width: 150px; height: 150px; margin: 0 auto; position: relative; border-radius: 50%; overflow: hidden; border: 3px solid #f1f3fa;">
                    <img id="preview-foto-cadastro" 
                         src="{{ asset('backend/images/avatar-blank.png') }}" 
                         class="profile-img-preview" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                    
                    {{-- Overlay Interativo --}}
                    <div class="avatar-edit-overlay" 
                         onclick="document.getElementById('input-foto-cadastro').click();"
                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; transition: 0.3s; cursor: pointer; color: white;">
                        <i class="fas fa-camera mb-1"></i>
                        <span style="font-size: 10px;">ADICIONAR</span>
                    </div>
                </div>
                
                <input type="file" name="foto" id="input-foto-cadastro" class="d-none" accept="image/*">
                
                <h5 class="mt-2 mb-0 fw-bold small">Foto do Perfil</h5>
                <p class="text-muted" style="font-size: 10px;">Clique para subir</p>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Nome<span class="text-danger">*</span></label>
                    <input type="text" name="nome" class="form-control" placeholder="Nome completo" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cor na Agenda</label>
                    <input type="color" name="cor_agenda" class="form-control form-control-color w-100" value="#727cf5">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Especialidade / Cargo</label>
                    <select name="especialidade" class="form-select">
                        <option value="">Selecione...</option>
                        <option value="Cabeleireiro(a)">Cabeleireiro(a)</option>
                        <option value="Barbeiro(a)">Barbeiro(a)</option>
                        <option value="Manicure / Nail Design">Manicure / Nail Design</option>
                        <option value="Maquiador(a)">Maquiador(a)</option>
                        <option value="Esteticista">Esteticista</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
    <label class="form-label">Telefone <span class="text-danger">*</span></label>
    <input type="text" 
           name="telefone" 
           class="form-control phone-mask" 
           placeholder="(00) 00000-0000"
           required>
</div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">E-mail (Login)<span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Senha de Acesso<span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirmar senha<span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
        </div>
    </div>
</div>

                        <div class="tab-pane" id="aba-servicos">
                            <div class="alert alert-info font-13 mb-3">
                                Selecione os serviços que este profissional realiza e defina a comissão individual.
                            </div>

                            <div class="row g-2 overflow-auto" style="max-height: 300px;">
                                @foreach($servicos as $servico)
                                    <div class="col-md-6">
                                        <div class="card border shadow-none mb-2 item-servico-selecionavel" style="cursor: pointer;">
                                            <div class="card-body p-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="form-check">
                                                        <input type="checkbox" 
                                                            class="form-check-input check-servico" 
                                                            id="serv_{{ $servico->id }}" 
                                                            name="servicos_selecionados[{{ $loop->index }}][id]" 
                                                            value="{{ $servico->id }}">
                                                        <label class="form-check-label fw-bold text-dark" for="serv_{{ $servico->id }}">
                                                            {{ $servico->nome }}
                                                        </label>
                                                        <input type="hidden" name="servicos_selecionados[{{ $loop->index }}][nome]" value="{{ $servico->nome }}">
                                                    </div>
                                                    <div class="input-group input-group-sm w-50 div-comissao d-none">
                                                        <input type="number" 
                                                            name="servicos_selecionados[{{ $loop->index }}][comissao]" 
                                                            class="form-control" 
                                                            placeholder="Comissão">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="tab-pane" id="aba-horarios">
    <div class="alert alert-info font-13 mb-3">
        Marque os dias de trabalho e defina o expediente do profissional.
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-centered mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 50px;">Ativo</th>
                    <th>Dia da Semana</th>
                    <th>Início</th>
                    <th>Fim</th>
                </tr>
            </thead>
            <tbody>
                @foreach(['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                @php $diaLower = strtolower($dia); @endphp
                <tr class="linha-horario">
                    <td>
                        <div class="form-check form-switch">
                            <input type="checkbox" 
                                   name="horarios[{{ $diaLower }}][trabalha]" 
                                   class="form-check-input check-dia" 
                                   id="check_{{ $diaLower }}"
                                   value="1">
                        </div>
                    </td>
                    <td>
                        <label class="form-check-label fw-bold" for="check_{{ $diaLower }}">{{ $dia }}</label>
                    </td>
                    <td>
                        <input type="time" 
                               name="horarios[{{ $diaLower }}][inicio]" 
                               class="form-control form-control-sm input-hora" 
                               value="08:00" 
                               disabled>
                    </td>
                    <td>
                        <input type="time" 
                               name="horarios[{{ $diaLower }}][fim]" 
                               class="form-control form-control-sm input-hora" 
                               value="18:00" 
                               disabled>
                    </td>
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
                    <button type="submit" class="btn btn-primary">Salvar Profissional</button>
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

    $('.phone-mask').mask(behavior, options);
});
</script>
<script>
document.querySelectorAll('.check-servico').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const card = this.closest('.card');
        const divComissao = card.querySelector('.div-comissao');
        
        if (this.checked) {
            card.classList.add('border-primary', 'bg-light');
            divComissao.classList.remove('d-none');
        } else {
            card.classList.remove('border-primary', 'bg-light');
            divComissao.classList.add('d-none');
        }
    });
});

// Permitir clicar no card para marcar o checkbox
document.querySelectorAll('.item-servico-selecionavel').forEach(card => {
    card.addEventListener('click', function(e) {
        if (e.target.type !== 'checkbox' && e.target.type !== 'number') {
            const cb = this.querySelector('.check-servico');
            cb.checked = !cb.checked;
            cb.dispatchEvent(new Event('change'));
        }
    });
});
</script>

<script>
document.querySelectorAll('.check-dia').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const linha = this.closest('.linha-horario');
        const inputs = linha.querySelectorAll('.input-hora');
        
        if (this.checked) {
            inputs.forEach(input => {
                input.disabled = false;
                input.classList.remove('bg-light');
            });
            linha.classList.add('table-primary-light'); // Opcional: destaca a linha
        } else {
            inputs.forEach(input => {
                input.disabled = true;
                input.classList.add('bg-light');
            });
            linha.classList.remove('table-primary-light');
        }
    });
});
</script>

{{-- SCRIPT PARA PREVIEW DA FOTO --}}
<script>
// Preview da foto no Modal de Cadastro
const inputFotoCad = document.getElementById('input-foto-cadastro');
if (inputFotoCad) {
    inputFotoCad.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-foto-cadastro');
                if (preview) preview.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
}
</script>