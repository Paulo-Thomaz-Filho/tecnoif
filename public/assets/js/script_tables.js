$(document).ready(function() {
    function carregarMensagens() {
        $.ajax({
            url: 'mensagens',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const tbody = $("#tabela-mensagens");
                tbody.empty();

                if (data.length === 0) {
                    tbody.append("<tr><td colspan='3'>Nenhuma mensagem encontrada.</td></tr>");
                    return;
                }

                data.forEach((mensagem, index) => {
                    tbody.append(
                        `<tr>
                            <td>${mensagem.nome}</td>
                            <td>${mensagem.email}</td>
                            <td>${mensagem.cpf_cnpj}</td>
                            <td>${mensagem.data_envio}</td>
                            <td>
                                <button class="btn btn-primary btn-sm visualizar-msg" data-mensagem="${mensagem.mensagem}">Visualizar</button>
                            </td>
                        </tr>`
                    );
                });

                // Evento para abrir o modal
                $(".visualizar-msg").click(function() {
                    const msg = $(this).data("mensagem");
                    $("#conteudo-mensagem").text(msg);
                    const modal = new bootstrap.Modal(document.getElementById('mensagemModal'));
                    modal.show();
                });
            },
            error: function(xhr, status, error) {
                console.error("Erro ao carregar mensagens:", xhr.responseText);
                alert("Ocorreu um erro ao carregar as mensagens.");
            }
        });
    }

    carregarMensagens();
});