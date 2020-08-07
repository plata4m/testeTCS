<?php
    // Header retornando JSon
    header('Content-Type: application/json; charset=utf-8');

    // importa a conexao
    include 'connection.php'; 

    $conn = getConnection();

    if ($conn->connect_error) {

        $objUrl->ERR_CODE = '009';
        $objUrl->Description = "Database not conected";
        die("Connection failed: " . $conn->connect_error);
        echo json_encode($objUrl);

    } else {

        $sql = "SELECT id, url, alias, time_taken FROM testetcs.urls ";
        $result = mysqli_query($conn, $sql);
        
        $row_cnt = mysqli_num_rows($result);

        $array = array();
        if ($row_cnt > 0) {
            $i=0;
            while($row = mysqli_fetch_assoc($result)) {              
                $objUrl[$i]->id = $row["id"];
                $objUrl[$i]->url = $row["url"];
                $objUrl[$i]->alias = $row["alias"];
                $objUrl[$i]->time_taken = $row["time_taken"];
                $i++;
            }
            
          } else {
              $objUrl->error = 1;
              $objUrl->msg = "Não existe URl para listar";
              echo json_encode($objUrl);
          }

    }
    echo json_encode($objUrl);
?>