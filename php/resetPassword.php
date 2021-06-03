<?php
    // script per resettare la password
    session_start();
    if(isset($_POST['email'])){
        require_once '../php/dbh.inc.php';
        $conn = open_conn();
        if($conn){
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $query = 'SELECT matricola FROM studente WHERE email = ?;';
            $result = fetch_DB($conn, $query, $email);
            if($result && $mat = mysqli_fetch_assoc($result)){
                // genera la password casuale
                $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $new_pass = '';
                for($i = 0; $i < 30; $i++){ // password da 30 caratteri
                    $index = rand(0, 36);
                    $new_pass .= $chars[$index];
                }
                $oggetto = 'Password Temporanea';
                $messaggio = "Ecco la tua password temporanea:\n$new_pass";
                $query = 'UPDATE studente SET password=? WHERE matricola=?;';
                // invia l'email
                $result = update_DB($conn, $query, password_hash($new_pass, PASSWORD_BCRYPT), $mat['matricola']);
                if($result){
                    mail($email, $oggetto, $messaggio,'From: noreply@polibooklet.com');
                    $_SESSION['error_msg'] = 'Una Password temporanea è stata inviata alla email indicata'; // notifica di successo
                }else{
                    $_SESSION['error_msg'] = 'Non è stato possibile resettare la password';
                }
            }else{
                $_SESSION['error_msg'] = 'La mail inserita non è presente nel database.';
            }
        }else{
            $_SESSION['error_msg'] = 'Errore di connessione al database';
        }
    }else{
        $_SESSION['error_msg'] = 'Sei sicuro di aver inserito una mail?';
    }
    header('Location: ../index.php');
?>