<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Scelta questionari </title>
    <link href='../css/didacticUnit.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' >
    <meta name="description" 
          content="Questa sezione permette di selezionare i questionari delle unita didattiche">
</head>
<body class='didacticUnit'>
<?php
        session_start();
        if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non ha eseguito il login torna alla pagina di login
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        $matricola = $_SESSION['matricola'];
        $conn = open_conn();
        $query = 'SELECT nome, cognome FROM studente WHERE matricola=?';
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
    <section aria-label="Analisi della carriera">
        <div class='text'>
        <h4><span style="font-weight:normal;">Questa sezione permette di selezionare i questionari delle unità didattiche previste per la materia. </span></h4>
            <p>Questionari di valutazione </p>
        </div>
        <table id='didactic-unit-table' class="table" borde = 2px>
            <tr><th>unità didattica</th><th>Docente</th><th>tipo attività</th><th>partizione</th><th>Stato</th></tr>
            <tr><td><a href=https://www.google.it>2633 - Automazione industriale</a></td><td>Agostino Marcello Mangini</td><td>Esercitazione</td><td>Nessun partizionamento</td><td>no</td>
            <tr><td><a href=https://www.google.it>2633 - Automazione industriale</a></td><td>Agostino Marcello Mangini</td><td>Lezione</td><td>Nessun partizionamento</td><td>no</td>
        </table>
    </section>
</body>
</html>