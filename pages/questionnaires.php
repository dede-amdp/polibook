<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Valutazione didattica </title>
    <link href='../css/questionnaires.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' >
    <meta name="description" 
          content="Questa pagina permette di visualizzare i questionari delle attività didattiche a cui si è iscritti">
    <?php
        session_start();
        if(isset($_SESSION['error_msg'])){ // se contiene un messaggio
            $message = $_SESSION['error_msg'];
            unset($_SESSION['error_msg']); // togle il messaggio dalla sessione
            echo "<script type='text/javascript'>window.onload = function() {alert('$message');};</script>"; // mostra il messaggio in alto
        }
    ?>
</head>
<body class='questionnaires'>
<?php
        if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non ha eseguito il login torna alla pagina di login
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        $matricola = $_SESSION['matricola']; //!! prendere da login
        $conn = open_conn();
        $query = 'SELECT nome, cognome FROM studente WHERE matricola=?';
        $result = fetch_DB($conn, $query, $matricola);
        $conn -> close();
        echo '<p>';
        if($result && $row = mysqli_fetch_assoc($result)){
            echo 'Valutazione della didattica <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</br>';
        }
        echo '<p>';
    ?>

    <section aria-label="Questionari">
        <div class='text'>
            <p>Questa pagina consente di compilare il questionario di valutazione della didattica.</p>
            <h4><span style="font-weight:normal;">Elenco Attività didattiche da valutare </span></h4>
        </div>
        <div id='questionnaires-div'>
        <table id='questionnaires-table' class="table" border = 2px>
            <tr><th>Anno di corso</th><th>Attivita didattica</th><th>Peso in crediti</th><th>Docente</th><th>Compilato</th></tr>
        </table>
        </div>
    </section>
</body>
<script src='../javascript/methods.js'></script>
<script src='../javascript/questionnaires.js'></script>
</html>