<?php
    require_once '../php/dbh.inc.php';
    session_start();

    if (!isset($_SESSION['id'])){
        header('Location: ../index.php'); //rimanda alla pagina del login
    }
    echo json_encode(getAvvisi());

    //funzione che genera un array contenente tutti gli avvisi
    function getAvvisi(){ 
        $conn = open_conn();
        if($conn){
            $avvisi = array();
            $query = 'SELECT * FROM avviso ORDER BY timestamp DESC;'; // recupera tutti gli avvisi in ordine di data
            $result = fetch_DB($conn,$query);
            while ($result && $row=mysqli_fetch_assoc($result)){
                array_push($avvisi,$row);
            }
            $conn -> close();
            return $avvisi;
        }
        return [];
    }
?>