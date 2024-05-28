<?php
include 'includes/config.php';
?>
    <div class="container-header">
    <?php
    include 'includes/header.php';
    ?>
        <div class="container">
        <h1 class="titulos-pagina">Adicionar Colonizador</h1>
        <form>
            <div id="lados">
                <div id="input-escrever">
                    <div>
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" placeholder="Nome" class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Sobrenomes</label>
                        <input type="text" placeholder="Sobrenomes" class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Data de Nascimento</label>
                        <input type="text" placeholder="dd/mm/aaaa"class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Local de Nascimento</label>
                        <input type="text" placeholder="Local de Nascimento"class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Data de Falecimento</label>
                        <input type="text" placeholder="dd/mm/aaaa"class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">Local de Falecimento</label>
                        <input type="text" placeholder="Local de Falecimento"class="input-cadastro">
                    </div>
                    <div>
                        <label for="name" class="form-label">História de vida</label>
                        <textarea id="area-texto" placeholder="Insira um resumo"></textarea>
                    </div>
                </div>
                <div id="lado-direito">
                    <div>
                        <label for="name" class="form-label">Sexo</label>
                        <select>
                        <option value="Feminino">Feminino</option>
                        <option value="Masculino">Masculino</option>
                        </select>

                    </div>
                    <div>
                        <label for="name" class="form-label">Documentos comprobatórios</label>
                        <input type="button" value="Adicionar Documentos">
                    </div>
                </div>
            </div>
            <div id="botoes-centrelizados">
                    <div class="centraliza">
                    <input type="button" class="botoes" value="Limpar">
                    <input type="submit" class="botoes" value="Salvar">
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