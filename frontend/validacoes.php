<?php
include 'includes/config.php';
?>
    <div class="container-header">
    <?php
    include 'includes/header.php';
    ?>
        <div class="container">
        <h1 class="titulos-pagina">Solicitações Pendentes</h1>
        <form>
            <div id="">
                <input type="text" placeholder="Pesquisar" class="input-pesquisa">

                <table>
                <thead>
                    <tr>
                        <th>Pessoa</th>
                        <th>Solicitante</th>
                        <th>Evento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Peter Höfelmann</td>
                        <td>Elizane da Conceição</td>
                        <td>Alteração</td>
                        <td>
                            <img src="./assets/img/fichavalidacao.jpg" alt="Icone arvore"> 
                             <img src="./assets/img/validacaoaceita.jpg" alt="Icone arvore"> 
                             <img src="./assets/img/validacaonegada.jpg" alt="Icone arvore">
                        </td>
                    </tr>
                    <tr>
                        <td>Louise Höfelmann</td>
                        <td>Elizane da Conceição</td>
                        <td>Inserção</td>
                        <td>
                            <img src="./assets/img/fichavalidacao.jpg" alt="Icone arvore"> 
                             <img src="./assets/img/validacaoaceita.jpg" alt="Icone arvore"> 
                             <img src="./assets/img/validacaonegada.jpg" alt="Icone arvore">
                        </td>
                    </tr>
                    <tr>
                        <td>August Höfelmann</td>
                        <td>Elizane da Conceição</td>
                        <td>Inserção</td>
                        <td>
                            <img src="./assets/img/fichavalidacao.jpg" alt="Icone arvore"> 
                             <img src="./assets/img/validacaoaceita.jpg" alt="Icone arvore"> 
                             <img src="./assets/img/validacaonegada.jpg" alt="Icone arvore">
                        </td>
                    </tr>
                    <tr>
                        <td>Helena Höfelmann</td>
                        <td>Elizane da Conceição</td>
                        <td>Alteração</td>
                        <td>
                            <img src="./assets/img/fichavalidacao.jpg" alt="Icone arvore"> 
                             <img src="./assets/img/validacaoaceita.jpg" alt="Icone arvore"> 
                             <img src="./assets/img/validacaonegada.jpg" alt="Icone arvore">
                        </td>
                    </tr>
                </tbody>
            </table>

            </div>
        </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault(); // Impede o envio padrão do formulário
                
                // Obtenha os valores dos campos de e-mail e senha
                var email = $('#email').val();
                var senha = $('#senha').val();
                var url = '<?php echo $baseAPI ?>usuarios/logar';
                console.log(url)
                // Faça a solicitação para a API de login
                $.ajax({
                    url: url,
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        email: email,
                        senha: senha
                    }),
                    success: function(response) {
                        // Se a resposta for bem-sucedida, redirecione o usuário para a página de início
                        window.location.href = 'inicio.php';
                    },
                    error: function(xhr, status, error) {
                        // Se houver um erro na resposta, mostre uma mensagem de erro ao usuário
                        alert('Erro ao fazer login. Verifique suas credenciais e tente novamente.');
                    }
                });
            });
        });
    </script>