<?php
include 'includes/config.php';
include 'includes/header.php';
 // Carrega o conteúdo dinâmico
//  include 'includes/content_loader.php';
?>
    <link rel="stylesheet" type="text/css" href="C:\xampp\htdocs\raizes-vale\raizes-vale\frontend\assets\css\style.css">
    <div class="login-container">
        <h1>Bem vindo ao Raízes do Vale</h1>
        <form action="/submit-login" method="post" class="formulario">
            <div class="input-group">
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Senha" required>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Lembrar</label>
            </div>
            <button type="submit">Login</button>
            <p>Já possui uma conta? <a href="/signup">Cadastrar-se</a></p>
        </form>
    </div>

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