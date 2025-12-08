$("#logar").click(function() {

    let nome = $("#nome").val().trim();
    let senha = $("#senha").val().trim();

    if (nome === "" || senha === "") {
        alert("Por favor, preencha todos os campos.");
        return;
    }   

    $.ajax({
        url: 'login',
        type: 'POST',
        data: { nome: nome, senha: senha },
        success: function(response) {
            console.log(response); 
            
            if (response.status === 'success') {
                window.location.href = 'admin';
            } else {
                alert(response.message); 
            }
        },
        error: function(xhr, status, error) {
            console.error("Erro na requisição AJAX: " + status + " - " + error);
            alert("Ocorreu um erro ao tentar logar. Por favor, tente novamente mais tarde.");
        }
    });
});
