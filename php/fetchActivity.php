<?php 
require_once '../php/dbh.inc.php';
$conn = open_conn();
if($conn){
    $attDid = array();
    $inputs = json_decode(file_get_contents('php://input'), true);
    $query = 'SELECT attivita_didattica.*, 
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
                    docente.id =?';

    $result = fetch_DB($conn, $query, $inputs['atd'], $inputs['ord'], $inputs['cdl'], $inputs['doc']);
    if ($result && $row=mysqli_fetch_array($result)){
        array_push($attDid, $row);
    }
    $conn -> close();
    echo json_encode($attDid);
}else{
    echo json_encode(null);
}

?>