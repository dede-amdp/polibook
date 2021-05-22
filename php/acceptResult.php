<?php
    require_once '../php/dbh.inc.php';
    $inputs = json_decode(file_get_contents('php://input'), true);
    $matricola = '000000'; //!!DA CAMBIARE PER SESSION
    $conn = open_conn();
    $id = explode(',', mysqli_real_escape_string($conn, $inputs['dataString']));
    $status = $inputs['status'];
    $query = "UPDATE risultato SET status = ? WHERE matricola_studente = ? AND id_corso_esame_appello = ? AND id_attdid_esame_appello = ? AND id_docente_esame_appello = ? AND ord_attdid_esame_appello = ? AND data_svolgimento_appello = ?;";
    $result = update_DB($conn,$query,$status, $matricola, ...$id);
    $conn -> close();
    echo json_encode($result);
    // !! INSERIRE LA VERIFICA PER LA DATA DI SCADENZA COSì DA EVITARE CHE QUALCHE FURBETTO ACCETTI/RIFIUTI PRIMA DEL TEMPO
?>