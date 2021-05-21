<?php
/* prende le tuple contenute in 'appello' e le mostra all'utente SE la data_fine segue quella odiena. Inoltre una query conta il numero di tuple in 'risultato' che hanno le stesse chiavi delle tuple di 'appello' (conta il numero di iscritti)
l'informazione è poi unita al resto delle informazioni relative all'appello per evitare che l'utente possa iscriversi all'esame se il numero di iscritti è pari a quello massimo mostrando comunque l'appello perchè in caso un utente decida di disinscriversi
l'utente che voglia iscriversi sia consapevole dell'esistenza dell'appello così da potersi iscrivere*/
    require_once './dbh.inc.php';
    $inputs = json_decode(file_get_contents('php://input'), true);
    $matricola = $inputs['matricola'];
    $query_iscritti = 'SELECT COUNT(r.matricola_studente) as iscritti, a.id_corso_esame, a.id_docente_esame, a.id_attdid_esame, a.ord_attdid_esame FROM appello a JOIN risultato r ON a.id_corso_esame = r.id_corso_esame_appello AND a.id_docente_esame = r.id_docente_esame_appello AND a.id_attdid_esame = r.id_attdid_esame_appello AND a.ord_attdid_esame = r.ord_attdid_esame_appello a.data_svolgimento = r.data_svolgimento_appello GROUP BY id_corso_esame, id_docente_esame, id_attdid_esame, ord_attdid_esame';
    $query = 'SELECT f.id_corso_esame as corso, f.id_docente_esame as id_docente, d.nome as docente, d.cognome as cognome, f.id_attdid_esame as id, ad.nome, f.ord_attdid_esame as ordinamento, a.data_svolgimento as data, a.data_fine as scadenza,
    aula, max_iscritti, messaggio FROM frequentato f JOIN docente d JOIN attivita_didattica ad JOIN appello a ON d.id = f.id_docente_esame AND f.id_attdid_esame= a.id_attdid_esame AND f.ord_attdid_esame = a.ord_attdid_esame AND f.id_corso_esame = a.id_corso_esame AND f.id_attdid_esame = ad.id AND f.ord_attdid_esame = ad.ordinamento WHERE matricola_studente=? AND SYSDATE() BETWEEN data_inizio and data_fine AND (a.id_corso_esame, a.id_attdid_esame, a.ord_attdid_esame, a.id_docente_esame, a.data_svolgimento) NOT IN 
    (SELECT id_corso_esame_appello, id_attdid_esame_appello, ord_attdid_esame_appello, id_docente_esame_appello, data_svolgimento_appello FROM risultato WHERE matricola_studente = ?)';
    $conn = open_conn();
    $result_iscritti = fetch_DB($conn, $query_iscritti);
    $result = fetch_DB($conn, $query, $matricola, $matricola);
    $conn -> close();
    $count_iscritti = [];
    while($result_iscritti && $row=mysqli_fetch_assoc($result_iscritti)){
        array_push($count_iscritti, $row);
    }
    $data = [];
    while($result && $row=mysqli_fetch_assoc($result)){
        // trova l'esame corrispondente ed allega il numero di iscritti
        $n_iscritti = 0;
        foreach($count_iscritti as $array){
            if($array['id_corso_esame'] == $row['corso'] &&
            $array['id_docente_esame'] == $row['id_docente'] &&
            $array['id_attdid_esame'] == $row['id'] &&
            $array['ord_attdid_esame'] == $row['ordinamento']){
                $n_iscritti = $array['iscritti']; 
                break;
            }
        }
        $to_add = array_slice($row, 0, 10, true) + array('iscritti' => $n_iscritti) + array_slice($row, 10, count($row) - 1, true);
        array_push($data, $to_add); // inserisci in un array i dati
    }
    echo json_encode($data);
?>