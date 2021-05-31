<?php
    require_once '../php/dbh.inc.php';
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non ha effettuato il login, reindirizzalo alla pagina del login
    $_SESSION['section'] = 'password'; // in caso di errore lascia visibile la sezione di modifica della password
    $conn = open_conn();
    if($conn){
        if(isset($_POST['old_p']) && isset($_POST['new_p']) && isset($_POST['confirm_p'])){
            $new = mysqli_real_escape_string($conn, $_POST['new_p']);
            $old =  mysqli_real_escape_string($conn, $_POST['old_p']);
            $confirm =  mysqli_real_escape_string($conn, $_POST['confirm_p']);
            // verifica che la password sia valida
            $isPasswordValid = filter_var(
                $new,
                FILTER_VALIDATE_REGEXP, [
                    "options" => ["regexp" => "/^[a-z\d_]{6,50}$/i"
                    ]
                ]
              );
            if($isPasswordValid){
                if($new == $confirm){ // verifica se la password corrisponde alla password inserita per conferma
                    $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
                    $query = 'SELECT password FROM studente WHERE matricola = ?;';
                    $result = fetch_DB($conn, $query, $matricola);
                    if($result){
                        $fromdb = mysqli_fetch_assoc($result)['password'];
                        if(password_verify($old, $fromdb)){ // verifica la password
                            $new_crypted = password_hash($new, PASSWORD_BCRYPT);
                            $query = 'UPDATE studente SET password=? WHERE matricola=?;';
                            if(update_DB($conn, $query, $new_crypted, $matricola)){ // modifica la password dell'utente
                                $_SESSION['userData_msg'] = 'Password modificata con successo'; // messaggio di successo
                                unset($_SESSION['section']); // non serve mostrare la sezione di modifica
                            }else{
                                $_SESSION['userData_msg'] = 'Non è stato possibile modificare la password';
                            }
                            // seguono messaggi di errore
                        }else{
                            $_SESSION['userData_msg'] = 'Password errata';
                        }
                    }else{
                        $_SESSION['userData_msg'] = 'Errore nella modifica della password, riprova più tardi';
                    }
                }else{
                    $_SESSION['userData_msg'] = 'La password di conferma è diversa da quella inserita';
                }
            }else{
                $_SESSION['userData_msg'] = 'La nuova password non è valida';
            }
        }
        $conn -> close(); // chiude la connessione al db
    }
    header('Location: ../pages/profile.php'); // ritorna alla pagina del profilo
?>