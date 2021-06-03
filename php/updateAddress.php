<?php
    require_once '../php/dbh.inc.php';
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non ha effettuato il login, rimandalo alla pagina del login
    $_SESSION['section'] = 'address'; // indico quale form deve rimanere aperto nel caso di errore
    $conn = open_conn();
    if($conn){
        if(isset($_POST['password']) && isset($_POST['address'])){
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $email =  mysqli_real_escape_string($conn, $_POST['address']);
            $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
            $query = 'SELECT password FROM studente WHERE matricola = ?;';
            $result = fetch_DB($conn, $query, $matricola);
            if($result){
                $fromdb = mysqli_fetch_assoc($result)['password'];
                if(password_verify($password, $fromdb)){ // verifica che la password inserita sia corretta
                    $query = 'UPDATE studente SET indirizzo=? WHERE matricola=?;';
                    if(update_DB($conn, $query, $email, $matricola)){ // aggiorna l'indirizzo email dell'utente
                        $_SESSION['userData_msg'] = 'Indirizzo modificato con successo'; // messaggio da mostrare
                        unset($_SESSION['section']); // rimuove questo valore perchè non serve che la sezione di modifica della email sia aperta
                    }else{
                        $_SESSION['userData_msg'] = 'Non è stato possibile modificare l\'indirizzo';
                    }
                    // in seguito troviamo vari messaggi d'errore
                }else{
                    $_SESSION['userData_msg'] = 'Password errata';
                }
            }else{
                $_SESSION['userData_msg'] = 'Errore nella modifica dell\'indirizzo, riprova più tardi';
            }
        }
        $conn -> close(); // chiudo la connessione con il db
    }
    header('Location: ../pages/profile.php'); // ritorno alla pagina del profilo
?>