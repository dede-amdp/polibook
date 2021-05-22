<?php
    require_once '../php/dbh.inc.php';
    $inputs = json_decode(file_get_contents('php://input'), true);
    $matricola = '000000'; //!!DA CAMBIARE PER SESSION
    $conn = open_conn();
    $id = explode(',', mysqli_real_escape_string($conn, $inputs['dataString']));
    if(verify($conn, $id)){
    $status = $inputs['status'];
    $query = "UPDATE risultato SET status = ? WHERE matricola_studente = ? AND id_corso_esame_appello = ? AND id_attdid_esame_appello = ? AND id_docente_esame_appello = ? AND ord_attdid_esame_appello = ? AND data_svolgimento_appello = ?;";
    $result = update_DB($conn,$query,$status, $matricola, ...$id);
    $conn -> close();
    echo json_encode($result);
    }else{
        $conn -> close();
        echo json_encode(false);
    }
    // !! INSERIRE LA VERIFICA PER LA DATA DI SCADENZA COSì DA EVITARE CHE QUALCHE FURBETTO ACCETTI/RIFIUTI PRIMA DEL TEMPO

    function verify($conn, $id){
        $matricola = '000000'; //!! DA MODIFICARE
        $query = 'SELECT data_scadenza >= SYSDATE() late FROM risultato WHERE matricola_studente = ? AND id_corso_esame_appello = ? AND id_attdid_esame_appello = ? AND id_docente_esame_appello = ? AND ord_attdid_esame_appello = ? AND data_svolgimento_appello = ?;';
        $result = fetch_DB($conn, $query, $matricola, ...$id);
        if($result && $appello = mysqli_fetch_assoc($result)){
            return $appello['late'];
        }else return false;
    }
?>