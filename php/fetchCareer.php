<?php
require_once '../php/dbh.inc.php';
session_start();

if (!isset($_SESSION['id'])){
    header('Location: ../index.php'); //rimanda alla pagina del login
}

$inputs = json_decode(file_get_contents('php://input'), true); //prende i dati inseriti durante la richiesta

if (isset($inputs['type'])){
    if ($inputs['type'] == 'A'){
    echo json_encode(getNonCaratterizzanti());
    }elseif ($inputs['type'] == 'B'){
    echo json_encode(getCaratterizzanti());    
    }elseif ($inputs['type'] == 'C'){
    echo json_encode(getSezioneC());
    }
}

function getExams(){
    $conn = open_conn();
    if(!$conn) return array(); //se la connessione al database non avviene non fare fermare lo script
    $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
    $query = 'SELECT id_cdl, percorso FROM studente WHERE matricola=?;';
    $result = fetch_DB($conn, $query,$matricola);
    $att_dids = array();
    $superati = array();
    if ($result && $cdl=mysqli_fetch_assoc($result)){
        $query = 'SELECT attivita_didattica.id, attivita_didattica.nome, attivita_didattica.SSD, attivita_didattica.cfu, attivita_didattica.ordinamento
                ,attdid_cdl.* FROM attivita_didattica JOIN attdid_cdl on id_attdid = id and ord_attdid = ordinamento WHERE (id_cdl=?) and (percorso=\'\' OR percorso = ?) ';
        $result = fetch_DB($conn,$query,$cdl['id_cdl'],$cdl['percorso']);
        while ($result && $row=mysqli_fetch_assoc($result)){
            $array = array_merge($row,['superato'=> false]); //false
            array_push($att_dids,$array);
        //assumo che tutti gli esami ottenuti non siano svolti così da poterli confrontare con quelli svolti in seguito
        }

        //prendo un array con le attività didattiche aventi suparato uguale a uno
        $query = 'SELECT * FROM frequentato WHERE matricola_studente = ? and superato = 1';
        $result = fetch_DB($conn,$query,$matricola);
        while ($result && $row=mysqli_fetch_assoc($result)){
            array_push($superati,$row);
        }

    }
    //correggo indicando se l'attività didattica è stata superata e ritono tutti gli esami
    foreach ($superati as $esameSuperato){
        for ($i=0;$i<count($att_dids);$i++){
            if ($esameSuperato['id_attdid_esame'] == $att_dids[$i]['id'] && $esameSuperato['ord_attdid_esame'] == $att_dids[$i]['ordinamento']){
                $att_dids[$i]['superato'] = true;
                break;
            }
        }
    }
    $conn -> close();
    return $att_dids;
}

// funzione che mi ritona tutti gli esami caratterizzanti 
function getCaratterizzanti(){
    $esami = getExams();
    $caratterizzanti = array();
    foreach($esami as $esame ){
        $condizione = $esame['id'] == 'TESILT' || $esame['id'] == 'TESILM' || $esame['id'] == 'TIROCINIO' || strpos($esame['id'],'LINGUA') != false; 
        if ($esame['caratterizzante'] && !$condizione){
            array_push($caratterizzanti,$esame);
        }
    }
    return $caratterizzanti;
}

//funzione per ritornare i non caratterizzanti 
function getNonCaratterizzanti(){
    $esami = getExams();
    $non_caratterizzanti = array();
    foreach($esami as $esame ){
        $condizione = $esame['id'] == 'TESILT' || $esame['id'] == 'TESILM' || $esame['id'] == 'TIROCINIO' || strpos($esame['id'],'LINGUA') != false; 
        if (!$esame['caratterizzante'] && !$condizione){
            array_push($non_caratterizzanti,$esame);
        }
    }
    return $non_caratterizzanti;
}

//prendere le tesi, tirocinio e alle lingue => si stabilisce che tali esami abbiano dei codici speciali per le tesi sono TESILM e TESILT, per lingue che iniziano con LINGUA---, il tirocinio che inizia con TIROCINIO
function getSezioneC(){
    $esami = getExams();
    $sez = array();
    foreach($esami as $esame ){
        $condizione = $esame['id'] == 'TESILT' || $esame['id'] == 'TESILM' || $esame['id'] == 'TIROCINIO' || strpos($esame['id'],'LINGUA') != false; 
        if ($condizione){
            array_push($sez,$esame);
        }
    }
    return $sez;
}

?>