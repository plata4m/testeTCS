<?php

function getConnection() {

    // parâmetros de conexao
    $servername = "localhost";
    $username = "root";
    $password = "123456";
    $schema = "testetcs";

    // Cria a conexao
    $conn = mysqli_connect($servername, $username, $password, $schema);

    // Valida a conexao
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        $conn = null;
    }

    // retorna a conexao
    return $conn;
}

?>
