<?php
    // prendi le risposte del questionario e inseriscile nel database
    session_start();
    require_once '../php/dbh.inc.php';
    if(!isset($_SESSION['id'])) header('Location:../index.php');
    if(isset($_POST['id'])) {
        $conn = open_conn();
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
        $id = explode(',', mysqli_real_escape_string($conn, $_POST['id']));
        $table = 'questionario (risposte, data_compilazione, id_esame_corso, id_esame_attdid, ord_esame_attdid, id_esame_docente)';
        $risposte = '';
        foreach($_POST as $key => $value){
            if($key != 'id'){
                $risposte = $risposte."<$key>$value</$key>"; // traduci le risposte in un XML elementare
            }
        }
        if(verify($conn, $id)){ // verifica che i dati siano coerenti
            if(insert_DB($conn, $table, $risposte, date('Y-m-d'), ...$id)){
                $query = 'UPDATE frequentato SET questionario=1 WHERE matricola_studente= ? AND id_corso_esame = ? AND id_attdid_esame = ? AND ord_attdid_esame = ? AND id_docente_esame = ?;';
                if(update_DB($conn, $query, $matricola, ...$id)) $_SESSION['error_msg'] = 'Questionario compilato';
                // seguono messaggi di errore
                else $_SESSION['error_msg'] = 'Errore nella compilazione del questionario, riprova più tardi';
            }else{
                $_SESSION['error_msg'] = 'Non è stato possibile inviare le risposte, riprova più tardi';
            }
        }else{
            $_SESSION['error_msg'] = 'Questa attività didattica non è presente nel tuo percorso di studi ancora';
        }
        $conn -> close();
    }else{
        $_SESSION['error_msg'] = 'Errore nella compilazione del questionario';
    }
    header('Location: ../pages/questionnaires.php');

    function verify($conn, $id){
        // verifica che le informazioni siano coerenti
        $query = 'SELECT * FROM frequentato WHERE matricola_studente = ? AND id_corso_esame = ? AND id_attdid_esame = ? AND ord_attdid_esame = ? AND id_docente_esame = ?;';
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
        $result = fetch_DB($conn, $query, $matricola, ...$id);
        return mysqli_num_rows($result) == 1;
    }
?>