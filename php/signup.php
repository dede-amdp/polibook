<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
  // connessione al DB
  try{
    require_once('../php/dbh.inc.php');
    session_start();
    $conn = open_conn();
    echo 'email non ancora inviata';
    if($conn){
      //dichiarazione delle variabili 
      $password = mysqli_real_escape_string($conn,$_POST['password']);
      $email = mysqli_real_escape_string($conn,$_POST['email']);
      $nome = mysqli_real_escape_string($conn,$_POST['nome']);
      $cognome = mysqli_real_escape_string($conn,$_POST['cognome']);
      $cf = mysqli_real_escape_string($conn,$_POST['cf']);
      $indirizzo = mysqli_real_escape_string($conn,$_POST['indirizzo']);
      $data_n = mysqli_real_escape_string($conn,$_POST['data_n']);

      if(isset($_FILES['foto'])){
        if($_FILES['foto']['size'] < 16777215 && ($_FILES['foto']['type'] == 'image/jpeg' || $_FILES['foto']['type'] == 'image/png' || $_FILES['foto']['type'] == 'image/jpg')){
          $foto = file_get_contents($_FILES['foto']['tmp_name']);
          // verifico che la password sia in un formato corretto e di lunghezza minima 6 e massima 50
          $isPasswordValid = filter_var(
            $password,
            FILTER_VALIDATE_REGEXP, [
                "options" => ["regexp" => "/^[a-z\d_]{6,50}$/i"
                ]
            ]
          );

          $pwdLenght= mb_strlen($password);
          $password_hash = password_hash($password, PASSWORD_BCRYPT);

          // controlla che lo studente non sia già iscritto
          $query = 'SELECT cf FROM studente WHERE cf=?';
          $result = fetch_DB($conn, $query, $cf);
          if($result && $studente = mysqli_fetch_assoc($result)){ // se c'è un risultato
            $_SESSION['error_msg'] = 'Uno studente con questo codice fiscale risulta già iscritto';
            header('Location: ../index.php');
          }else{
          // Assegna una nuova matricola allo studente basandosi sull'ultima inserita nel database
            $query = 'SELECT max(matricola) as max FROM studente';
            $result = fetch_DB($conn, $query);
            $matricola = '000001';
            if ($result && $max = mysqli_fetch_assoc($result)){
                $matricola = str_pad ($max['max'] + 1, 6, '0', STR_PAD_LEFT);
            }
            //controllo sulla password
            if($isPasswordValid != false){
              if($pwdLenght<6 || $pwdLenght>50){
                $_SESSION['error_msg'] = 'Inserire una password con minimo 6 e massimo 50 caratteri';
              }else {
                //inserimento del nuovo studente nel database: lo studente NON è iscritto all'università al momento dell'iscrizione
                // invio la mail di conferma all'utente
                $oggetto =  'Conferma registrazione';
                $messaggio =  "Ecco la matricola per accedere a POLIBOOK\nMATRICOLA:\t$matricola";
                if(mail($email,$oggetto,$messaggio, 'From: noreply@polibooklet.com')){
                  $table = 'studente (matricola,password,email,nome,cognome,cf,data_nascita,indirizzo,foto)';
                  $risultati = insert_DB($conn,$table,$matricola,$password_hash, $email,$nome,$cognome,$cf,$data_n,$indirizzo,$foto);
                  $conn ->close();
                  $_SESSION['error_msg'] = 'La registrazione è avvenuta con successo.\nUna mail di conferma è stata inviata alla email inserita contenente la matricola per accedere al libretto online';
                  header('Location: ../index.php');
                }else{
                    $_SESSION['error_msg'] = 'Non è stato possibile inviare l\'email di conferma';
                }
              }
            }
          }
        }else{
          $_SESSION['error_msg'] = 'La dimensione o il tipo della foto profilo non sono corretti';
        }
      }else{
        $_SESSION['error_msg'] = 'Errore durante la registrazione, riprova più tardi';
      }
    }else{
      // errore nella connessione al database
      $_SESSION['error_msg'] = 'Errore durante la registrazione, riprova più tardi';
    }
    header('Location: ../index.php');
  }catch(Exception $e){
    session_start();
    $_SESSION['error_msg'] = 'Errore durante la registrazione, riprova più tardi';
  }catch(mysqli_sql_exception $e){
    session_start();
    $_SESSION['error_msg'] = 'Errore durante la registrazione, riprova più tardi';
  }finally{
    header('Location: ../index.php');
  }
?>