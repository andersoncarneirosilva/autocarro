document.addEventListener('DOMContentLoaded', function() {
    const inputTipo = document.getElementById('veiculo_tipo');
    const selectMarca = document.getElementById('marca');
    const selectModelo = document.getElementById('modelo_carro');
    const selectVersao = document.getElementById('versao');
    const inputAno = document.getElementById('input-ano');
    const selectCombustivel = document.querySelector('select[name="combustivel"]');

    const BASE_URL = 'https://parallelum.com.br/fipe/api/v1';
    const TOKEN = window.AppConfig.fipeToken;

    // Objeto de configuração para os headers (centralizado)
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

    // 1. DECLARE AS VARIÁVEIS APENAS UMA VEZ NO TOPO
    const dbMarcaId = document.getElementById('db_fipe_marca_id')?.value;
    const dbModeloId = document.getElementById('db_fipe_modelo_id')?.value;
    const dbVersaoId = document.getElementById('db_fipe_versao_id')?.value;

    // 2. Defina a função ANTES de usá-la
    function getTipoRota() {
        const valor = inputTipo ? inputTipo.value.toUpperCase() : 'AUTOMOVEL';
        if (valor === 'MOTOCICLETA' || valor === 'MOTO') return 'motos';
        if (valor === 'CAMINHAO' || valor === 'CAMINHÃO') return 'caminhoes';
        return 'carros';
    }
    
    // --- CARREGAMENTO INICIAL DE MARCAS ---
    // Removi a linha duplicada que estava causando o erro de Syntax
    fetch(`${BASE_URL}/${tipoRota}/marcas`, requestOptions)
        .then(response => {
            if (!response.ok) throw new Error('Erro na API');
            return response.json();
        })
        .then(marcas => {
            if (!Array.isArray(marcas)) return;

            selectMarca.innerHTML = '<option value="">Selecione a Marca</option>';
            
            marcas.forEach(marca => {
                const opt = document.createElement('option');
                opt.value = marca.codigo;
                opt.textContent = marca.nome;
                
                // Comparação com o ID vindo do banco
                if (dbMarcaId && marca.codigo == dbMarcaId) {
                    opt.selected = true;
                } else if (!dbMarcaId && marcaSalva && marca.nome.toUpperCase().includes(marcaSalva.toUpperCase())) {
                    opt.selected = true;
                }
                
                selectMarca.appendChild(opt);
            });

            if (selectMarca.value) {
                // Atualiza o hidden name="marca_nome"
                const inputMarcaNome = document.getElementById('marca_nome');
                if (inputMarcaNome) inputMarcaNome.value = selectMarca.options[selectMarca.selectedIndex].text;
                
                // Passa o ID do modelo salvo para a próxima função
                carregarModelos(selectMarca.value, dbModeloId);
            }
        })
        .catch(error => console.error('Erro ao carregar marcas:', error));

    function carregarModelos(marcaId, modeloIdParaSelecionar) {
    // Limpa o select e desativa para evitar seleção errada enquanto carrega
    selectModelo.innerHTML = '<option value="">Carregando...</option>';
    selectModelo.disabled = true;
    
    fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos`, requestOptions)
        .then(res => res.json())
        .then(data => {
            selectModelo.innerHTML = '<option value="">Selecione o Modelo</option>';
            
            if (data.modelos && Array.isArray(data.modelos)) {
                data.modelos.forEach(m => {
                    const opt = new Option(m.nome, m.codigo);
                    
                    // PRIORIDADE MÁXIMA: Comparação por ID numérico
                    if (modeloIdParaSelecionar && String(m.codigo) === String(modeloIdParaSelecionar)) {
                        opt.selected = true;
                    } 
                    // SEGUNDA OPÇÃO: Se não tiver ID no banco, tenta o nome exato
                    else if (!modeloIdParaSelecionar && modeloSalvo && m.nome.toUpperCase() === modeloSalvo.toUpperCase()) {
                        opt.selected = true;
                    }
                    
                    selectModelo.add(opt);
                });
            }

            selectModelo.disabled = false;

            if (selectModelo.value) {
                // Atualiza o nome real para o input hidden
                const inputModNome = document.getElementById('modelo_nome');
                if (inputModNome) inputModNome.value = selectModelo.options[selectModelo.selectedIndex].text;
                
                // Dispara o carregamento da versão usando o ID do banco
                carregarVersoes(marcaId, selectModelo.value, dbVersaoId);
            }
        });
}

    function carregarVersoes(marcaId, modeloId, versaoIdParaSelecionar) {
    selectVersao.innerHTML = '<option value="">Carregando...</option>';
    
    // Limpamos o ID de espaços para evitar erros de comparação
    const idBusca = versaoIdParaSelecionar ? String(versaoIdParaSelecionar).trim() : null;

    fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos/${modeloId}/anos`, requestOptions)
        .then(res => res.json())
        .then(anos => {
            selectVersao.innerHTML = '<option value="">Selecione a Versão</option>';
            
            anos.forEach(a => {
                const opt = new Option(a.nome, a.codigo);
                
                // PRIORIDADE: ID salvo no banco (2015-1)
                if (idBusca && a.codigo == idBusca) {
                    opt.selected = true;
                } 
                // FALLBACK: Caso o ID falhe, tenta pelo Ano salvo na variável versaoSalva
                else if (!idBusca && versaoSalva && a.nome.includes(versaoSalva)) {
                    opt.selected = true;
                }
                
                selectVersao.add(opt);
            });

            // Se selecionou algo, atualiza o nome e dispara o card da FIPE
            if (selectVersao.value) {
                const inputVerNome = document.getElementById('versao_nome');
                if (inputVerNome) {
                    inputVerNome.value = selectVersao.options[selectVersao.selectedIndex].text;
                }
                
                // Isso vai fazer o card da FIPE aparecer automaticamente
                selectVersao.dispatchEvent(new Event('change'));
            }
        })
        .catch(err => {
            console.error("Erro ao carregar versões:", err);
            selectVersao.innerHTML = '<option value="">Erro ao carregar</option>';
        });
}

    // --- EVENTOS ---

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

    // CAPTURA O TEXTO DA VERSÃO (O que o usuário lê no select)
    if (this.selectedIndex !== -1) {
        const nomeVersao = this.options[this.selectedIndex].text;
        document.getElementById('versao_nome').value = nomeVersao;
        //console.log("📝 Nome da versão definido para:", nomeVersao);
    }
    
    if (marcaId && modeloId && anoId) {
        //console.log("🚀 Alcecar: Iniciando busca de valores...");
        //console.log(`Parâmetros: Marca ${marcaId}, Modelo ${modeloId}, Ano ${anoId}`);

        const elPrice = document.getElementById('fipe-price');
        if(elPrice) elPrice.innerText = "Consultando...";

        fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos/${modeloId}/anos/${anoId}`, requestOptions)
    .then(response => {
        //console.log("Status da Resposta:", response.status);
        return response.json();
    })
    .then(veiculo => {
        // EXIBE OS DADOS NO CONSOLE EM FORMATO DE TABELA
        //console.log("✅ Dados FIPE recebidos:");
        //console.table(veiculo);

        // BUSCA OS ELEMENTOS NOVAMENTE PARA GARANTIR A INJEÇÃO NO CARD
        const cardPrice = document.getElementById('fipe-price');
        const cardInfo = document.getElementById('fipe-info');
        const cardComparison = document.getElementById('fipe-comparison');

        if (cardPrice) {
            cardPrice.innerText = veiculo.Valor;
            //console.log("Injetado no card -> Valor:", veiculo.Valor);
        } else {
            //console.error("❌ Erro: Elemento #fipe-price não encontrado no DOM!");
        }

        if (cardInfo) {
            cardInfo.innerText = `Ref: ${veiculo.MesReferencia}`;
            //console.log("Injetado no card -> Referência:", veiculo.MesReferencia);
        }

        if (cardComparison) {
            const valorVendaRaw = "{{ $veiculo->valor_oferta > 0 ? $veiculo->valor_oferta : $veiculo->valor }}";
            const valorVenda = parseFloat(valorVendaRaw);
            // Tratamento do valor FIPE (remove R$, pontos e troca vírgula por ponto)
            const valorFipe = parseFloat(veiculo.Valor.replace(/[R$\s.]/g, '').replace(',', '.'));

            //console.log("📊 Comparativo de Preços:");
            //console.log(`Valor Venda: R$ ${valorVenda}`);
            //console.log(`Valor FIPE: R$ ${valorFipe}`);

            // Verifica se ambos os valores são números válidos e maiores que zero
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