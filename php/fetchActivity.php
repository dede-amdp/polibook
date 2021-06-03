<?php 
require_once '../php/dbh.inc.php';
$conn = open_conn();
if($conn){
    $attDid = array();
    // prendi i dati in input
    $inputs = json_decode(file_get_contents('php://input'), true);
    $atd = mysqli_real_escape_string($conn, $inputs['atd']);
    $ord = mysqli_real_escape_string($conn, $inputs['ord']);
    $cdl = mysqli_real_escape_string($conn, $inputs['cdl']);
    $query = '';
    $result = null;
    if(isset($atd) && isset($ord)){
        if(isset($inputs['doc'])){
            // query nel caso ho il docente
            $doc = mysqli_real_escape_string($conn, $inputs['doc']);
            $query = 'SELECT attivita_didattica.id, 
                            attivita_didattica.ordinamento, 
                            attivita_didattica.cfu, 
                            attivita_didattica.nome, 
                            attivita_didattica.descrizione,
                            attdid_cdl.*,
                            cdl.nome as nome_cdl, 
                            docente.nome as nome_docente, 
                            docente.cognome as cognome_docente

                    FROM  attivita_didattica join attdid_cdl join cdl join esame join docente
                            ON attivita_didattica.id = attdid_cdl.id_attdid  and attivita_didattica.ordinamento = attdid_cdl.ord_attdid 
                            AND attdid_cdl.id_cdl = cdl.id 
                            AND attivita_didattica.id = esame.id_attdid  and attivita_didattica.ordinamento = esame.ord_attdid
                            AND esame.id_docente = docente.id
                    WHERE attivita_didattica.id=? AND 
                            attivita_didattica.ordinamento=? AND 
                            cdl.id = ? AND
                            docente.id =?;';

            $result = fetch_DB($conn, $query, $atd, $ord, $cdl, $doc);
        }else{
            // query nel caso in cui non ho il docente
            $query = 'SELECT attivita_didattica.id, 
                            attivita_didattica.ordinamento, 
                            attivita_didattica.cfu, 
                            attivita_didattica.nome, 
                            attivita_didattica.descrizione, 
                            attdid_cdl.*,
                            cdl.nome as nome_cdl

                    FROM  attivita_didattica join attdid_cdl join cdl join esame
                            ON attivita_didattica.id = attdid_cdl.id_attdid  and attivita_didattica.ordinamento = attdid_cdl.ord_attdid 
                            AND attdid_cdl.id_cdl = cdl.id 
                            AND attivita_didattica.id = esame.id_attdid  and attivita_didattica.ordinamento = esame.ord_attdid
                    WHERE attivita_didattica.id=? AND 
                            attivita_didattica.ordinamento=? AND 
                            cdl.id = ?;';
            $result = fetch_DB($conn, $query, $atd, $ord, $cdl);
        }
        if ($result && $row=mysqli_fetch_array($result)){
            array_push($attDid, $row);
        }
        $conn -> close();
        echo json_encode($attDid); // ritorna i risultati
    }else echo json_encode(null);
}else{
    echo json_encode(null);
}

?>