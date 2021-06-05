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
                echo '<p>Ciao <span class="evidenziato">'.$row['nome'].' '.$row['cognome'].'</span>:</p>';
            }
        }
    ?>
    <main>
    <section aria-label="Analisi della carriera">
        <p>In questa sezione puoi accedere ai servizi di segreteria online offerti dal politecnico.<br>
            <b>NB: I servizi elencati non sono al momento disponibili ad eccezione di 'Visualizza Profilo'.</b></p>
        <!-- Lista di servizi offerti dal poliba -->
        <div class= 'options'>
        <ul>
                <a href="../pages/profile.php"><li><b>Visualizza Profilo</b></li></a>
                <a href="#"><li><b>Iscrizioni</b></li></a>
                <a href="#"><li><b>Test di ammissione/concorsi</b></li></a>
                <a href="#"><li><b>Test di valutazione</b></li></a>
                <a href="#"><li><b>Esami di Stato</b></li></a>
                <a href="#"><li><b>Immatricolazione</b></li></a>
                <a href="#"><li><b>Esoneri</b></li></a>
                <a href="#"><li><b>Autocertificazione</b></li></a>
                <a href="#"><li><b>Pagamenti</b></li></a>
                <a href="#"><li><b>Certificati</b></li></a>
                <a href="#"><li><b>Trasferimento</b></li></a>
                <a href="#"><li><b>Chiusura Carriera</b></li></a>
                <a href="#"><li><b>Collaborazioni Studentesche</b></li></a>
                <a href="#"><li><b>Borse di Studio</b></li></a>
                <a href="#"><li><b>Dichiarazione di Invalidità</b></li></a>
                <a href="#"><li><b>Documenti d’identità</b></li></a>
                <a href="#"><li><b>Richiesta Carta Enjoy</b></li></a>
                <a href="#"><li><b>Mobilità Internazionale</b></li></a>
                <a href="#"><li><b>Conseguimento titolo di studio</b></li></a>
        </ul>
        </div>
    </section>
    </main>
</body>
</html>