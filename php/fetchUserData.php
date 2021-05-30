<?php
    require_once '../php/dbh.inc.php';
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php');
    $conn = open_conn();
    if($conn){
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
        $query = 'SELECT studente.nome as nome_studente, studente.cognome,studente.cf,studente.email,studente.matricola,studente.indirizzo,studente.percorso,studente.id_cdl,studente.anno_iscrizione,studente.anno_di_corso,studente.data_nascita,cdl.id as cdl_id,cdl.nome as nome_cdl,facolta.id facolta_id,facolta.nome nome_facolta FROM studente JOIN cdl JOIN facolta ON id_cdl=cdl.id AND id_facolta=facolta.id WHERE matricola=?;';
        $result = fetch_DB($conn, $query, $matricola);
        if($result && $studente = mysqli_fetch_assoc($result)){
            $conn -> close();
            echo json_encode($studente);
        }
    }else echo null;
?>