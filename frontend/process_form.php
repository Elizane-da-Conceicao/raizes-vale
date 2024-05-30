<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $sobrenomes = $_POST['sobrenomes'];
    $data_nascimento = $_POST['data_nascimento'];
    $local_nascimento = $_POST['local_nascimento'];
    $data_falecimento = $_POST['data_falecimento'];
    $local_falecimento = $_POST['local_falecimento'];
    $historia_vida = $_POST['historia_vida'];
    $sexo = $_POST['sexo'];

    // Conecte-se ao banco de dados
    $conn = new mysqli('host', 'username', 'password', 'database');

    // Verifique a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Insira os dados no banco de dados
    $sql = "INSERT INTO colonizadores (nome, sobrenomes, data_nascimento, local_nascimento, data_falecimento, local_falecimento, historia_vida, sexo)
            VALUES ('$nome', '$sobrenomes', '$data_nascimento', '$local_nascimento', '$data_falecimento', '$local_falecimento', '$historia_vida', '$sexo')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo registro criado com sucesso";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
