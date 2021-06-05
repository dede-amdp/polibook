<!DOCTYPE html>
<html lang='it'>

    <head>
        <title> Carriera </title>
        <link href='../css/career.css' type='text/css' rel='Stylesheet'/>
        <meta name='viewport' 
            content='width=device-width, initial-scale=1.0' >
        <meta name="description" 
            content="Questa pagina visualizza la situazione dello studente in relazione alle regole previste dal proprio percorso formativo">
    </head>

    <body class="career">
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
                    echo '<p> Analisi della carriera di: <span class = "evidenziato">'.$row['nome'].' '.$row['cognome'].'</span><br>';
                }
            }
        ?>
        
        <section aria-label="Analisi della carriera">
            <div class="text">
                <h4><span style="font-weight:normal;"> Questa pagina visualizza la situazione dello studente in relazione alle regole previste dal percorso formativo intrapreso nell'ateneo.<br>
                    Ogni riga nella tabella rappresenta un certo tipo di crediti che lo studente deve ottenere mediante le attività didattiche.<br>
                    Quando tutti i crediti richiesti sono ottenuti, lo studente può conseguire il titolo previsto dal corso di studio.</span>
                </h4>
            </div> 
                <table id='career-table' class="table" border = 2px>
                </table>
        </section>
    </body>
        <script src='../javascript/methods.js'></script>
        <script src='../javascript/career.js'></script>
</html>