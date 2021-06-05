<!DOCTYPE html>
<html lang='it'>
<head>
    <title> Corso di Laurea </title>

    <link href='../css/cdl.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' >
    <meta name="description" 
          content="Questa sezione permette di visualizzare i dati dei cdl">
</head>
<body class='cdl'>
    <?php
        session_start();
        if(!isset($_SESSION['id'])){
            include '../topbar.html';
        }else{
            include '../sidenav.html';
        }
    ?>
    <div id='content'>
    <section aria-label="Descrizione del cdl">
        <div class='titolo' id='titolo'>
        </div>

        ↓ <a href="#geninf">Informazioni Generali</a><br>
        ↓ <a href="#desc">Descrizione</a><br>
        ↓ <a href="#prog">Programma</a><br>
        
        <h2><a name='geninf'>Informazioni Generali</a></h2>
        <div class='info' id='info-generali'></div>

        <h2><a name='desc'>Descrizione</a></h2>
        <div class='info' id='descrizione'></div>

        <h2><a name='prog'>Programma</a></h2>
        <div class='programma' id='programma'></div>
    </section>
    </div>
</body>
<script src='../javascript/methods.js'></script>
<script src='../javascript/cdl.js'></script>
</html>