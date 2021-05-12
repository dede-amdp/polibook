<!DOCTYPE html>
<html lang='ita'>

<head>
    <link href='../css/exams.css' rel='Stylesheet' type='text/css'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>


<body class='exams-body'>
<?php
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        $matricola = '000000'; //!! prendere da login
        $conn = open_conn();
        $query = 'SELECT * FROM studente WHERE matricola=?';
        $result = fetch_DB($conn, $query, $matricola);
        $conn -> close();
        echo '<p>';
        if($result && $row = mysqli_fetch_assoc($result)){
            echo 'Ciao <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</br>';
        }
        echo 'Qui puoi visualizzare gli appelli e gli esoneri ai quali puoi prenotarti o ai quali ti sei già prenotatə.</br>Puoi prenotarti selezionando uno qualunque degli esami nella tabella sottostante e puoi disinscriverti selezionando uno qualunque degli esami nella sezione <b>PRENOTATI</b></p>';
    ?>
    <div class='buttons'>
        <button id='prenotabili' class='prenotabili'>PRENOTABILI</button>
        <button id='prenotati' class='prenotati active'>PRENOTÀTI</button>
    </div>
    <div class='prenotabili' id='prenotabili-tab'></div>
    <div class='prenotati' id='prenotati-tab'></div>
</body>
<script src='../javascript/methods.js'></script>
<script src='../javascript/exams.js'></script>

</html>