<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Risultati esami </title>
    <link href='../css/examResult.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' content='width=device-width, initial-scale=1.0' 
          desctipion= 'la pagina mostra  i risultati degli esami a cui ci si è iscritti'
          keywords ='esami'>
</head>
<body class='examResult'>
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
            echo 'Risultati degli esami di <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</br>';
        }
        echo '<p>';
    ?>
    <div class='text'>
        <p>La pagina mostra gli appelli già sostenuti per i quali è stato assegnato un esito da parte del docente.<br> 
           Per accedere alla funzione di verbalizzazione on-line cliccare l'icona mostrata a fianco di ogni esito.</p>
        <p>Elenco esami superato </p>
    </div>
    <table id='exam-result-table' class="table" borde = 2px>
        <tr><th>ID</th><th>Attivita didattica</th><th>Data svolgimento</th><th>Data verbalizzazione</th><th>risultato</th></tr>
        <tr><td>2633</td><td><a href=http://localhost/polibook/pages/didacticUnit.php>Automazione industriale </a></td><td>25/06/2021</td><td>25/07/2021</td><td>20</td>
        
    </table>

</body>
</html>