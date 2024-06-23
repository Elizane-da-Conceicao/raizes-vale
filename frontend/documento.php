<?php
include 'includes/config.php';
?>

<div id="myModal" class="modal">
  <div class="modal-content">
        <div class="header-documento">
            <h3>Adicione Documentos Comprobatórios</h3>
            <button class="close-button-documentos" onclick="fecharModal()">×</button>
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
            <label id="checkPrivado">
                <input type="checkbox" id="privado" name="privado" value="false" onchange="updateCheckboxValue(this)">
                <span></span> <p id="textoPrivado">Privado</p>
            </label>
        </form>
        <button class="salvar-button" onclick="salvarDocumento()">Salvar</button>
    </div>
</div>
</body>
<script>
    function updateCheckboxValue(checkbox) {
    if (checkbox.checked) {
        checkbox.value = "true";
    } else {
        checkbox.value = "false";
    }
}
</script>