<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Esami </title>
    <link href='../css/exams.css' rel='Stylesheet' type='text/css'>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' >
    <meta name="description" 
          content="La pagina mostra gli appelli e gli esoneri ai quali ci si può prenotare">
</head>


<body class='exams-body'>
<?php
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        // !! VERIFICA LOGIN
        $matricola = '000000'; //!! prendere da login
        $conn = open_conn();
        if($conn){
            $query = 'SELECT * FROM studente WHERE matricola=?';
            $result = fetch_DB($conn, $query, $matricola);
            $conn -> close();
            if($result && $row = mysqli_fetch_assoc($result)){
                echo '<p>Ciao <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</p>';
            }
        }
    ?>
    <section aria-label="Analisi della carriera">
        <h4><span style="font-weight:normal;">La pagina mostra gli appelli e gli esoneri ai quali puoi prenotarti o ai quali ti sei già prenotatə.
                </br>Puoi prenotarti selezionando uno qualunque degli esami nella tabella sottostante e puoi disiscriverti selezionando uno qualunque degli esami nella sezione <b>PRENOTATI</b><span></h4>
        <div class='buttons'>
            <button id='prenotabili' class='prenotabili'>PRENOTABILI</button>
            <button id='prenotati' class='prenotati active'>PRENOTÀTI</button>
        </div>
        <div class='prenotabili' id='prenotabili-tab'></div>
        <div class='prenotati' id='prenotati-tab'></div>
    </section>
</body>
<script src='../javascript/methods.js'></script>
<script src='../javascript/exams.js'></script>

</html>