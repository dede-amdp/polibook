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
            $query = 'SELECT nome, cognome FROM studente WHERE matricola=?';
            $result = fetch_DB($conn, $query, $matricola);
            $conn -> close();
            if($result && $row = mysqli_fetch_assoc($result)){
                echo '<p> Ciao  <font color=\'#009999\'>'.$row['nome'].' '.$row['cognome'];'</font></br>
                          In questa bacheca potrai trovare tutti gli avvisi che il politecnico ha rilasciato.<br>
                          Clicca su un avviso per visualizzare il contenuto. </p>
                      
                      ';
            }
        }
    ?>

   <!-- costruzione della tabella degli avvisi -->

  <div classe = 'tabellone-avvisi'>
  
  
  <?php
  
  $avvisi = getAvvisi();
    foreach ($avvisi as $avviso){
        $data = $avviso['timestamp'];
        $titolo = $avviso['titolo'];
        $contenuto = $avviso['contenuto'];
        echo '  <div class= "avviso">
        <div class = "headingAvviso">$data <b> $titolo </b>  <span onclick="document.getElementById("id01").style.display="block"" class="mex" title="Open Mex">&plus;</span></div>
        <div class = "mex"> $contenuto </div>
        </div>
      ';
    }
  
  
  
  ?>


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