<?php
include 'config.php';
?>

<nav id="header">
    <a><img class="icon-usuario" src="./assets/img/usuario.jpg" alt="Icone arvore"></a>
    <a id="validacoes-header" href="<?php echo $validacoes; ?>"> <img class="icon-nav" src="./assets/img/estralaceita.jpg" alt="Icone arvore">Validações</a>
    <a href="<?php echo $consulta; ?>"> <img class="icon-nav" src="./assets/img/consultalogo.jpg" alt="Icone arvore">Consulta</a>
    <a href="<?php echo $cadastroURL; ?>"> <img class="icon-nav" src="./assets/img/tree.png" alt="Icone arvore">Nova arvore</a>
    <a href="<?php echo $inserirPessoasLigacoes; ?>"> <img class="icon-people" src="./assets/img/people.png" alt="Icone arvore">Inserir Pessoas/Ligações</a>
    <a id="logout" href="<?php echo $loginURL; ?>"><img class="icon-nav" src="./assets/img/logout.jpg" alt="Icone arvore"></a>
</nav>
<hr>

<script>
function validausuario()
{
    let storedUser = localStorage.getItem('usuarioLogado');
    if (storedUser) {
      storedUser = JSON.parse(storedUser);
      if(storedUser.administrador == 1)
      {
        document.getElementById('validacoes-header').style.display = 'none';
      }
    }else {
        document.getElementById('validacoes-header').style.display = 'none';
    }
}

validausuario();

document.addEventListener("DOMContentLoaded", function() {
  const logoutLink = document.getElementById('logout');
  logoutLink.addEventListener('click', function(event) {
    localStorage.clear();
    // localStorage.removeItem('usuarioLogado');
  });
});
</script>
