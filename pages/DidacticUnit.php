<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Scelta questionari </title>
    <link href='../css/didacticUnit.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'
          descritpion='Questa sezione permette di selezionare i questionari delle unita didattiche'
          keywords='Questionari'>
</head>
<body class='didacticUnit'>
<?php
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        $matricola = '000000'; //!! prendere da login
        $conn = open_conn();
        $query = 'SELECT * FROM studente WHERE matricola=?';
        $result = fetch_DB($conn, $query, $matricola);
        $conn -> close();
        echo '<p>';
        /*if($result && $row = mysqli_fetch_assoc($result)){
            echo 'Questionar <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</br>';
            echo '<p>';
        }*/
        echo 'Scelta questionari di valutazione';
        echo '<p>';
    ?>
    <div class='text'>
        <p>Questa sezione permette di selezionare i questionari delle unita didattiche previste per la materia.</p>
        <p>Questionari di valutazione </p>
    </div>
    <table id='didactic-unit-table' class="table" borde = 2px>
        <tr><th>unità didattica</th><th>Docente</th><th>tipo attività</th><th>partizione</th><th>Stato</th></tr>
        <tr><td><a href=https://www.google.it>2633 - Automazione industriale</a></td><td>Agostino Marcello Mangini</td><td>Esercitazione</td><td>Nessun partizionamento</td><td>no</td>
        <tr><td><a href=https://www.google.it>2633 - Automazione industriale</a></td><td>Agostino Marcello Mangini</td><td>Lezione</td><td>Nessun partizionamento</td><td>no</td>
    </table>

</body>
</html>