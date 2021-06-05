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
            if($result && $row = mysqli_fetch_assoc($result)){
                echo '<p>Ciao <span class = "evidenziato">'.$row['nome'].' '.$row['cognome'].'</span>:</p>';
            }
        }
    ?>
    <section aria-label="Analisi della carriera">
        <h4><span style="font-weight:normal;">La pagina mostra gli appelli e gli esoneri ai quali puoi prenotarti o ai quali ti sei già prenotatə.
                <br>Puoi prenotarti selezionando uno qualunque degli esami nella tabella sottostante e puoi disiscriverti selezionando uno qualunque degli esami nella sezione <b>PRENOTATI</b>
            </span>
        </h4>
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