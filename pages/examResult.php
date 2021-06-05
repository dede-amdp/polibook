<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Risultati esami </title>
    <link href='../css/examResult.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' >
    <meta name="description" 
          content="la pagina mostra  i risultati degli esami a cui ci si è iscritti">
</head>
<body class='examResult'>
<?php
        session_start();
        if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non ha eseguito il login torna alla pagina di login
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        $matricola = $_SESSION['matricola'];
        $conn = open_conn();
        if($conn){
            $query = 'SELECT nome, cognome FROM studente WHERE matricola=?';
            $result = fetch_DB($conn, $query, $matricola);
            $conn -> close();
            echo '<p>';
            if($result && $row = mysqli_fetch_assoc($result)){
                echo 'Risultati degli esami di <span class= "evidenziato">'.$row['nome'].' '.$row['cognome'].'</span>:<br>';
            }
            echo '<p>';
        }
    ?>
    <section aria-label="Analisi della carriera">
        <div class='text'>
            <h4><span style="font-weight:normal;">La pagina mostra gli appelli già sostenuti per i quali è stato assegnato un esito da parte del docente.<br> 
            Per accedere alla funzione di verbalizzazione on-line cliccare il nome dell'attività didattica.</span></p>
            <p>Elenco esami superati </p>
        </div>
        <div id='exam-result-div'>
            <table id='exam-result-table' class="table" borde = 2px>
                <tr><th>ID</th><th>Attivita didattica</th><th>Data svolgimento</th><th>Data verbalizzazione</th><th>risultato</th></tr>
            </table>
        </div>
    </section>

</body>
<script src='../javascript/methods.js'></script>
<script src='../javascript/results.js'></script>
</html>