<!DOCTYPE html>
<html>
<head>
    <link href='../css/career.css' type='text/css' rel='Stylesheet'/>
    <meta />
</head>

<body class="career">
    <?php
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        $matricola = '000000'; //!! prendere da login
        $conn = openConn();
        $query = 'SELECT * FROM studente WHERE matricola=?';
        $result = fetchDB($conn, $query, $matricola);
        $conn -> close();
        if($result && $row = mysqli_fetch_assoc($result)){
            echo '<p> Analisi della carriera di: <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font></br>';
        }
    ?>
    <div class="text">
       <p> Analisi della carrira di: Daniele Corrado </p>
    <p> Questa pagina visualizza la situazione dello studente in relazione alle regole previste dal percorso formativo intrapreso nell'ateneo.<br>
        Ogni riga nella tabella rappresenta un certo tipo di crediti che lo studente deve ottenere mediante le attività didattiche. <br>
        Quando tutti i crediti richiesti sono ottenuti, lo studente può conseguire il titolo previsto dal corso di studio.
    </p>
    </div> 
    <!-- !! aggiungere metodo che inserica il totale dei CFU per ogni categoria,
                aggiungere controllo per il numero di CFU mancanti,
                aggiungere controllo per completamento categoria (check)
                aggiungere le categorie specifiche per il CdL  -->
    <table class="table" border = 2px>
        <tr><th>Regola</th><th>CFU Min</th><th>CFU Max</th><th>CFU Calcolati</th><th>CFU Validati</th><th>CFU Mancanti</th><th>Esito</th></tr>
       
        <tr><td>TOTALE CFU</td><td>180</td><td>999</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>A - Base</td><td>42</td><td>78</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Matematica, informatica e statistica</td><td>30</td><td>48</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Fisica e chimica</td><td>12</td><td>30</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>B - Caratterizzante</td><td>45</td><td>138</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Caratterizzante 1</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Caratterizzante 2</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Caratterizzante 3</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td>Caratterizzante 4</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td>C - attività formative affini o integrative</td><td>18</td><td>30</td><td></td><td></td><td></td><td></td></tr> 
        <tr><td>D - A scelta dello studente</td><td>12</td><td>18</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>E - lingua</td><td>3</td><td>3</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>F - Abilità informatiche e telematiche</td><td>6</td><td>6</td><td></td><td></td><td></td><td></td></tr>
        <tr><td>G - Stage e tirocini</td><td>0</td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td>H - Prova finale</td><td>3</td><td>3</td><td></td><td></td><td></td><td></td></tr>
    </table>
    </body>
</html>
