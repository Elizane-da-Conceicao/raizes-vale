<?php
// Recebe o parâmetro 'page' da requisição GET
$page = $_GET['page'] ?? 'inicio';

// Define o caminho do arquivo de conteúdo com base no parâmetro 'page'
$contentPath = '../views/' . $page . '.php';

// Verifica se o arquivo de conteúdo existe e o inclui
if (file_exists($contentPath)) {
    include $contentPath;
} else {
    echo "Arquivo não encontrado!"; die();
    //include '../inicio.php'; // Página padrão se 'page' não for válida
}
?>
