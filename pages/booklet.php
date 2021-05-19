<!DOCTYPE html>
<html>

<head>
    <title>Libretto</title>
    <link href='../css/booklet.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'> <!-- serve per far si che su uno schermo più piccolo appaia a dimensioni sensate-->
</head>

<body class='booklet'>
    <?php
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        // !! VERIFICA LOGIN
        $matricola = '000000'; //!! prendere da login
        $conn = open_conn();
        if($conn){
            $query = 'SELECT * FROM studente WHERE matricola=?';
            $result = fetch_DB($conn, $query, $matricola);
            $conn -> close();
            if($result && $row = mysqli_fetch_assoc($result)){
                echo '<p>Ciao <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</p>';
            }
        }
    ?>
    <p>questo è il <b>libretto</b>, qui potrai vedere i risultati degli esami che hai superato e gli esami ancora da superare</p>
    <p id='statistics' class='statistics'></p>
    <div class='graphs'>
        <canvas id='grade-canvas'>Questo Elemento mostra l'andamento dei tuoi voti</canvas>
        <canvas id='cfu-canvas'>Questo Elemento mostra l'andamento dei tuoi cfu</canvas>
    </div>
    <div class='buttons'>
        <button id='superati' class='superati'>SUPERATI</button>
        <button id='pianificati' class='pianificati active'>PIANIFICATI</button>
    </div>
    <div class='superati' id='superati-tab'></div>
    <div class='pianificati' id='pianificati-tab'></div>
</body>
<script src='../javascript/drawOnCanvas.js'></script>
<script src='../javascript/methods.js'></script>
<script src='../javascript/booklet.js'></script>
</html>