<?php
    require_once '../php/dbh.inc.php';
    $conn = open_conn();
    if($conn){
        $cdl = array();
        $inputs = json_decode(file_get_contents('php://input'), true);
        $query = 'SELECT cdl.*, facolta.id as id_facolta, facolta.nome as nome_facolta
                    FROM  cdl join facolta ON id_facolta=facolta.id
                    WHERE  cdl.id = ?;';
        $result = fetch_DB($conn, $query, $inputs['cdl']); 
        if ($result && $row=mysqli_fetch_array($result)){
            array_push($cdl,$row);
        }

        $query = 'SELECT attivita_didattica.id, 
                        attivita_didattica.ordinamento, 
                        attivita_didattica.cfu, 
                        attivita_didattica.nome,
                        attdid_cdl.*
         FROM attivita_didattica join attdid_cdl ON id=id_attdid WHERE id_cdl = ? ORDER BY ordinamento;';
        $result = fetch_DB($conn, $query, $inputs['cdl']); 
        $programma = array();
        while ($result && $row=mysqli_fetch_array($result)){
            array_push($programma,$row);
        }
        $cdl['programma'] = $programma;
        $conn -> close();
        echo json_encode($cdl);
    }else{
        echo json_encode(null);
    }
?>