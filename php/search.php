<?php
//<!-- FUNZIONE CHE GENERA UN ARRAY CONTENETE TUTTE LE INFO RICERCATE-->
echo json_encode(getRisultati());

function getRisultati() {
    require_once '../php/dbh.inc.php';
    $conn= open_conn();
    if($conn){
        $inputs = json_decode(file_get_contents('php://input'), true);
        $anno = mysqli_real_escape_string($conn,$inputs['anno']);
        $dipartimento = mysqli_real_escape_string($conn,$inputs['dipartimento']);
        $docente = mysqli_real_escape_string($conn,$inputs['docente']);
        $attDid = mysqli_real_escape_string($conn,$inputs['attDid']);
        $isAnnoValid =  filter_var( $anno, 
        FILTER_VALIDATE_REGEXP, [
            "options" => [ "regexp" => "/^[1-3]{1}$/i"
            ]
        ]
        );
        
        //dichiaro una variabile di tipo array che conterrà tutti i cdl e gli esami
        $risultati = array();

        //verifico che almeno uno dei valori sia stato inserito per effettuare la ricerca
        if (isset($anno) || isset($dipartimento) || isset($docente) || isset($attDid)){
            $query = 'SELECT cdl.id as id_cdl, 
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
                                        esame.id_docente = docente.id 
                    WHERE anno = ? OR 
                        facolta.nome = ? OR 
                        CONCAT(docente.nome, docente.cognome) = ? OR 
                        CONCAT(docente.cognome, docente.nome) = ? OR 
                        attivita_didattica.nome = ?';
        
        $risultati = fetch_DB($conn, $query, $anno, $dipartimento, $docente, $docente, $attDid);
        $data = array();
        while($risultati && $row = mysqli_fetch_assoc($risultati)){
            array_push($data, $row);
        }
        $conn -> close();
        return $data;
    }else{
        return null;
    }
}

   
}//fine funzione 

?>
