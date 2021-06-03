<?php
// prende gli esami per i quali non sono stati compilati i questionari
    require_once '../php/dbh.inc.php';
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se non è satto eseguito l'accesso
    $conn = open_conn();
    if($conn){
        $data = array();
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
        $query = 'SELECT e.id_corso, e.id_attdid, e.ord_attdid, e.id_docente, f.questionario, ac.anno, a.nome as nome_attdid, a.cfu, d.id as id_doc, d.nome as nome_doc, d.cognome as cognome_doc FROM frequentato f JOIN esame e JOIN docente d JOIN attdid_cdl ac JOIN attivita_didattica a ON f.id_attdid_esame = e.id_attdid AND f.ord_attdid_esame = e.ord_attdid AND f.id_corso_esame = e.id_corso AND e.id_docente = d.id AND f.id_attdid_esame = ac.id_attdid AND f.ord_attdid_esame = ac.ord_attdid AND f.id_attdid_esame = a.id AND f.ord_attdid_esame = a.ordinamento WHERE matricola_studente = ?;';
        $result = fetch_DB($conn, $query, $matricola);
        while($result && $quest = mysqli_fetch_assoc($result)){
            array_push($data, $quest);
        }
        $conn -> close();
        echo json_encode($data);
    }else{
        echo json_encode('Error');
    }
?>