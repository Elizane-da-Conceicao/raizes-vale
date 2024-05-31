<?php
include 'includes/config.php';
?>

<div id="myModal" class="modal">
  <div class="modal-content">
        <div class="header-documento">
            <h3>Adicione Documentos Comprobatórios</h3>
            <button class="close-button" onclick="fecharModal()">×</button>
        </div>
        <form id="modalForm">
            <label for="tipo-arquivo">Escolha o tipo de arquivo</label>
            <select id="tipo-arquivo" name="tipo-arquivo">
                <option value="" disabled selected>Escolha o tipo</option>
                <option value="tipo1">png</option>
                <option value="tipo2">pdf</option>
                <option value="tipo3">jpg</option>
            </select>

            <!-- <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" placeholder="Insira o título"> -->

            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" class="area-texto-documento" placeholder="Insira a descrição"></textarea>
            <input type="file" name="documentos[]" class="input-cadastro" id="documento">
        </form>
        <button class="salvar-button" onclick="salvarDocumento()">Salvar</button>
    </div>
</div>
</body>

<script>
// function abrirModal() {
//   var modal = document.getElementById("myModal");
//   modal.style.display = "flex"; // Mostrar o modal
// }



// document.querySelector('.inserir-button').addEventListener('click', async function(event) {
//           event.preventDefault();
          
//           const form = document.getElementById('modalForm');
//           const formData = new FormData(form);
//           const dataForm = Object.fromEntries(formData);
//           console.log(dataForm);
//           try {
//                   // Adicione o objeto à memória da página
//                   const documentos = JSON.parse(localStorage.getItem('documentos')) || [];
//                   documentos.push(dataForm);
//                   localStorage.setItem('documentos', JSON.stringify(documentos));

//                   alert('Documento salvo com sucesso!');
//           } catch (error) {
//               console.error('Erro:', error);
//               alert('Erro ao salvar o documento.');
//           }
//       });


</script>