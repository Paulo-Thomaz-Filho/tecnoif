$("#logar").click(function() {

    let nome = $("#nome").val().trim();
    let senha = $("#senha").val().trim();

    if (nome === "" || senha === "") {
        alert("Por favor, preencha todos os campos.");
        return;
    }   

    $.ajax({
        url: 'settings/php/login.php',
        type: 'POST',
        data: JSON.stringify({ nome, senha }),
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                window.location.href = 'admin';    
            } else {
                alert(response.error || "Erro no login.");
            }
        },
        error: function() {
            alert("Ocorreu um erro ao tentar logar. Tente novamente mais tarde.");
        }
    });
});
