<?php
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "Documentos/";
    $fileName = basename($_FILES["documentos"]["name"][0]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Validar o tipo de arquivo (apenas imagens permitidas)
    $allowedTypes = array('jpg', 'jpeg', 'png');
    if (in_array($fileType, $allowedTypes)) {
        // Upload do arquivo para o servidor
        if (move_uploaded_file($_FILES["documentos"]["tmp_name"][0], $targetFilePath)) {
            $response['status'] = 'success';
            $response['file'] = $targetFilePath;
            $response['type'] = $_POST['tipo-arquivo'];
            $response['title'] = $_POST['titulo'];
            $response['description'] = $_POST['descricao'];
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Erro ao fazer upload do arquivo.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Tipo de arquivo não permitido.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Requisição inválida.';
}

echo json_encode($response);
?>
