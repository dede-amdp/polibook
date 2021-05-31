<?php
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php');
    require_once '../php/dbh.inc.php';
    $inputs = json_decode(file_get_contents('php://input'), true);
    $conn = open_conn();
    $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']); 
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

    function verify($conn, $id){
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']); 
        $query = 'SELECT data_scadenza >= SYSDATE() late FROM risultato WHERE matricola_studente = ? AND id_corso_esame_appello = ? AND id_attdid_esame_appello = ? AND id_docente_esame_appello = ? AND ord_attdid_esame_appello = ? AND data_svolgimento_appello = ?;';
        $result = fetch_DB($conn, $query, $matricola, ...$id);
        if($result && $appello = mysqli_fetch_assoc($result)){
            return $appello['late'];
        }else return false;
    }
?>