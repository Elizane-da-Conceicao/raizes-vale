<?php
if (isset($_GET['parametro'])) {
    $parametro = $_GET['parametro'];
} else {

}
include 'includes/config.php';
?>

<div class="container-header">
  <?php
  include 'includes/header.php';
  ?>
  <!-- <script src="https://balkan.app/js/FamilyTree.js"></script> -->
  <script src="assets\js\cdnbalkan.js"></script>
  <div id="tree">
    
  </div>
</div>

<script>



async function fetchData() {
    try {
      var urlPessoa = "<?php echo $baseAPI; ?>pessoas/pessoa/<?php echo($parametro) ?>";
      const responsePessoa = await fetch(urlPessoa, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      });
      var url = "<?php echo $baseAPI; ?>arvores/montar/<?php echo($parametro) ?>";
      if(responsePessoa.ok)
      {
        const dataPessoa = await responsePessoa.json(); 
        if(dataPessoa.model.Colonizador === "1")
        {
            url = "<?php echo $baseAPI; ?>arvores/montar-pessoa/<?php echo($parametro) ?>";
        }

       const responseArvore = await fetch(url, {
         method: 'GET',
         headers: {
           'Content-Type': 'application/json',
         },
       });
 
       if (responseArvore.ok) {
          const data = await responseArvore.json(); 
          var family = new FamilyTree(document.getElementById("tree"), {
            mouseScrool: FamilyTree.action.none,
            nodeBinding: {
              field_0: "name"
            },
            nodes: PercorreArvore(data.model, null, null, [])
          });
        } 
        else {
         console.error("Erro ao buscar dados da árvore:", responseArvore.status);
       }
    }
    } catch (error) {
      console.error("Erro na requisição:", error);
    }
  }

  // Chama a função ao carregar a página
  fetchData();

function PercorreArvore(model, pai, mae, nodos)
{
    var idPessoa = model.pessoa.Pessoa_id;
    var nome = model.pessoa.Nome;
    var genero = model.pessoa.Sexo == "F" ? "female" : "male";
    var casamento = model.conjuge != null ? [model.conjuge.Pessoa_id] : null;
    nodos.push({ id: idPessoa, pids: casamento, mid: mae, fid: pai, name: nome, gender: genero });
    if(casamento != null)
    {
        nodos.push({ id: casamento, pids: [idPessoa], mid: null, fid: null, name: model.conjuge.Nome, gender: model.conjuge.Sexo == "F" ? "female" : "male" });
    }

    if(model.descendentes.length > 0)
    {
        model.descendentes.forEach(filho => {
            PercorreArvore(filho, model.pessoa.Pessoa_id, casamento, nodos);
        });
    }

    return nodos; 
}

</script>