<!DOCTYPE html>
<html lang='it'>
<?php
    session_start();
    if(isset($_SESSION['error_msg'])){ // se contiene un messaggio
        $message = $_SESSION['error_msg'];
        unset($_SESSION['error_msg']); // togle il messaggio di errore dalla sessione
        echo "<script type='text/javascript'>window.onload = function() {alert('$message');};</script>"; // mostra il messaggio in alto
    }
?>
<head>
    <title> Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='./css/login.css' rel='Stylesheet' type='text/css'>
    <meta name="description" 
          content="Questa pagina permette di effettuare il login e la registrazione al sito">
</head>
<body src="./assets/poliba_backgr.png">
    <!-- prima pagina del login al portale -->
 <div class = "box">
     
    <form  action="./php/login.php" method="post"> 
        
        <!-- intestazione con logo  -->
        <div class="header">
        <h2> <span style= 'color:#058394'> LOGIN </span> </h2>
       
        <p class="imgcontainer">
        <img src="./assets/poliba_logo.svg" alt="logo" class="logo">
        <p>
        </div>
   

        <div class = 'container'>
            <!--Campi necessari pe inseirire i dati-->
            <br><label for="matricola"><b>Matricola</b></label>
            <input type="text" placeholder="Inserire la Matricola" name="matricola" required>

            <br><label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Inserire la Password" name="password" required>
        
            <br><button type="submit"> Login </button>
            <button type="button" onclick="document.getElementById('id01').style.display='block'"> Registrati </button>
            
            <br><label>
                <input type="checkbox" checked="checked" name="remember"> Ricordami
            </label>
            <br><span class="psw">Forgot <a href="/php/resetPassword.php">password?</a></span>
        
        </div>
    
    </form>

</div>

                                    <!-- form per la registrazione --> 

<div id="id01" class="modal">
    <form class="modal-content animate" action = "./php/registrazione.php" method="post">
        <div class="imgcontainer">
           <img src="./assets/poliba_logo.svg" alt="logo" class="logo">
           <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        </div>
        <div>
        
        </div>
        
    <div class="container">
    <p align=center><font color=#009999><b>REGISTRATI A POLIBOOK</b></font></p>
    <p>Compila i seguenti campi per eseguire la registrazione: tutti i campi sono <font color=#009999><b>obbligatori</b></font>.</br>
    L'iscrizione a <font color=#009999><b>POLIBOOK</b></font> NON comporta l'iscrizione al <font color=#009999><b>Politecnico di Bari</b></font>: essa dovrà essere effettuata a seguito del superamento del <font color=#009999><b>test d'ingresso</b></font>.</br>
    <b>Il trattamento dei dati personali richiesti è finalizzato alla gestione della carriera universitaria: il conferimento di tali dati è obbligatorio ai fini della gestione della carriera universitaria.</b></p>
    <br><label><b>Nome </b></label>
    <input type="text" id="nome" placeholder="Inserire il nome" name="nome" maxlength='50' required>
      
    <br><label><b>Cognome</b></label>
    <input type="text" id="cognome" placeholder="Inserire il cognome" name="cognome" maxlength='50' required>
    
    <br><label><b>Codice Fiscale</b></label>
    <input type="text" id="cf" placeholder="Inserire il Codice Fiscale" name="cf" size='16' required>
      
    <br><label><b>Password</b></label>
    <input type="password" id="password" placeholder="Inserire la password" name="password" required>
       
    <br><label><b>Email</b></label>
    <input type="email" id="email" placeholder="...@esempio.com" name="email" required>
      
    <br><label><b>Data di Nascita</b></label>
    <input type="date" id="data_n" placeholder="Data di nascita" name="data_n" required>
      
    <br><label><b>Indirizzo di Residenza</b></label>
    <input type="text" id="indirizzo" placeholder="Indirizzo" name="indirizzo" maxlength='100' required>
      
    <br><label><b>Foto</b></label>
    <input type="file" accept='image'id="foto" name="foto" required>
    <button type="submit" name ="registrati"> Registrati </button> 
    </div>

    </form>

</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>