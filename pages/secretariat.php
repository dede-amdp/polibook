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
            <a href="../pages/profile.php"><li>Visualizza Profilo</li></a>
            <a href="#"><li>Iscrizioni</li></a>
            <a href="#"><li>Test di ammissione/concorsi</li></a>
            <a href="#"><li>Test di valutazione</li></a>
            <a href="#"><li>Esami di Stato</li></a>
            <a href="#"><li>Immatricolazione</li></a>
            <a href="#"><li>Esoneri</li></a>
            <a href="#"><li>Autocertificazione</li></a>
            <a href="#"><li>Pagamenti</li></a>
            <a href="#"><li>Certificati</li></a>
            <a href="#"><li>Trasferimento</li></a>
            <a href="#"><li>Chiusura Carriera</li></a>
            <a href="#"><li>Collaborazioni Studentesche</li></a>
            <a href="#"><li>Borse di Studio</li></a>
            <a href="#"><li>Dichiarazione di Invalidità</li></a>
            <a href="#"><li>Documenti d’identità</li></a>
            <a href="#"><li>Richiesta Carta Enjoy</li></a>
            <a href="#"><li>Mobilità Internazionale</li></a>
            <a href="#"><li>Conseguimento titolo di studio</li></a>
        </ul>
        </b>
        </div>
    </section>
</body>
</html>