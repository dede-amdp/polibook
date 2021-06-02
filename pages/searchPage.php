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
      
    <br><label><b>Anno Ordinamento:</b></label><br>
    <!--input type="text" id="anno" name="anno">-->
    <button id="annobt"> --- </button>
    <div id='anno-div' class='anno-div'></div>
    <input class="input" type="hidden" name="anno" id="anno"><br>
    
    <br><label><b>Facoltà/Dipartimento:</b></label><br>
    <!--input type="text" id="dipartimento"  name="dipartimento"-->
    <button id="facoltabt"> --- </button>
    <div id='facolta-div' class='facolta-div'></div>
    <input class="input" type="hidden" name="dipartimento" id="dipartimento"><br>
      
    <br><label><b>Docente:</b></label><br>
    <input type="text" id="docente" name="docente" class="input"><br>
       
    <br><label><b>Attività Didattica</b></label><br>
    <input type="text" id="attDid" name="attDid" class="input"><br>

    <button type="submit" id ="search-button"> <b>Inizia la ricerca</b> </button>
    <button id='clear'> <b>Resetta</b> </button>
  
    </div>

    
</div>

<div class= "risultati ricerca" id='search-res'>
</div>
</body>
<script src='../javascript/methods.js'></script>
<script src='../javascript/search.js'></script>
</html>