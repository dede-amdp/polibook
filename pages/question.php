<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Questionaro </title>
    <link href='../css/questionnaires.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'
          description='Questa pagina permette di rispondere alle domando del questionario selezionato'
          keywords='Questionario risposte utente'>
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

</body>
</html>