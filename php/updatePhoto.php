<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try{
    require_once '../php/dbh.inc.php';
    session_start();
    if(!isset($_SESSION['id'])) header('Location: ../index.php'); // se l'utente non a effettuato il login reindirizzalo alla pagina di login
    $_SESSION['section'] = 'photo'; // serve per mostrare la sezione di modifica della foto in caso di errore
    $conn = open_conn();
    if($conn){
        if(isset($_POST['password']) && isset($_FILES['photo'])){
            if($_FILES['photo']['size'] < 16777215 && ($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/png' || $_FILES['photo']['type'] == 'image/jpg')){ // se il file ha una dimensione < 2MB e se è un'immagine
                $password = mysqli_real_escape_string($conn, $_POST['password']);
                $photo = file_get_contents($_FILES['photo']['tmp_name']); // prendi il file dalla variabile superglobale $_FILES
                $matricola = mysqli_real_escape_string($conn, $_SESSION['matricola']);
                $query = 'SELECT password FROM studente WHERE matricola = ?;';
                $result = fetch_DB($conn, $query, $matricola);
                if($result){
                    $fromdb = mysqli_fetch_assoc($result)['password'];
                    if(password_verify($password, $fromdb)){ // verifica che la password sia corretta
                        $query = 'UPDATE studente SET foto=? WHERE matricola=?;';
                        if(update_DB($conn, $query, $photo, $matricola)){// modifico la foto dell'utente
                            $_SESSION['userData_msg'] = 'Foto profilo modificata con successo'; // messaggio di successo
                            unset($_SESSION['section']); // non serve mostrare la sezione di modifica
                        }else{
                            $_SESSION['userData_msg'] = 'Non è stato possibile inserire l\' immagine';
                        }
                        // seguono vari messaggi di errore
                    }else{
                        $_SESSION['userData_msg'] = 'Password errata';
                    }
                }else{
                    $_SESSION['userData_msg'] = 'Errore nella modifica della foto profilo, riprova più tardi';
                }
            }else{
                $_SESSION['userData_msg'] = 'La dimensione o il tipo del file non sono corretti';
            }
        }else{
            $_SESSION['userData_msg'] = 'Sembra che alcuni dati non siano stati iserito in modo corretto';
        }
        $conn -> close(); // chiude la connessione al db
    }
    header('Location: ../pages/profile.php'); // ritorna alla pagina del profilo
}catch(mysqli_sql_exception $e){
    session_start();
    $_SESSION['userData_msg'] = 'Errore nella modifica della foto profilo: controlla che il file inserito sia di un formato corretto';
}finally{
    header('Location: ../pages/profile.php'); // ritorna alla pagina del profilo
}
?>