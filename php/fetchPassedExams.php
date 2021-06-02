<?php
    require_once './dbh.inc.php';
    session_start();
        if(!isset($_SESSION['id'])) header('Location: ../index.php');
    $input = json_decode(file_get_contents('php://input'), true); // prendi i dati dalla richiesta AJAX
    $conn = open_conn();
    if($conn){
        $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
        if($input['type'] == 'grades'){ //se la richiesta chiede i voti
            $query = 'SELECT a.id, a.nome, cfu, data_svolgimento as data, voto, lode, ordinamento, id_cdl, d.nome as docente, d.cognome, d.id as id_docente
                        from frequentato f JOIN attivita_didattica a JOIN docente d JOIN studente s ON s.matricola=f.matricola_studente AND f.ord_attdid_esame=a.ordinamento AND f.id_attdid_esame=a.id AND f.id_docente_esame = d.id
                        WHERE matricola_studente=? AND superato=?';
            // seleziona i dati degli esami da mostrare nel libretto
            $superato = mysqli_real_escape_string($conn, $input['passed']);
            $results = fetch_DB($conn, $query, $matricola, $superato); 
            $data = [];
            while($results && $row = mysqli_fetch_assoc($results)){
                array_push($data,$row); //aggiungi ad un array tutte le righe risultanti dalla query
            }
        }elseif($input['type'] == 'cfu'){ //se la richiesta chiede il numero di cfu totali
            $query = 'SELECT cfu_totali from cdl c JOIN studente s ON c.id=s.id_cdl WHERE matricola=?';
            // seleziona il numero di cfu totali del cdl
            $results = fetch_DB($conn, $query, $matricola); 
            $data = [];
            while($results && $row = mysqli_fetch_assoc($results)){
                array_push($data,$row); //aggiungi ad un array tutte le righe risultanti dalla query
            }
        }
        $conn -> close(); //chiudi la connessione al db
        echo json_encode($data); //invia i risultati
    }
?>