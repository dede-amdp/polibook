
<?php
  // connessione al DB
  require_once('../php/dbh.inc.php');
  $conn = open_conn();

  //dichiarazione delle variabili 

  $password = mysqli_real_escape_string($conn,$_POST['password']);
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $nome = mysqli_real_escape_string($conn,$_POST['nome']);
  $cognome = mysqli_real_escape_string($conn,$_POST['cognome']);
  $cf = mysqli_real_escape_string($conn,$_POST['cf']);
  $indirizzo = mysqli_real_escape_string($conn,$_POST['indirizzo']);
  $data_n = mysqli_real_escape_string($conn,$_POST['data_n']);
  $foto = mysqli_real_escape_string($conn,$_POST['foto']);

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
  
  $query = 'SELECT max(matricola) as max FROM studente';
  $result = fetch_DB($conn, $query);
  $matricola = '000001';
  if ($result && $max = mysqli_fetch_assoc($result)){
      $matricola = str_pad ($max['max'] + 1, 6, '0', STR_PAD_LEFT);
  }
    //controllo sulla password
          if($isPasswordValid != false){

              if($pwdLenght<6 || $pwdLenght>50){
            
              echo 'Inserire una password con minimo 6 e massimo 50 caratteri';
          }
              else {
              $table = 'studente (matricola,password,email,nome,cognome,cf,data_nascita,indirizzo,foto)';
              $risultati = insert_DB($conn,$table,$matricola,$password_hash, $email,$nome,$cognome,$cf,$data_n,$indirizzo,$foto);
              $conn ->close();
              session_start();
              $_SESSION['error_msg'] = 'La registrazione è avvenuta con successo';
              header('Location: ../index.php');
            }
      }
?>

