<!DOCTYPE html>
<html lang='it'>

<head>
    <title> Segreteria </title>
    <link href='../css/secretariat.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' >
    <meta name="description" 
          content="Questa pagina permette di visualizzare i sevizi di segreteria del politecnico i bari">
</head>
<body class='secretariat'>
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
                echo '<p>Ciao <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'].'</font>:</p>';
            }
        }
    ?>
    <section aria-label="Analisi della carriera">
        <p>In questa sezione puoi accedere ai servizi di segreteria online offerti dal politecnico.</br>
            <b>NB: I servizi elencati non sono al momento disponibili ad eccezione di 'Visualizza Profilo'.</b></p>
        <!-- Lista di servizi offerti dal poliba -->
        <div class= 'options'>
        <b>
        <ul>
            <li><a href="../pages/profile.php">Visualizza Profilo</a></li>
            <li><a href="#">Iscrizioni</a></li>
            <li><a href="#">Test di ammissione/concorsi</a></li>
            <li><a href="#">Test di valutazione</a></li>
            <li><a href="#">Esami di Stato</a></li>
            <li><a href="#">Immatricolazione</a></li>
            <li><a href="#">Esoneri</a></li>
            <li><a href="#">Autocertificazione</a></li>
            <li><a href="#">Pagamenti</a></li>
            <li><a href="#">Certificati</a></li>
            <li><a href="#">Trasferimento</a></li>
            <li><a href="#">Chiusura Carriera</a></li>
            <li><a href="#">Collaborazioni Studentesche</a></li>
            <li><a href="#">Borse di Studio</a></li>
            <li><a href="#">Dichiarazione di Invalidità</a></li>
            <li><a href="#">Documenti d’identità</a></li>
            <li><a href="#">Richiesta Carta Enjoy</a></li>
            <li><a href="#">Mobilità Internazionale</a></li>
            <li><a href="#">Conseguimento titolo di studio</a></li>
        </ul>
        </b>
        </div>
    </section>
</body>
</html>