<?php
    require_once '../php/dbh.inc.php';
    $conn = open_conn();
    if($conn){
        $query = 'SELECT * from cdl';
        $result = fetch_DB($conn, $query);
        $data = array();
        while($result && $cdl = mysqli_fetch_assoc($result)){
            array_push($data, $cdl);
        }
        $conn -> close();
        echo json_encode($data);
    }else{
        echo json_encode(null);
    }
?>