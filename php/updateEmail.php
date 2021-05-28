<?php
    require_once '../php/dbh.inc.php';
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non a effettuato il login reindirizzalo alla pagina di login
    $_SESSION['section'] = 'email'; // serve per mostrare la sezione di modifica della email in caso di errore
    $conn = open_conn();
    if($conn){
        if(isset($_POST['password']) && isset($_POST['email'])){
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $email =  mysqli_real_escape_string($conn, $_POST['email']);
            $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
            $query = 'SELECT password FROM studente WHERE matricola = ?;';
            $result = fetch_DB($conn, $query, $matricola);
            if($result){
                $fromdb = mysqli_fetch_assoc($result)['password'];
                if(password_verify($password, $fromdb)){ // verifica che la password sia corretta
                    $query = 'UPDATE studente SET email=? WHERE matricola=?;';
                    update_DB($conn, $query, $email, $matricola); // modifico l'email dell'utente
                    $_SESSION['userData_msg'] = 'Email modificata con successo'; // messaggio di successo
                    unset($_SESSION['section']); // non serve mostrare la sezione di modifica
                    // seguono vari messaggi di errore
                }else{
                    $_SESSION['userData_msg'] = 'Password errata';
                }
            }else{
                $_SESSION['userData_msg'] = 'Errore nella modifica della email, riprova più tardi';
            }
        }
        $conn -> close(); // chiude la connessione verso al db
    }
    header('Location: ../pages/profile.php'); // ritorna alla pagina del profilo
?>