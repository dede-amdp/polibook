<!DOCTYPE html> 
<html lang = 'it'>
<head>
    <title> Dashboard </title>
    <link href = '../css/dashboard.css' type='text/css' rel='Stylesheet'/>
    <meta name = 'viewport' 
          content = 'width=device-width, initial-scale=1.0' >
    <meta name = "description" 
          content = "Questa pagina visualizza i messaggi di avviso per l'utente">
</head>

<body class= 'dashboard'>
    
    <?php
        session_start();
        if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non ha eseguito il login torna alla pagina di login
        include '../sidenav.html';
        require_once '../php/dbh.inc.php';
        $conn = open_conn();
        if($conn){
            $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
            $query = 'SELECT nome, cognome FROM studente WHERE matricola=?';
            $result = fetch_DB($conn, $query, $matricola);
            $conn -> close();
            if($result && $row = mysqli_fetch_assoc($result)){
                echo '<p>Ciao <span class = "evidenziato">'.$row['nome'].' '.$row['cognome'].'</span>:</p>';
            }
        }
    ?>
    <section aria-label="Descrizione della pagina">
    <p>In questa bacheca potrai trovare tutti gli avvisi che il politecnico ha rilasciato.<br>Clicca su un avviso per visualizzarne il contenuto.</p>
    </section>
   <!-- costruzione della tabella degli avvisi -->
    <main>
        <div id = 'dashboard-table' class='db-table'></div>
    </main>
</body>
<script src='../javascript/methods.js'></script>
<script src='../javascript/dashboard.js'></script>
</html>