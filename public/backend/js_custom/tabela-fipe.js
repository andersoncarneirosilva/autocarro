document.addEventListener('DOMContentLoaded', function() {
    //console.log("tabela fipe");
    // Adicione isso logo no início do DOMContentLoaded
    // Usamos aspas simples ao redor do Blade para o JS entender como String primeiro
const userIsPro = "{{ auth()->user()->plano === 'Pro' ? 'true' : 'false' }}" === 'true';
    const selectMarca = document.getElementById('marca');
    if (!selectMarca) {
        return;
    }

    

    const inputTipo = document.getElementById('veiculo_tipo');
    //const selectMarca = document.getElementById('marca');
    const selectModelo = document.getElementById('modelo_carro');
    const selectVersao = document.getElementById('versao');
    const inputAno = document.getElementById('input-ano');
    const selectCombustivel = document.querySelector('select[name="combustivel"]');

    const BASE_URL = 'https://parallelum.com.br/fipe/api/v1';
    const TOKEN = window.AppConfig.fipeToken;

    const requestOptions = {
        method: 'GET',
        headers: {
            'X-Subscription-Token': TOKEN,
            'Accept': 'application/json'
        }
    };

    const tipoRota = getTipoRota();
    const marcaSalva = "{{ $veiculo->marca }}";
    const modeloSalvo = "{{ $veiculo->modelo }}";
    const versaoSalva = "{{ $veiculo->versao }}";

    const dbMarcaId = document.getElementById('db_fipe_marca_id')?.value;
    const dbModeloId = document.getElementById('db_fipe_modelo_id')?.value;
    const dbVersaoId = document.getElementById('db_fipe_versao_id')?.value;

    const alertaErro = document.getElementById('alerta-fipe-erro');
    
    function getTipoRota() {
        const valor = inputTipo ? inputTipo.value.toUpperCase() : 'AUTOMOVEL';
        if (valor === 'MOTOCICLETA' || valor === 'MOTO') return 'motos';
        if (valor === 'CAMINHAO' || valor === 'CAMINHÃO') return 'caminhoes';
        return 'carros';
    }
    
    fetch(`${BASE_URL}/${tipoRota}/marcas`, requestOptions)
        .then(response => {
            //console.log(`Status: ${response.status} | Tipo: ${tipoRota}`);
            if (response.ok) {
            alertaErro.classList.add('d-none');
        }

        if (!response.ok) {
            // Se for erro 500 e a rota for motos, exibe o alerta do Hyper
            if (response.status === 500) {
                alertaErro.classList.remove('d-none');
            }
            throw new Error('Erro na API');
        }
        
        return response.json();
        })
        .then(marcas => {
            if (!Array.isArray(marcas)) return;

            selectMarca.innerHTML = '<option value="">Selecione a Marca</option>';
            
            marcas.forEach(marca => {
                const opt = document.createElement('option');
                opt.value = marca.codigo;
                opt.textContent = marca.nome;
                
                if (dbMarcaId && marca.codigo == dbMarcaId) {
                    opt.selected = true;
                } else if (!dbMarcaId && marcaSalva && marca.nome.toUpperCase().includes(marcaSalva.toUpperCase())) {
                    opt.selected = true;
                }
                
                selectMarca.appendChild(opt);
            });

            if (selectMarca.value) {
                const inputMarcaNome = document.getElementById('marca_nome');
                if (inputMarcaNome) inputMarcaNome.value = selectMarca.options[selectMarca.selectedIndex].text;
                
                carregarModelos(selectMarca.value, dbModeloId);
            }
        })
        .catch(error => console.error('Erro ao carregar marcas:', error));

    function carregarModelos(marcaId, modeloIdParaSelecionar) {
    selectModelo.innerHTML = '<option value="">Carregando...</option>';
    selectModelo.disabled = true;
    
    fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos`, requestOptions)
        .then(res => res.json())
        .then(data => {
            selectModelo.innerHTML = '<option value="">Selecione o Modelo</option>';
            
            if (data.modelos && Array.isArray(data.modelos)) {
                data.modelos.forEach(m => {
                    const opt = new Option(m.nome, m.codigo);
                    
                    if (modeloIdParaSelecionar && String(m.codigo) === String(modeloIdParaSelecionar)) {
                        opt.selected = true;
                    } 
                    else if (!modeloIdParaSelecionar && modeloSalvo && m.nome.toUpperCase() === modeloSalvo.toUpperCase()) {
                        opt.selected = true;
                    }
                    
                    selectModelo.add(opt);
                });
            }

            selectModelo.disabled = false;

            if (selectModelo.value) {
                const inputModNome = document.getElementById('modelo_nome');
                if (inputModNome) inputModNome.value = selectModelo.options[selectModelo.selectedIndex].text;
                
                carregarVersoes(marcaId, selectModelo.value, dbVersaoId);
            }
        });
}

    function carregarVersoes(marcaId, modeloId, versaoIdParaSelecionar) {
    selectVersao.innerHTML = '<option value="">Carregando...</option>';
    
    const idBusca = versaoIdParaSelecionar ? String(versaoIdParaSelecionar).trim() : null;

    fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos/${modeloId}/anos`, requestOptions)
        .then(res => res.json())
        .then(anos => {
            selectVersao.innerHTML = '<option value="">Selecione a Versão</option>';
            
            anos.forEach(a => {
                const opt = new Option(a.nome, a.codigo);
                
                if (idBusca && a.codigo == idBusca) {
                    opt.selected = true;
                } 
                else if (!idBusca && versaoSalva && a.nome.includes(versaoSalva)) {
                    opt.selected = true;
                }
                
                selectVersao.add(opt);
            });

            if (selectVersao.value) {
                const inputVerNome = document.getElementById('versao_nome');
                if (inputVerNome) {
                    inputVerNome.value = selectVersao.options[selectVersao.selectedIndex].text;
                }
                
                selectVersao.dispatchEvent(new Event('change'));
            }
        })
        .catch(err => {
            console.error("Erro ao carregar versões:", err);
            selectVersao.innerHTML = '<option value="">Erro ao carregar</option>';
        });
}

    selectMarca.addEventListener('change', function() {
        const marcaId = this.value;
        const marcaNome = this.options[this.selectedIndex].text;
        if(document.getElementById('marca_nome')) document.getElementById('marca_nome').value = marcaNome;
        carregarModelos(marcaId);
    });

    selectModelo.addEventListener('change', function() {
        const marcaId = selectMarca.value;
        const modeloId = this.value;
        if(document.getElementById('modelo_nome')) document.getElementById('modelo_nome').value = this.options[this.selectedIndex].text;
        carregarVersoes(marcaId, modeloId);
    });

    selectVersao.addEventListener('change', function() {
    const marcaId = selectMarca.value;
    const modeloId = selectModelo.value;
    const anoId = this.value;

    if (this.selectedIndex !== -1) {
        const nomeVersao = this.options[this.selectedIndex].text;
        document.getElementById('versao_nome').value = nomeVersao;
       
    }

    if (!userIsPro) {
        return; // Interrompe aqui
    }
    
    if (marcaId && modeloId && anoId) {
        const elPrice = document.getElementById('fipe-price');
        if(elPrice) elPrice.innerText = "Consultando...";

        fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos/${modeloId}/anos/${anoId}`, requestOptions)
    .then(response => {
        return response.json();
    })
    .then(veiculo => {
        const cardPrice = document.getElementById('fipe-price');
        const cardInfo = document.getElementById('fipe-info');
        const cardComparison = document.getElementById('fipe-comparison');

        if (cardPrice) {
            cardPrice.innerText = veiculo.Valor;
        } else {
        }

        if (cardInfo) {
            cardInfo.innerText = `Ref: ${veiculo.MesReferencia}`;
        }

        if (cardComparison) {
            const valorVendaRaw = "{{ $veiculo->valor_oferta > 0 ? $veiculo->valor_oferta : $veiculo->valor }}";
            const valorVenda = parseFloat(valorVendaRaw);
            const valorFipe = parseFloat(veiculo.Valor.replace(/[R$\s.]/g, '').replace(',', '.'));

            if (!isNaN(valorFipe) && valorFipe > 0 && !isNaN(valorVenda) && valorVenda > 0) {
                const diff = valorVenda - valorFipe;
                const percent = ((diff / valorFipe) * 100).toFixed(1);
                
                cardComparison.className = (diff > 0 ? 'text-danger' : 'text-success') + ' me-2 fw-bold';
                cardComparison.innerHTML = `
                    <i class="mdi ${diff > 0 ? 'mdi-arrow-up' : 'mdi-arrow-down'}"></i> 
                    ${Math.abs(percent)}% vs FIPE
                `;
            }
        }
    })
    .catch(err => {
        console.error("❌ Erro na consulta FIPE:", err);
        const errorPrice = document.getElementById('fipe-price');
        if(errorPrice) errorPrice.innerText = "Erro ao buscar";
    });
    }
});
});