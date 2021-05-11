<?php
    require_once './dbh.inc.php';
    $input = json_decode(file_get_contents('php://input'), true); // prendi i dati dalla richiesta AJAX
    // !! posso prenderli direttamente da $_SESSION?
    $matricola = $input['matricola'];
    if($input['type'] == 'grades'){ //se la richiesta chiede i voti
        $query = 'SELECT id, nome as \'attività didattica\', cfu, data_svolgimento as data, voto, lode
                    from frequentato f JOIN attivita_didattica a ON f.ord_attdid_esame=a.ordinamento AND f.id_attdid_esame=a.id 
                    WHERE matricola_studente=? AND superato=1';
        // seleziona i dati degli esami da mostrare nel libretto
        $conn = open_conn();
        $results = fetch_DB($conn, $query, $matricola); 
        $data = [];
        while($results && $row = mysqli_fetch_assoc($results)){
            array_push($data,$row); //aggiungi ad un array tutte le righe risultanti dalla query
        }
    }elseif($input['type'] == 'cfu'){ //se la richiesta chiede il numero di cfu totali
        $query = 'SELECT cfu_totali from cdl c JOIN studente s ON c.id=s.id_cdl WHERE matricola=?';
        // seleziona il numero di cfu totali del cdl
        $conn = open_conn();
        $results = fetch_DB($conn, $query, $matricola); 
        $data = [];
        while($results && $row = mysqli_fetch_assoc($results)){
            array_push($data,$row); //aggiungi ad un array tutte le righe risultanti dalla query
        }
    }
    $conn -> close(); //chiudi la connessione al db
    echo json_encode($data); //invia i risultati
?>