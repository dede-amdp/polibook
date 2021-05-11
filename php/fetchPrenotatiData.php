<?php
/* prende le tuple da 'risultato' che contengono la stessa matricola che è stata indicata, ovvero mostra all'utente gli esami ai quali è iscritto.*/
    require_once './dbh.inc.php';
    $inputs = json_decode(file_get_contents('php://input'), true);
    $matricola = $inputs['matricola'];
    $query = 'SELECT r.id_corso_esame_appello as corso, r.id_docente_esame_appello as id_docente, d.nome as docente, d.cognome as cognome_docente, a.id, a.nome as \'attività didattica\', a.ordinamento, r.data_svolgimento_appello as \'data svolgimento\', ap.data_fine as \'disponibile fino al\', messaggio FROM risultato r JOIN appello ap JOIN attivita_didattica a JOIN docente d ON r.id_attdid_esame_appello= a.id AND r.ord_attdid_esame_appello=a.ordinamento AND d.id = r.id_docente_esame_appello AND
    ap.id_attdid_esame = r.id_attdid_esame_appello AND ap.id_docente_esame = r.id_docente_esame_appello AND ap.ord_attdid_esame = r.ord_attdid_esame_appello AND ap.data_svolgimento = r.data_svolgimento_appello WHERE matricola_studente=? AND status IS NULL';
    $conn = open_conn();
    $result = fetch_DB($conn, $query, $matricola);
    $conn -> close();
    $data = [];
    while($result && $row=mysqli_fetch_assoc($result)){
        array_push($data, $row);
    }
    echo json_encode($data);

?>