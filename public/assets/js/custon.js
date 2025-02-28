
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };



    document.addEventListener('DOMContentLoaded', function() {
        const foneInput = document.getElementById('fone');
        
        foneInput.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, ''); // Remove qualquer caractere não numérico
            if (valor.length > 2) valor = '(' + valor.slice(0, 2) + ') ' + valor.slice(2);
            if (valor.length > 9) valor = valor.slice(0, 9) + '-' + valor.slice(9, 14);
            e.target.value = valor;
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const cepInput = document.getElementById('cep');
        
        cepInput.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (valor.length > 5) valor = valor.slice(0, 5) + '-' + valor.slice(5, 8); // Formata o CEP
            e.target.value = valor;
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const cpfInput = document.getElementById('cpf');
        const im = new Inputmask('999.999.999-99'); // Máscara para CPF no formato XXX.XXX.XXX-XX
        im.mask(cpfInput);
    });

    document.addEventListener('DOMContentLoaded', function() {
        const cpfInput = document.getElementById('cpf');
        
        cpfInput.addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (valor.length > 3 && valor.length <= 6) valor = valor.slice(0, 3) + '.' + valor.slice(3, 6);
            if (valor.length > 6 && valor.length <= 9) valor = valor.slice(0, 6) + '.' + valor.slice(6, 9);
            if (valor.length > 9) valor = valor.slice(0, 9) + '-' + valor.slice(9, 11);
            e.target.value = valor;
        });
    });