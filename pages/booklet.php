<!DOCTYPE html>
<html lang='it'>

<head>
    <title>Libretto</title>
    <link href='../css/booklet.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' > <!-- serve per far si che su uno schermo più piccolo appaia a dimensioni sensate-->
    <meta name="description" 
          content="Questa pagina permette di vedere tutti gli esami superati e la media di laurea">
</head>

<body class='booklet'>
    <?php
        session_start();
        if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non ha eseguito il login torna alla pagina di login
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        $conn = open_conn();
        if($conn){
            $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']); // prende la matricola dalla $_SESSION
            $query = 'SELECT nome, cognome FROM studente WHERE matricola=?';
            $result = fetch_DB($conn, $query, $matricola);
            $conn -> close();
            if($result && $row = mysqli_fetch_assoc($result)){
                echo '<p>Ciao <span class = "evidenziato">'.$row['nome'].' '.$row['cognome'].'</span>:</p>';
            }
        }
    ?>
    <section aria-label="Grafici esami">
    <h4><span style="font-weight:normal;">questo è il <b>libretto</b>, qui potrai vedere i risultati degli esami che hai superato e gli esami ancora da superare</span></h4>
    <p id='statistics' class='statistics'></p>
        <div id ="Grafici" class='graphs'>
            <canvas id='grade-canvas'>Questo Elemento mostra l'andamento dei tuoi voti</canvas>
            <canvas id='cfu-canvas'>Questo Elemento mostra l'andamento dei tuoi CFU</canvas>
        </div>
    </section>
    <section aria-label="Lista esami">
        <div class='buttons'>
            <button id='superati' class='superati'>SUPERATI</button>
            <button id='pianificati' class='pianificati active'>PIANIFICATI</button>
        </div>
        <div class='superati' id='superati-tab'></div>
        <div class='pianificati' id='pianificati-tab'></div>
    </section>
</body>
<script src='../javascript/drawOnCanvas.js'></script>
<script src='../javascript/methods.js'></script>
<script src='../javascript/booklet.js'></script>
</html>