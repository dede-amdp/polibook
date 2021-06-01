<!DOCTYPE html>
<html lang='it'>
<head>
    <title> Attività didattica </title>

    <link href='../css/activity.css' type='text/css' rel='Stylesheet'/>
    <meta name='viewport' 
          content='width=device-width, initial-scale=1.0' >
    <meta name="description" 
          content="Questa sezione permette di visualizzare i dati delle attività didattiche">
</head>
<body class='activity'>
    <?php
        session_start();
        if(!isset($_SESSION['id'])){
            include '../topbar.html';
        }else{
            include '../sidenav.html';
        }
    ?>
    <div id='content'>
    <section aria-label="Descrizione della attività didattica">
        <div class='titolo' id='titolo'>

        </div>
        ↓ <a href="#geninf">Informazioni Generali</a></br>
        ↓ <a href="#desc">Descrizione</a></br>
        ↓ <a href="#prog">Programma</a></br>
        <a name='geninf'><h4>Informazioni Generali</h4></a>
        <div class='info' id='info-generali'>
            
        </div>
        <a name='desc'><h4>Descrizione</h4></a>
        <div class='info' id='descrizione'>
            
        </div>
        <a name='prog'><h4>Programma</h4></a>
        <div class='programma' id='programma'>
            
        </div>
        
    </section>
    </div>
</body>
<script src='../javascript/methods.js'></script>
<script src='../javascript/activity.js'></script>
</html>