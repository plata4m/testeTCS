<?php
    // Header retornando JSon
    header('Content-Type: application/json; charset=utf-8');

    // pega o timer inicial
    $inicio1 = microtime(true);

    // importa a conexao
    include 'connection.php'; 

    // Recebe parametros de URL no formato JSon e crtia umobjeto com os parametros
    //$json = file_get_contents('php://input'); // teste com insomnia
    $json = json_encode($_POST);
    $objUrl = json_decode($json);

    $Url = $objUrl->url;

    // Efetua a conexao como banco    
    $conn = getConnection();
    $objUrl = null;

    if ($conn->connect_error) {

        $objUrl->ERR_CODE = '009';
        $objUrl->Description = "Database not conected";
        die("Connection failed: " . $conn->connect_error);
        echo json_encode($objUrl);
        
    } else {

        // verifica se a url existe
        $sqlFindExist = "SELECT alias FROM testetcs.urls WHERE alias = '".$Url."' ";
        $execQuery = mysqli_query($conn, $sqlFindExist);
        $row_cnt = mysqli_num_rows($execQuery);

        if ($row_cnt <= 0) {
            
            $objUrl->ERR_CODE = '002';
            $objUrl->alias = $Url ;
            $objUrl->Description = "SHORTENED URL NOT FOUND";
            echo json_encode($objUrl);

        }  else {

            $objUrl->alias = $Url ;
            $objUrl->Description = "URL LOCALIZADA";
            echo json_encode($objUrl);
        }
    }
?>