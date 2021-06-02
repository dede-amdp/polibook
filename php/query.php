<?php
//per attdid mi passa id e ordinamento id cdl e id docente
//restituisce tutti i dati dell'att did, id e nome del cdl e nome e cognome del docente e tutte le informazioni generali contenute in attdid_cdl

//per il cdl mi passa id_cdl
//id facolta e nome  e poi tutte le info generali di cdl 
//tutte le attività didattiche del cdl con i relativi nomi ed ordinamneti 

//dichiaro una variabile di tipo arry che conterrà tutte le info delle attività didattiche


//dichiaro una variabile di tipo array che conterrà tutte le info del cdl
$cdl = array();
$query2 = 'SELECT cdl.*, attdid_cdl.*, cfu,
                  attivita_didattica.nome as nome_attdid,
                  attivita_didattica.id as id_attdid,
                  attivita_didattica.ordinamento as ord_attdid,
                  facolta.id as id_facolta,
                  facolta.nome as nome_facolta

          FROM  attivita_didattica join attdid_cdl join cdl
                on attivita_didattica.id = attdid_cdl.id_attdid  and attivita_didattica.ordinamento = attdid_cdl.ord_attdid 
                on attdid_cdl.id_cdl = cdl.id
         WHERE  cdl.id = ?
         GROUP BY ord_attdid ';
$result = fetch_DB($conn, $query2, $id_cdl); 
if ($result && $row=mysqli_fetch_array($result)){
    array_push($cdl,$row);
}
echo json_encode($cdl)

?>