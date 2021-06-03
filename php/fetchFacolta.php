<?php
// recupero i dati delle facolta
    require_once '../php/dbh.inc.php';
    $conn = open_conn();
    if($conn){
        $query = 'SELECT nome from facolta';
        $result = fetch_DB($conn, $query);
        $data = array();
        while($result && $fac = mysqli_fetch_assoc($result)){
            array_push($data, $fac);
        }
        echo json_encode($data);
    }else{
        echo json_encode(null);
    }
?>