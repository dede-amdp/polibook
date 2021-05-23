<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Valutazione didattica </title>
    <link href='../css/questionnaires.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' >
    <meta name="description" 
          content="Questa pagina permette di visualizzare i questionari delle attività didattiche a cui si è iscritti">
</head>
<body class='questionnaires'>
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
            echo 'Valutazione della didattica <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</br>';
        }
        echo '<p>';
    ?>

    <section aria-label="Analisi della carriera">
        <div class='text'>
            <p>Questa pagina consente di compilare il questionario di valutazione della didattica.</p>
            <h4><span style="font-weight:normal;">Elenco Attività didattiche da valutare </span></h4>
        </div>
        <table id='questionnaires-table' class="table" borde = 2px>
            <tr><th>Anno di corso</th><th>Attivita didattica</th><th>Peso in crediti</th><th>Docente</th><th>Complilato</th></tr>
            <tr><td>3</td><td><a href=http://localhost/polibook/pages/didacticUnit.php> 2633 - Automazione industriale </a></td><td>6</td><td>2020/2021</td><td>si</td>
        </table>
    </section>
=======
    <div class='text'>
        <p>Questa pagina consente di compilare il questionario di valutazione della didattica.</p>
        <p>Elenco Attività didattiche da valutare </p>
    </div>
    <table id='questionnaires-table' class="table" border = 2px>
        <tr><th>Anno di corso</th><th>Attivita didattica</th><th>Peso in crediti</th><th>Anno frequentazione</th><th>Stato</th></tr>
        <tr><td>3</td><td><a href=http://localhost/polibook/pages/didacticUnit.php> 2633 - Automazione industriale </a></td><td>6</td><td>Agostino Marcello Mangini</td><td>si</td>
        
    </table>

>>>>>>> 5af5c232c96377c0d3fdcb23588cb04d7d0adab5
</body>
</html>