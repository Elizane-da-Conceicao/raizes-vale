<?php
include 'includes/config.php';
include 'includes/header.php';
 // Carrega o conteúdo dinâmico
//  include 'includes/content_loader.php';
?>
    <div class="login-container">
        <h1>Bem vindo ao Raízes do Vale</h1>
        <form id="loginForm" class="formulario">
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
            <p>Já possui uma conta? <a href="<?php echo $cadastroUsuarioURL; ?>">Cadastrar-se</a></p>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.getElementById('loginForm').addEventListener('submit', async function(event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    // Obtém os valores dos campos
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    // Cria o objeto com os dados do formulário
    const formData = {
        "email": email,
        "senha": password
    };

    try {
        // Faz a requisição para o backend
        const response = await fetch('<?php echo $baseAPI; ?>usuarios/logar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        if (response.ok) {
            const result = await response.json();
            console.log('Login realizado com sucesso:', result);
            var storeUser = {
                "idUsuario": result.model.usuario_id,
                "administrador": result.model.administrador 
            };
            localStorage.setItem('usuarioLogado', JSON.stringify(storeUser));
            window.location.href = '<?php echo $consulta; ?>';
        } else {
            alert('Email ou senha invalidos.');
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
    }
});

</script>
<?php include 'includes/footer.php'; ?>