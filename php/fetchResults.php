<?php
// prendi i dati degli esiti da verbalizzare
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php');
    require_once '../php/dbh.inc.php';
    $query = 'SELECT id_attdid_esame_appello as id, id_corso_esame_appello as corso, status, data_svolgimento_appello as data_svolgimento, nome, id_docente_esame_appello as docente, data_scadenza, r.risultato, r.ord_attdid_esame_appello as ordinamento, lode FROM risultato r JOIN attivita_didattica a ON r.id_attdid_esame_appello = a.id AND r.ord_attdid_esame_appello = a.ordinamento WHERE r.matricola_studente = ? 
    AND SYSDATE() <= r.data_scadenza';
    $conn = open_conn();
    if($conn){
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
        $result = fetch_DB($conn, $query, $matricola);
        $data = [];
        while($result && $row = mysqli_fetch_assoc($result)){
            array_push($data, $row);
        }
        $conn -> close();
        echo json_encode($data);
    }
?>