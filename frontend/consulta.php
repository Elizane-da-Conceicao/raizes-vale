<?php
include 'includes/config.php';
?>
    <div class="container-header">
    <?php
    include 'includes/header.php';
    ?>
        <div class="container">
        <h1 class="titulos-pagina">Consultar Pessoas</h1>
        <form>
            <div id="">
                <input type="text" placeholder="Pesquise pelo nome" class="input-pesquisa">
                <input type="text" placeholder="Adicionar pessoa" class="input-pesquisa">

                <div class="table-container">
        <div class="table-header">
            <div class="table-cell">Nome</div>
            <div class="table-cell actions">Ações</div>
        </div>
        <div class="table-row">
            <div class="table-cell">Augusto Höfelmann</div>
            <div class="table-cell actions">
            <img src="./assets/img/genealogia.jpg" alt="Icone arvore">
                <img src="./assets/img/visualizar.jpg" alt="Icone arvore">
                <img src="./assets/img/lapiseditar.jpg" alt="Icone arvore">
                <img src="./assets/img/lixeira.jpg" alt="Icone arvore">
            </div>
        </div>
        <div class="table-row">
            <div class="table-cell">Henedina Höfelmann</div>
            <div class="table-cell actions">
                <img src="./assets/img/genealogia.jpg" alt="Icone arvore">
                <img src="./assets/img/visualizar.jpg" alt="Icone arvore">
                <img src="./assets/img/lapiseditar.jpg" alt="Icone arvore">
                <img src="./assets/img/lixeira.jpg" alt="Icone arvore">
            </div>
        </div>
        <div class="table-row">
            <div class="table-cell">Luiza Höfelmann</div>
            <div class="table-cell actions">
            <img src="./assets/img/genealogia.jpg" alt="Icone arvore">
                <img src="./assets/img/visualizar.jpg" alt="Icone arvore">
                <img src="./assets/img/lapiseditar.jpg" alt="Icone arvore">
                <img src="./assets/img/lixeira.jpg" alt="Icone arvore">
            </div>
        </div>
        <div class="table-row">
            <div class="table-cell">Nelson Höfelmann</div>
            <div class="table-cell actions">
            <img src="./assets/img/genealogia.jpg" alt="Icone arvore">
                <img src="./assets/img/visualizar.jpg" alt="Icone arvore">
                <img src="./assets/img/lapiseditar.jpg" alt="Icone arvore">
                <img src="./assets/img/lixeira.jpg" alt="Icone arvore">
            </div>
        </div>
    </div>

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