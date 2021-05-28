<?php
/* Elimina dalla tabella 'risultato' l'esame selezionato dall'utente */
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php');
    require_once './dbh.inc.php';
    $inputs = json_decode(file_get_contents('php://input'), true);
    $conn = open_conn();
    if($conn){
        $matricola = mysqli_real_escape_string($conn,$_SESSION['matricola']);
        $id = explode(',', mysqli_real_escape_string($conn, $inputs['dataString'])); // inserisce gli escaper characters per impedire SQLinjection
        $query = 'DELETE from risultato WHERE matricola_studente=? AND id_corso_esame_appello=? AND id_attdid_esame_appello=? AND id_docente_esame_appello=? AND ord_attdid_esame_appello=? AND data_svolgimento_appello=? AND SYSDATE() <= (SELECT data_fine FROM appello WHERE id_corso_esame=? AND id_attdid_esame=? AND id_docente_esame=? AND ord_attdid_esame=? AND data_svolgimento=?)';
        $result = delete_DB($conn,$query, $matricola, ...$id, ...$id);
        echo json_encode($result);
    }else{
        echo json_encode('Fail'); 
    }
?>