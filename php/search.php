<?php
//<!-- FUNZIONE CHE GENERA UN ARRAY CONTENETE TUTTE LE INFO RICERCATE-->
echo json_encode(getRisultati());

function getRisultati() {
    require_once '../php/dbh.inc.php';
    $conn= open_conn();
    if($conn){
        $inputs = json_decode(file_get_contents('php://input'), true);
        $anno = mysqli_real_escape_string($conn, $inputs['anno']);
        $dipartimento = mysqli_real_escape_string($conn, $inputs['dipartimento']);
        $docente = mysqli_real_escape_string($conn, $inputs['docente']);
        $attDid = mysqli_real_escape_string($conn, $inputs['attDid']);
        $cdl = mysqli_real_escape_string($conn, $inputs['cdl']);
        
        //dichiaro una variabile di tipo array che conterrà tutti i cdl e gli esami
        $risultati = array();

        //verifico che almeno uno dei valori sia stato inserito per effettuare la ricerca
        if (isset($anno) || isset($dipartimento) || isset($docente) || isset($attDid) || isset($cdl)){
            $tabellone = 'SELECT cdl.id as id_cdl, 
                            id_corso,
                            attivita_didattica.id,
                            ordinamento,
                            docente.id as id_docente,
                            facolta.id as id_facolta,
                            cfu,
                            docente.nome as nome_docente,
                            docente.cognome as cognome_docente,
                            facolta.nome as nome_facolta,
                            attivita_didattica.nome as nome_attdid,
                            cdl.nome as nome_cdl
                            FROM attdid_cdl JOIN attivita_didattica 
                                            JOIN esame 
                                            JOIN facolta 
                                            JOIN cdl 
                                            JOIN docente 
                                            ON attivita_didattica.id = attdid_cdl.id_attdid AND
                                                attivita_didattica.ordinamento = attdid_cdl.ord_attdid AND 
                                                attdid_cdl.id_cdl = cdl.id AND
                                                cdl.id_facolta = facolta.id AND 
                                                esame.id_attdid = attivita_didattica.id AND 
                                                esame.ord_attdid = attivita_didattica.ordinamento AND 
                                                esame.id_docente = docente.id ';
        $query_ord = 'LOWER(ordinamento) = LOWER(?)'; 
        $query_dip = 'LOWER(facolta.nome) = LOWER(?)';
        $query_doc = 'LOWER(CONCAT(docente.nome, docente.cognome)) = LOWER(?)  OR
                        LOWER(CONCAT(docente.cognome, docente.nome)) = LOWER(?)';
        $query_attdid = 'LOWER(attivita_didattica.nome) = LOWER(?)';
        $query_cdl = 'LOWER(cdl.nome) = LOWER(?)';
        $query = '';
        $vals = array();
        //costruisco la query
        if ($anno != ''){
            if(strlen($query) <= 0){
                $query = $tabellone.' WHERE '.$query_ord;
            }else{
                $query .= ' INTERSECT ('.$tabellone.' WHERE '.$query_ord.')';
            }
            array_push($vals, $anno);
        }
        if ($dipartimento != ''){
            if(strlen($query) <= 0){
                $query = $tabellone.' WHERE '.$query_dip;
            }else{
                $query .= ' INTERSECT ('.$tabellone.' WHERE '.$query_dip.')';
            }
            array_push($vals, $dipartimento);
        }
        if ($docente != ''){
            if(strlen($query) <= 0){
                $query = $tabellone.' WHERE '.$query_doc;
            }else{
                $query .= ' INTERSECT ('.$tabellone.' WHERE '.$query_doc.')';
            }
            array_push($vals, $docente, $docente);
        }
        if ($attDid != ''){
            if(strlen($query) <= 0){
                $query = $tabellone.' WHERE '.$query_attdid;
            }else{
                $query .= ' INTERSECT ('.$tabellone.' WHERE '.$query_attdid.')';
            }
            array_push($vals, $attDid);
        }
        if ($cdl != ''){
            if(strlen($query) <= 0){
                $query = $tabellone.' WHERE '.$query_cdl;
            }else{
                $query .= ' INTERSECT ('.$tabellone.' WHERE '.$query_cdl.')';
            }
            array_push($vals, $cdl);
        }
        // eseguo la query
        $risultati = fetch_DB($conn, $query, ...$vals);
        $data = array();
        while($risultati && $row = mysqli_fetch_assoc($risultati)){
            array_push($data, $row);
        }

        if (isset($cdl) || isset($dipartimento)){
            $query = 'SELECT facolta.nome as nome_facolta,
                                cdl.nome as nome_cdl,
                                facolta.id as id_facolta,
                                cdl.id as id_cdl
                        FROM cdl JOIN facolta ON id_facolta = facolta.id WHERE LOWER(cdl.nome)=LOWER(?) OR LOWER(facolta.nome) = LOWER(?);';
            $risultati = fetch_DB($conn, $query, $cdl, $dipartimento);
            while($risultati && $row = mysqli_fetch_assoc($risultati)){
                array_push($data, $row);
            }
        }
        $conn -> close();
        return $data;
    }else{
        return null;
    }
}

   
}//fine funzione 

?>
