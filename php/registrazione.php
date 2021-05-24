<!DOCTYPE html>
    <html>
      <body>
        <form method = "post" action = "index.html">
    
    <?php
      // connessione al DB
      require_once('../php/dbh.inc.php');
      $conn = open_conn();

      //dichiarazione delle variabili 
      $matricola = $_POST['matricola'];
      $password = $_POST['password'];
      $email = $_POST['email'];
      $nome = $_POST['nome'];
      $cognome = $_POST['cognome'];
      $cf = $_POST['cf'];
      $indirizzo = $_POST['indirizzo'];
      $data_n = $_POST['data_n'];
      $foto = $_POST['foto'];

      $isMatricolaValid = filter_var(
        $matricola,
        FILTER_VALIDATE_REGEXP, [
            "options" => [ "regexp" => "/^[0-9]{6}$/i" 
            ]
          ]
      );
    
      $isPasswordValid = filter_var(
          $password,
          FILTER_VALIDATE_REGEXP, [
              "options" => ["regexp" => "/^[a-z\d_]{6,50}$/i"
              ]
          ]
       );
      
      $pwdLenght= mb_strlen($password);
      $password_hash = password_hash($password, PASSWORD_BCRYPT);



    //funzione di controllo della matricola in cui si verifica prima se questa sia già presente 
    //nel DB, e poi verificare se i valri inseriti siano una serie di sei cifre numeriche 
      
      $query = 'SELECT matricola FROM studente WHERE matricola=$matricola';

      if ($query!=null){
          echo 'La matricola inserita è già stata registrata';
        }
        elseif ($isMatricolaValid == false){
            echo 'La matricola inserita non è valida';
        }
        //controllo sulla password
            elseif($isPasswordValid != false){
              if($pwdLenght<6 || $pwdLenght>50){
                
                 echo 'Inserire una password con minimo 6 e massimo 50 caratteri';
              }
                 else {
                   $query = 'SELECT * FROM studente WHERE matricola=??';
                   $risultati = fetch_DB($conn,$query,$matricola,$password_hash, $email, $nome, $cognome, $cf, $data_n, $indirizzo, $foto);
                   $conn ->close();
                   echo 'La registrazione è avvenuta con successo';
                  
                   
        
                 }
         }

    
   
?>

           <button > Fai il login </button> 
        </form>
      </body>
    </html>
    
