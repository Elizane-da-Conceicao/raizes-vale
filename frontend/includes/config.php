<?php
// Configurações de URLs
$baseURL = "http://localhost/raizes-vale/raizes-vale/frontend/";
$loginURL = $baseURL . "login.php";
$cadastroUsuarioURL = $baseURL . "cadastrousuario.php";
$cadastroURL = $baseURL . "cadastro.php";
$inicioURL = $baseURL . "inicio.php";
$inserirPessoasLigacoes = $baseURL . "novos_membros.php";
$validacoes = $baseURL . "validacoes.php";
$consulta = $baseURL . "consulta.php";

$baseAPI = "http://127.0.0.1:8000/api/";
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/4.0.1/js/jquery.orgchart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.9/css/jquery.orgchart.min.css">
</head>
