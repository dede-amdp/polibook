<?php
// prendi i dati del profilo utente
    require_once '../php/dbh.inc.php';
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php');
    $conn = open_conn();
    if($conn){
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
        $query = 'SELECT studente.foto, studente.nome as nome_studente, studente.cognome,studente.cf,studente.email,studente.matricola,studente.indirizzo,studente.percorso,studente.id_cdl,studente.anno_iscrizione,studente.anno_corso,studente.data_nascita,cdl.id as cdl_id,cdl.nome as nome_cdl,facolta.id facolta_id,facolta.nome nome_facolta FROM studente JOIN cdl JOIN facolta ON id_cdl=cdl.id AND id_facolta=facolta.id WHERE matricola=?;';
        $result = fetch_DB($conn, $query, $matricola);
        if($result && $studente = mysqli_fetch_assoc($result)){
            // codifico l'immagine in una stringa
            $conn -> close();
            $studente['foto'] = base64_encode($studente['foto']); // aggiungo l'immagine codificata ai dati
            echo json_encode($studente);
        }else {
            // se la prima query non ha avuto risultati vuol dire che lo studente non risulta iscritto: esegui
            // un'altra query per prendere i dati dell'utente senza i dati del corso di laurea
            $query = 'SELECT studente.foto, studente.nome as nome_studente, studente.cognome,studente.cf,studente.email,studente.matricola,studente.indirizzo,studente.data_nascita FROM studente WHERE matricola=?;';
            $result = fetch_DB($conn, $query, $matricola);
            $conn -> close();
            if($result && $studente = mysqli_fetch_assoc($result)){
                // traduco l'immagine in un array di bytes
                $studente['foto'] = base64_encode($studente['foto']);
                echo json_encode($studente);
            }else{
                echo json_encode('error');
            }
        }
    }else echo json_encode('error');
?>