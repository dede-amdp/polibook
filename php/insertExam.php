<?php
/* Inserisce nella tabella 'risultato' del database i dati indicati in $table*/
    require_once './dbh.inc.php';
    $inputs = json_decode(file_get_contents('php://input'), true);
    $matricola = $inputs['matricola'];
    $id = explode(',',$inputs['dataString']);
    $conn = open_conn();
    $table = 'risultato (data_iscrizione, matricola_studente, id_corso_esame_appello, id_attdid_esame_appello, id_docente_esame_appello, ord_attdid_esame_appello, data_svolgimento_appello)';
    $result = insert_DB($conn, $table, date('Y-m-d'), $matricola, ...$id);
    $conn ->close();
    if($result) echo json_encode('\nResult: '.$result);
    else echo json_encode('Fail');
?>