<!DOCTYPE html> 
<html lang = 'it'>
<head>
    <title> Insegnamenti </title>
    <link href = '../css/searchPage.css' type='text/css' rel='Stylesheet'/> <!-- non ancora stato realizzato-->
    <meta name = 'viewport' 
          content = 'width=device-width, initial-scale=1.0' >
    <meta name = "description" 
          content = "Questa pagina permette all'utente di cercare e visualizzare le informazioni relative a l'offerta formativa di ciascun corso di laurea e a tutte le attività di didattiche ">
</head>

<body class= 'ricerca'>
    
    <?php
       session_start();
       if(!isset($_SESSION['id'])){
           include '../topbar.html';
       }else{
           include '../sidenav.html';
       }
    ?>

   <!-- costruzione della barra di ricerca -->

  <div classe = "riceca-insegnamenti">
 
    <div class="form-ricerca">
    <h1>Ricerca insegnamenti: </h1><br>
      
    <br><label for='anno'><b>Anno Ordinamento:</b></label><br>
    <!-- Pulsante per la scelta dell'ordinamento-->
    <button id="annobt"> --- </button>
    <div id='anno-div' class='anno-div'></div>
    <input class="input" type="hidden" name="anno" id="anno"><br>
    
    <br><label for='dipartimento'><b>Facoltà/Dipartimento:</b></label><br>
    <!-- Pulsante per la scelta della facoltà-->
    <button id="facoltabt"> --- </button>
    <div id='facolta-div' class='facolta-div'></div>
    <input class="input" type="hidden" name="dipartimento" id="dipartimento"><br>

    <br><label for='cdl'><b>Corso di Laurea:</b></label><br>
    <!-- Pulsante per la scelta del corso di laurea-->
    <button id="cdlbt"> --- </button>
    <div id="cdl-div" class="cdl-div"></div>
    <input class="input" type="hidden" name="cdl" id="cdl"><br>
      
    <br><label for='docente'><b>Docente:</b></label><br>
    <input type="text" id="docente" name="docente" class="input"><br>
       
    <br><label for='attDid'><b>Attività Didattica</b></label><br>
    <input type="text" id="attDid" name="attDid" class="input"><br>

    <button type="submit" id ="search-button"> <b>Inizia la ricerca</b> </button>
    <button id='clear'> <b>Resetta</b> </button>
  
    </div>

</div>

<div class='' id='search-res'>
</div>
</body>
<script src='../javascript/methods.js'></script>
<script src='../javascript/search.js'></script>
</html>