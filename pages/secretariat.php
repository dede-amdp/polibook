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
    ?>
    <stection aria-label="Analisi della carriera">
        <div class="text">
        <h4><span style="font-weight:normal;">Il servizio di segreteria non è al momento disponibile.</span> </h4>
        </div>
    </section>
</body>
</html>