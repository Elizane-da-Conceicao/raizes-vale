<?php
include 'includes/config.php';
include 'includes/header.php';
 // Carrega o conteúdo dinâmico
//  include 'includes/content_loader.php';
?>
    <form id="loginForm" class="container mt-5">
        <h2 class="mb-4">Tela de Login</h2>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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


<?php include 'includes/footer.php'; ?>