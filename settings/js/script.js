$(document).ready(function() {

    //abre o modal
    $("#abrirModal").click(function() {

        const emailValidador = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const cnpjValidador = /^\d{2}\.?\d{3}\.?\d{3}\/?\d{4}-?\d{2}$/;
        const cpfValidador = /^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/;

        let nome 
        let email  
        let cpf_cnpj 
        let text_area
        let servico1
        let servico2
        let servico3
        let servicos = '';

        nome = $("#nome").val(); 
        email = $("#email").val(); 
        cpf_cnpj = $("#cpf_cnpj").val(); 
        text_area = $("#text_area").val(); 
        servico1 = $("#servico").prop("checked"); 
        servico2 = $("#servico2").prop("checked"); 
        servico3 = $("#servico3").prop("checked");

        //valida o serviço
        if ( servico1 == true || servico2 == true || servico3 == true ){

            //valida os campos de input
            if (nome != '' && email != '' && cpf_cnpj != '' && text_area != '' ) {

                //valida o email 
                if (emailValidador.test(email)) {

                    //valida o cpf/cnpj
                    if (cpfValidador.test(cpf_cnpj) == true || cnpjValidador.test(cpf_cnpj) == true) {

                        //json 
                        if (servico1 == true) {
                            servicos += 'Estoques, ';                     
                        }
                        if (servico2 == true) {
                            servicos += 'Lojas Virtuais, ';
                        }
                        if (servico3 == true) {
                            servicos += 'Blogs  ';
                        }
                        
                        //Remover a última vírgula e espaço do servico
                        if (servicos.length > 0) {
                            servicos = servicos.slice(0, -2);
                        }

                        //cria a lista
                        var formData = {
                            nome: nome,
                            email: email,
                            cpf: cpf_cnpj,
                            servicos: servicos,
                            mensagem: text_area
                        };

                        //Exibe os dados no modal de sucesso
                        var mensagemExibida = text_area ? text_area : 'Nenhuma mensagem fornecida';

                        var message = `
                            <span class="text-box text-white"><strong>Nome:</strong> ${formData.nome} </span><br>
                            <span class="text-box text-white"><strong>Email:</strong> ${formData.email} </span><br>
                            <span class="text-box text-white"><strong>CPF/CNPJ:</strong> ${formData.cpf} </span><br>
                            <span class="text-box text-white"><strong>Serviços Escolhidos:</strong> ${formData.servicos}  </span><br>
                            <span class="text-box text-white"><strong>Mensagem:</strong> ${mensagemExibida} </span>
                        `;

                        //Coloca a mensagem formatada no modal
                        $('#modalMessage').html(message);

                        //reset do formulario
                        $("#servico").prop("checked", false); 
                        $("#servico2").prop("checked", false); 
                        $("#servico3").prop("checked", false); 
                        $("#email").val('');
                        $("#nome").val('');
                        $("#cpf").val('');
                        $("#text_area").val('');

                        //remove efeito de invalido
                        $('#email').removeClass("is-invalid")
                        $('#nome').removeClass("is-invalid")
                        $('#cpf').removeClass("is-invalid")
                        $('#text_area').removeClass("is-invalid")

                        //redirecionamento para fomulario sucesso
                        var sucessoModal = new bootstrap.Modal(document.getElementById('sucesso'));
                        sucessoModal.show();
                    } else {
                        //alerta e formato do cnpj/cpf invalido 
                        alert("formato do cnpj/cpf invalido");
                        $("#myModal").modal("show");
                    }
                }else{
                    //alerta Email invalido 
                    alert("Email invalido");
                    $("#myModal").modal("show");
                }
            }else {
                            
                //alerta e alteração dos inputs 
                alert("Por favor, preencha todos os campos.");
                $("#myModal").modal("show");

                if (nome == '') {
                    $('#nome').addClass("is-invalid")
                } else {
                    $('#nome').removeClass("is-invalid")
                }
                if (email == '') {
                    $('#email').addClass("is-invalid")
                } else {
                    $('#email').removeClass("is-invalid")
                } 
                if (cpf_cnpj == '') {
                    $('#cpf_cnpj').addClass("is-invalid")
                } else {
                    $('#cpf_cnpj').removeClass("is-invalid")
                } 
                if (text_area == '') {
                    $('#text_area').addClass("is-invalid")
                } else {
                    $('#text_area').removeClass("is-invalid")
                } 
            }
        }else {
            
            //aleta para os checkbox
            alert("Marque o tipo de trabalho desejado")
            $("#myModal").modal("show");
        }
            
    });
});