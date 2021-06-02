<!-- FUNZIONE CHE GENERA UN ARRAY CONTENTE TUTTE LE INFO RICERCATE-->
<?php
require_once '../php/dbh.inc.php';

function getRisultati() {
    $conn= open_conn();
    $anno = mysqli_real_escape_string($conn,$_POST['anno']);
    $dipartimento = mysqli_real_escape_string($conn,$_POST['dipartimento']);
    $docente = mysqli_real_escape_string($conn,$_POST['docente']);
    $attDid = mysqli_real_escape_string($conn,$_POST['attDid']);
    $isAnnoValid =  filter_var( $anno, 
    FILTER_VALIDATE_REGEXP, [
        "options" => [ "regexp" => "/^[1-3]{1}$/i"
        ]
    ]
    );
    
    

    //dichiaro una variabile di tipo array che conterrà tutti i cdl e gli esami
    $risultati = array();

    //verifico che tutti i valori siano stati inseriti 
    if (isset($anno) || isset($dipartimento) || isset($docente) || isset($attDid)){
       
        
        $query = 'SELECT cdl.id as id_cdl, 
                         attivita_didattica.id as id_attdid, 
                         atticita_didattica.ordinamento as ord_attdid,
                         id_corso 
                  FROM   docente join esame on id = id_docente
                         join attivita_didattica on id_attdid = id and ord_attdid = ordinamento
                         join attdid_cdl on id = id_attdid and ordinamento = ord_attdid
                         join cdl on id_cdl = id
                         join facolta on id_facolta = id
                  WHERE  anno = ? and facolta.nome= ? and (docente.nome and docente.cognome) = ? and attivita_didattica.nome=?'; 

                  $risultati = fetch_DB($conn, $query, $anno, $dipartimento, $docente, $attDid);
    }

    else{

        //controllo che sia stato inserito l'anno 
        if ( isset($anno) || $isAnnoValid == true){
            //genero un vettore contenente gli id di tutte le attività didattiche di quell'anno
             $query = 'SELECT attivita_didattica.id, attivita_didattica.ordinamento, id_cdl
             FROM attivita_didattica join attdid_cdl on id = id_attdid and ordinamento = ord_attdid
             WHERE anno=?';
             $filter1 = fetch_DB($conn, $query , $anno);
             if($filter1 && $rows = mysqli_fetch_assoc($filter1)){
             //inserisco nell'array l'id delle attività didattiche
             foreach($rows as $row){
                array_push($risultati,$row);
             }
            }
        }

         //controllo che sia stato inserito un valore nella voce dipartimento così da filtrare ulteriormente la ricerca
         if(isset($dipartimento)){
            //genero un vettore che contiene tutte le info necessarie per i cdl
            $query = 'SELECT cdl.id, 
            FROM cdl join facolta on id_facolta = id 
            WHERE nome_facolta = ?';
            $cdl = fetch_DB($conn,$query,$dipartimento);
            if ($cdl && $rows= mysqli_fetch_assoc($cdl)){
                //controllo che l'array contente i risultati non sia vuoto così da effettuare un confronto con gli id del cdl di quel dipartimento e eliminarli
                if (!empty($risulati)){
                    foreach ($risulati as $risultato){
                        if(!$cdl['id']==$risultato['id_cdl']){
                            unset($risultati['id_cdl']);
                           }
                        }
                    }
              else {
                $query = 'SELECT attivita_didattica.id, attivita_didattica.ordinamento, id_cdl
                          FROM attivita_didattica join attdid_cdl on id = id_attdid and ordinamento = ord_attdid
                          WHERE id_cdl = ?';
                  $risultati= fetch_DB($conn,$query,$cdl['id_cdl']);
                  }
                 }
              }

            //controllo che sia stato inserito un valore nella voce docente 
            if (isset($docente)){
                //genero una variabile che contiene gli id dell'attività didattica di ciascun esame e il relativo docente
                $query = 'SELECT id_corso, id_attdid, ord_attdid
                          FROM docente join esame on id = id_docente 
                          WHERE (docente.nome  and docente.cognome) = ?';
                $esami = fetch_DB($conn,$query,$docente);
                
                if($esami && $rows = mysqli_fetch_assoc($esami)){
                   if(!empty($risultati)){
                   foreach ($risultati as $risultato){
                    if($risultato['id_attdid']==$esami['id_attdid'] && $risultato['ord_attdid']==$esami['ord_attdid']){
                        //inserisco un nuovo valore per ciascun array
                        array_merge($risultato, $esami['id_corso']);
                        unset($risultato['id_attdid'], $risulato['ord_attdid']);
                    }
                }
            }
            else {
                //se la variabile risultati è vuota allora vi metto le info necessarie
                foreach($esami as $esame){
                    array_push($risultati,$esame);

                }
            }
        }
    }

    //controllo che sia stato inserita l'attività didattica 
    if (isset($attDid)){
        $query = 'SELECT id_corso, id_cdl, attivita_didattica.id, attivita_didattica.ordinamento
                  FROM esami join attivita_didattica on id_attdid = id and ord_attdid = ordinamneto
                             join attdid_cdl on id = id_attdid as id_attdid and ordinamneto = ord_attdid as ord_attdid
                             join cdl on id_cdl on id as id_cdl 
                  WHERE attivita_didattica.nome =?';
        $attivita_didattiche = fetch_DB($conn, $query, $attDid);

        if ($attivita_didattiche && $rows=mysqli_fetch_assoc($attivita_didattiche)){
            if(!empty($risultati)){
                foreach($risultati as $risultato){
                  foreach($rows as $row){
                    if ($row['id_attdid']!=$risultato['id_attdid'] && $row['ord_attdid']!=$risultato['ord_attdid'] ){
                    unset($risultati['id_attdid'], $risultato['ord_attdid']);
                }
            }
            }
        }
        else {
            foreach($rows as $row){
                array_push($risultati,$row);
            }
        }
    }
}
$conn -> close();
return $risultati;
}

      


      

}//fine funzione 

?>
