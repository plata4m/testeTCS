<?php
    // Header retornando JSon
    header('Content-Type: application/json; charset=utf-8');

    // pega o timer inicial
    $inicio1 = microtime(true);

    // importa a conexao
    include 'connection.php'; 

    // Recebe parametros de URL no formato JSon e crtia umobjeto com os parametros
    //  $json = file_get_contents('php://input'); // teste com insomnia
    $json = json_encode($_POST);
    $objUrl = json_decode($json);

    $aliasUrl = $objUrl->alias;
    $urlOriginal = $objUrl->url;

    // Gera uma url curta randomica com 5 caracteres
    $randomicoCaracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $alias = substr(str_shuffle($randomicoCaracteres), 0, 5);

    // verifica se veio alias    
    if(empty($aliasUrl)){
        $implementAlias = $alias;    
    } else {
        $implementAlias = $objUrl->alias;
    }

    // Efetua a conexao como banco    
    $conn = getConnection();
   // $objUrl = null;

    if ($conn->connect_error) {

        $objUrl->ERR_CODE = '009';
        $objUrl->Description = "Database not conected";
        die("Connection failed: " . $conn->connect_error);
        echo json_encode($objUrl);

    } else {

        // verifica se o alias que veio ou que foi gerado existe 
        $sqlFindExist = "SELECT alias FROM testetcs.urls WHERE alias = '".$implementAlias."' ";
        $execQuery = mysqli_query($conn, $sqlFindExist);
        $row_cnt = mysqli_num_rows($execQuery);

        if ($row_cnt > 0) {

            $objUrl->ERR_CODE = '001';
            $objUrl->alias = $implementAlias;
            $objUrl->Description = "CUSTOM ALIAS ALREADY EXISTS";
            echo json_encode($objUrl);

        } else {
            // pega o tempo total 
            $total1 = microtime(true) - $inicio1;
            $tempototal = substr(strval($total1),0,5);

            // cadastra na base de dados
            $sqlInsert = "INSERT INTO testetcs.urls ( url, alias, time_taken ) VALUES ('".$urlOriginal."','".$implementAlias."','".$tempototal."') ";

             $execQuery2 = mysqli_query($conn, $sqlInsert);

            // valida o cadastro retornando os dados cadastrados com sucesso ou erro no cadastro
            if ($execQuery2 > 0) {
                $objUrl = null;
                $objUrl->ERR_CODE = '000';
                $objUrl->message = "Cadastrado com sucesso!";
                $objUrl->url = $urlOriginal;
                $objUrl->urlnova = 'http://localhost/TesteEmpresaTCS/$implementAlias';
                $objUrl->alias = $implementAlias;
                $objUrl->time_taken = $tempototal;
                echo json_encode($objUrl);
            } else {
                $objUrl = null;
                $objUrl->ERR_CODE = "003";
                $objUrl->Description = "ERROR INSERT URL. TRY AGAIN.";
                die("Connection failed: " . $conn->connect_error);
                echo json_encode($objUrl);
            }
        }

    }
?>