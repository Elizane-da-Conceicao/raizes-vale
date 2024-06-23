<?php
include 'includes/config.php';
include 'documento.php';
?>
<div class="login-container">
        <h1>Bem vindo ao Raízes do Vale</h1>
        <form id="signup-form" class="formulario">
        <div class="input-group">
                <input type="text" id="nome" name="nome" placeholder="Nome" required>
            </div>
            <div class="input-group">
                <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>
            </div>
            <div class="input-group">
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Senha" required>
            </div>
            <div class="input-group">
                <input type="password" id="password-verifica" name="password" placeholder="Confirme sua senha" required>
            </div>
            <div class="error" id="error-message">As senhas não coincidem.</div>
            <button type="submit">Cadastrar</button>
            <p>Já possui uma conta? <a href="<?php echo $loginURL; ?>">Entrar</a></p>
        </form>
    </div>

<div id="popupOverlay" class="popup-overlay">
<div class="popup-content">
  <h2>Usuario cadastrado com Sucesso</h2>
  <p>Você sera redirecionado para a tela de login.</p>
</div>

    <script>
    // Função para aplicar a máscara de CPF
    function mascaraCPF(input) {
      let value = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito
      value = value.replace(/^(\d{3})(\d)/, '$1.$2'); // Coloca um ponto entre o terceiro e o quarto dígitos
      value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca um ponto entre o sexto e o sétimo dígitos
      value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Coloca um hífen entre o nono e o décimo dígitos
      input.value = value;
    }

    // Adiciona o evento input ao campo de CPF
    document.getElementById('cpf').addEventListener('input', function() {
      mascaraCPF(this);
    });

    document.addEventListener('DOMContentLoaded', async function() {
      const password = document.getElementById('password');
      const passwordVerifica = document.getElementById('password-verifica');
      const errorMessage = document.getElementById('error-message');
      const form = document.getElementById('signup-form');

      function checkPasswordsMatch() {
        if (password.value !== passwordVerifica.value) {
          errorMessage.style.display = 'block';
          return false;
        } else {
          errorMessage.style.display = 'none';
          return true;
        }
      }
      passwordVerifica.addEventListener('blur', checkPasswordsMatch);
});

function checkPasswordsMatch() {
    const password = document.getElementById('password');
    const passwordVerifica = document.getElementById('password-verifica');
    const errorMessage = document.getElementById('error-message');

    if (password.value !== passwordVerifica.value) {
      errorMessage.style.display = 'block';
      return false;
    } else {
      errorMessage.style.display = 'none';
      return true;
    }
}

document.getElementById('signup-form').addEventListener('submit', async function(event) {
        event.preventDefault();
        
        if (!checkPasswordsMatch()) {
          event.preventDefault(); 
        }
        else{
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData);

            var dataUsuario = {
                "Nome": data.nome,
                "CPF": data.cpf,
                "Email": data.email,
                "administrador": "1",
                "senha": data.password
            };

            console.log(dataUsuario);

            try {
                const responseUsuario = await fetch('<?php echo $baseAPI; ?>usuarios', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataUsuario),
                });

                if (responseUsuario.ok) {
                    const popupOverlay = document.getElementById('popupOverlay');
                    popupOverlay.style.display = 'flex';
                    setTimeout(function() {
                        window.location.href = '<?php echo $loginURL; ?>'; 
                    }, 5000); 
                }
                else{
                    var jsonretorno = await responseUsuario.json();
                    console.log(jsonretorno);
                    if(jsonretorno.message == "Ja possue um usuario cadastrado com esse Email."){
                        alert("Ja possue um usuario cadastrado com esse Email.");
                    }
                    else
                    {
                        alert("Erro ao cadstrar usuario.");
                    }
                }
            }catch{
                alert("Erro ao cadstrar usuario.");
            }    
        }
    });
  </script>