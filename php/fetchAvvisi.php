<?php
require_once '../php/dbh.inc.php';
session_start();

if (!isset($_SESSION['id'])){
    header('Location: ../index.php'); //rimanda alla pagina del login
}

//funzione che genera un array contenente tutti gli avvisi
function getAvvisi(){ 
    $conn = open_conn();
    $avvisi = array();
    $query = 'SELECT * FROM avvisi ';
    $result = fetch_DB($conn,$query);
    if ($result && $row=mysqli_fetch_assoc($result)){
        array_push($avvisi,$row);
    }
    return $avvisi;
}

//funzione che mi restituisce il numero di avvisi 

function countAvvisi(){
    $avvisi = getAvvisi();
    $numAvv = count($avvisi);
    return $numAvv;
}



?>