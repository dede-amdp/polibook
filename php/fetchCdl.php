<?php
    require_once '../php/dbh.inc.php';
    $conn = open_conn();
    if($conn){
        $cdl = array();
        $inputs = json_decode(file_get_contents('php://input'), true); // prendo gli input
        if(isset($inputs['cdl'])){
            $cdl_input = mysqli_real_escape_string($conn, $inputs['cdl']);
            // prendo i dati di cdl e facoltà
            $query = 'SELECT cdl.*, facolta.id as id_facolta, facolta.nome as nome_facolta
                        FROM  cdl join facolta ON id_facolta=facolta.id
                        WHERE  cdl.id = ?;';
            $result = fetch_DB($conn, $query, $cdl_input); // eseguo la query
            if ($result && $row=mysqli_fetch_array($result)){
                array_push($cdl,$row);
            }

            $query = 'SELECT attivita_didattica.id, 
                            attivita_didattica.ordinamento, 
                            attivita_didattica.cfu, 
                            attivita_didattica.nome,
                            attdid_cdl.*
            FROM attivita_didattica join attdid_cdl ON id=id_attdid WHERE id_cdl = ? ORDER BY ordinamento;';
            $result = fetch_DB($conn, $query, $inputs['cdl']); // prendo tutti gli esami che appartengono al cdl
            $programma = array();
            while ($result && $row=mysqli_fetch_array($result)){
                array_push($programma,$row); 
            }
            $cdl['programma'] = $programma; // metto i dati in coda con chiave 'programma'
            $conn -> close();
            echo json_encode($cdl);
        }else echo json_encode(null);
    }else{
        echo json_encode(null);
    }
?>