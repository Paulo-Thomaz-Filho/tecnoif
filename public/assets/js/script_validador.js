$(document).ready(function() {
    // Função para validar CPF
    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

        let soma = 0;
        for (let i = 0; i < 9; i++)
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        let resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(9))) return false;

        soma = 0;
        for (let i = 0; i < 10; i++)
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(10))) return false;

        return true;
    }

    // Função para validar CNPJ
    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        if (cnpj.length !== 14 || /^(\d)\1+$/.test(cnpj)) return false;

        let tamanho = cnpj.length - 2;
        let numeros = cnpj.substring(0, tamanho);
        let digitos = cnpj.substring(tamanho);
        let soma = 0;
        let pos = tamanho - 7;
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)) return false;

        return true;
    }

    // Validação dos campos do formulário e serviços
   $("#enviarDados").click(function() {
        // Obtém os valores dos campos
        let nome = $("#nome").val().trim();
        let email = $("#email").val().trim();
        let cpf_cnpj = $("#cpf").val().trim();
        let text_area = $("#text_area").val().trim();

        // Verifica se todos os campos estão preenchidos
        if (nome && email && cpf_cnpj && text_area) {
            // Verifica se CPF ou CNPJ é válido
            if (validarCPF(cpf_cnpj) || validarCNPJ(cpf_cnpj)) {

                let dados = {
                    nome: nome,
                    email: email,
                    cpf_cnpj: cpf_cnpj,
                    mensagem: text_area
                };

                $.ajax({
                    url: "enviar",
                    type: "POST",
                    data: JSON.stringify(dados),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json", 
                    success: function(response) {
                        if (response.success == true) {
                            alert("Sua mensagem foi enviada com sucesso!");
                            // Limpa os campos do formulário após o envio bem-sucedido
                            $("#nome").val('');
                            $("#email").val('');
                            $("#cpf").val('');
                            $("#text_area").val('');
                        } else {
                            alert("Erro: " + (response.error || "Ocorreu um problema ao salvar os dados."));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Erro na requisição: " + error);
                    }
                });
            } else {
                alert("cpf ou cnpj errado!");
            }
        } else {
            alert("Preencha todos os campos!");
        }
    });
});