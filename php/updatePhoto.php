<?php
    require_once '../php/dbh.inc.php';
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non a effettuato il login reindirizzalo alla pagina di login
    $_SESSION['section'] = 'photo'; // serve per mostrare la sezione di modifica della foto in caso di errore
    $conn = open_conn();
    if($conn){
        if(isset($_POST['password']) && isset($_FILES['photo'])){
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $photo = file_get_contents($_FILES['photo']['tmp_name']); // prendi il file dalla variabile superglobale $_FILES
            $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
            $query = 'SELECT password FROM studente WHERE matricola = ?;';
            $result = fetch_DB($conn, $query, $matricola);
            if($result){
                $fromdb = mysqli_fetch_assoc($result)['password'];
                if(password_verify($password, $fromdb)){ // verifica che la password sia corretta
                    $query = 'UPDATE studente SET foto=? WHERE matricola=?;';
                    update_DB($conn, $query, $photo, $matricola); // modifico la foto dell'utente
                    $_SESSION['userData_msg'] = 'Foto profilo modificata con successo'; // messaggio di successo
                    unset($_SESSION['section']); // non serve mostrare la sezione di modifica
                    // seguono vari messaggi di errore
                }else{
                    $_SESSION['userData_msg'] = 'Password errata';
                }
            }else{
                $_SESSION['userData_msg'] = 'Errore nella modifica della foto profilo, riprova più tardi';
            }
        }
        $conn -> close(); // chiude la connessione al db
    }
    header('Location: ../pages/profile.php'); // ritorna alla pagina del profilo
?>