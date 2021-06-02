<?php
    require_once '../php/dbh.inc.php';
    $conn = open_conn();
    if($conn){
        $query = 'SELECT ordinamento from attivita_didattica GROUP BY ordinamento';
        $result = fetch_DB($conn, $query);
        $data = array();
        while($result && $ord = mysqli_fetch_assoc($result)){
            array_push($data, $ord);
        }
        $conn -> close();
        echo json_encode($data);
    }else{
        echo json_encode(null);
    }
?>