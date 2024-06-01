<?php
if (isset($_GET['parametro'])) {
    $parametro = $_GET['parametro'];
} else {

}
include 'includes/config.php';
?>

<!-- Modal -->
<div id="infoModal" class="modal-info-pessoa">
    <div class="modal-info-content">
        <span class="close-button">&times;</span>
        <h2>Informações da Pessoa</h2>
        <p id="modal-nome"></p>
        <p id="modal-responsavel"></p>
        <p id="modal-status"></p>
    </div>
</div>