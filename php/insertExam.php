<?php
/* Inserisce nella tabella 'risultato' del database i dati indicati in $table*/
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php');
    require_once './dbh.inc.php';
    $inputs = json_decode(file_get_contents('php://input'), true);
    $conn = open_conn();
    if($conn){
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
        $id = explode(',', mysqli_real_escape_string($conn, $inputs['dataString'])); // inserisce gli escaper characters per impedire SQLinjection
        if(verify($conn, $id)){
            $table = 'risultato (data_iscrizione, matricola_studente, id_corso_esame_appello, id_attdid_esame_appello, id_docente_esame_appello, ord_attdid_esame_appello, data_svolgimento_appello)';
            $result = insert_DB($conn, $table, date('Y-m-d'), $matricola, ...$id);
            $conn ->close();
            if($result) echo json_encode($result);
            else echo json_encode(false);
        }else{
            $conn ->close();
            echo json_encode("inc");
        }
    }

    function verify($conn, $id){
        // verifica se i dati in ingresso sono coerenti (per evitare che l'utente possa inserire iscrizioni ad appelli di esami che non fanno parte del corso di studi)
        // !! VERIFICA LA DATA DI PRENOTAZIONE ANCHE, NEL CASO QUALCUNO VOGLIA ISCRIVERSI AD UN ESAME FUORI DAL PERIODO DI ISCRIZIONE
        array_pop($id); // elimina la data dell'appello che non mi interessa
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']); //da prendere da $_SESSION
        $query = 'SELECT id_corso_esame, id_attdid_esame, id_docente_esame, ord_attdid_esame FROM frequentato WHERE matricola_studente = ? AND superato = 0 AND id_corso_esame = ? AND id_attdid_esame = ? AND id_docente_esame = ? AND ord_attdid_esame = ?';
        $result = fetch_DB($conn, $query, $matricola, ...$id);
        return $result && mysqli_num_rows($result) == 1;
    }
?>